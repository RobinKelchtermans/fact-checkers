<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Challenge;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }

    public function index()
    {
        activity('show')->withProperties(['ip' => $_SERVER['REMOTE_ADDR']])->log('Profile');

        $viewed_articles = \Activity::all()
                            ->where('causer_id', auth()->user()->id)
                            ->where('log_name', 'show')
                            ->where('description', 'Article')
                            ->sortByDesc('created_at')
                            ->unique('subject_id')
                            ->take(6);
        $articles = [];
        foreach ($viewed_articles as $viewed_article) {
            $article = Article::find($viewed_article->subject_id);
            if ($article != null) {
                array_push($articles, $article);
            }
        }

        $viewed_comments = \Activity::all()
                ->where('causer_id', auth()->user()->id)
                ->where('log_name', 'show')
                ->where('description', 'Loaded comment')
                ->sortByDesc('created_at');

        $grouped_comments = collect($viewed_comments)->groupBy('subject_id')->map(function ($el) {
            return $el->count();
        })->take(10)->sortByDesc(function($value) {
            return $value;
        });

        $comments = [];
        foreach ($grouped_comments as $key => $value) {
            $comment = Comment::find($key);
            if ($comment != null) {
                $comment->reach = $value;
                array_push($comments, $comment);
            }            
        }

        $challenges = Challenge::getAll(auth()->user()->id);
        $leaderbord = User::all()->where('id', '>', 1)->sortByDesc('reputation')->take(10);

        return view('profile.index')
                    ->with('articles', $articles)
                    ->with('comments', $comments)
                    ->with('challenges', $challenges)
                    ->with('leaderbord', $leaderbord);
    }

    public function updateAvatar(Request $request) {
        $path = $request->file('avatar')->storeAs(
            'public/avatars', 'user_' . $request->user()->id
        );
        $user = $request->user();
        $custom = json_decode($user->custom);
        if ($custom == null) {
            $custom = (object) [];
        }
        $custom->avatar_path = $path;
        $user->custom = json_encode($custom);
        $user->save();

        // $imagePath = $request->file('image')->store('public');
        // $image = Image::make(Storage::get($imagePath))->resize(320,240)->encode();
        // Storage::put($imagePath,$image);

        // $imagePath = explode('/',$imagePath);

        // $imagePath = $imagePath[1];

        return back()->with('success', 'Je profielfoto werd aangepast!');
    }

    public function addCanBeContacted() {
        $user = auth()->user();
        $user->can_be_contacted = 1;
        $user->save();
        return redirect('/');
    }

    public function toggleComments()
    {
        if (\Cookie::get('show_comments') == "1") {
            $value = "0";
        } else {
            $value = "1";
        }
        \Cookie::queue('show_comments', $value, 60*24*28);

        activity('cookie')->log('Changed show comments cookie to ' . $value);
        return \Cookie::get('show_comments');
    }

    public function updatePassword(Request $request) {
        activity('update')->log('Updating user password');
        if(Auth::Check()) {
            $request_data = $request->All();
            $messages = [
                'current-password.required' => 'Please enter current password',
                'password.required' => 'Please enter password',
            ];
        
            $validator = Validator::make($request_data, [
                'current-password' => 'required',
                'password' => 'required|min:6|same:password',
                'password_confirmation' => 'required|same:password',     
            ], $messages);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors(['Je nieuw wachtwoord moet minstens 6 karakters zijn en tweemaal hetzelfde.']);
            }
            else {  
                $current_password = Auth::User()->password;           
                if(Hash::check($request_data['current-password'], $current_password)) {           
                    $user_id = Auth::User()->id;                       
                    $obj_user = User::find($user_id);
                    $obj_user->password = bcrypt($request_data['password']);;
                    $obj_user->save(); 
                    return redirect()->back()->with('success', 'Je wachtwoord werd aangepast!');
                }
                else {           
                    $error = array('current-password' => 'Je huidig wachtwoord is fout.');
                    return redirect()->back()->withErrors([$error]);
                }
            }        
        }
        else {
            return redirect()->back()->withErrors(['error']);
        }    
    }

    public function giveFeedback(Request $request) {
        activity('feedback')->log($request['feedback']);
        return redirect()->back()->with('success', 'Bedankt voor je input!');
    }
}
