<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Score;
use App\Models\Vote;
use App\Models\Challenge;
use App\Models\Toast;
use App\User;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        activity('show')->log('Show list of articles of type ' . $type);
        
        $articles = Article::where('score', $type)->where('is_tutorial', false)->orderBy("published_on", 'desc')->take(100)->get();
        $most_read = Article::mostRead();
        
        return view('article.index')->with('articles', $articles)->with('most_read', $most_read);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        activity('show')->withProperties(['ip' => $_SERVER['REMOTE_ADDR']])->performedOn(Article::findOrFail($id))->log('Article');

        // Give the reading user extra reputation.
        auth()->user()->changeReputationRead();

        // Set user specific tutorial.
        if ($id == "tutorial") {
            $id = "tutorial-" . auth()->user()->id;
        }

        $article = Article::findOrFail($id);
        $comments = DB::table('comments')
                            ->join('users', 'comments.user_id', '=', 'users.id')
                            ->select('comments.*', 'users.firstname', 'users.lastname')
                            ->where('article_id', $id)->orderBy('comments.created_at')->get();

        foreach ($comments as $comment) {
            activity('show')->on(Comment::find($comment->id))->by(User::find($comment->user_id))->log('Loaded comment');
        }
        
        $first = Score::all()->where('article_id', $id)->where('user_id', auth()->user()->id)->first();
        if ($first) {
            $score = $first->value;
        } else {
            $score = 'N';
        }
        
        $votes = Vote::all()->where('user_id', auth()->user()->id);

        if (session()->get('show_gamification')) {
            if(session()->get('userType') == "Achiever") {
                $messages = Challenge::getViewMessage(auth()->user()->id);
                if ($messages != null) {
                    $toasts = [];
                    foreach ($messages as $message) {
                        array_push($toasts, new Toast($message));
                    }
                    \Session::now('toasts', $toasts); 
                }
            }
        }
            

        return view('article.show')
                ->with('article', $article)
                ->with('comments', $comments)
                ->with('score', $score)
                ->with('votes', $votes);
    }
}
