<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use App\Models\Article;
use App\Models\Comment;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/verifyInfo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        activity('show')->log('Register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'age' => ['required'],
            'gender' => ['required'],
            'motherTongue' => ['required'],
            'education' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $canBeContacted = $data['canBeContacted'] == "on" ? true : false;

        $info = [
            'age' => $data['age'],
            'gender' => $data['gender'],
            'motherTongue' => $data['motherTongue'],
            'education' => $data['education'],
            'howHere' => $data['howHere'],
        ];

        // $sources = [
        //     'De Morgen' => true,
        //     'De Standaard' => true,
        //     'VRT' => true,
        // ];

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'information' => json_encode($info),
            'sources' => '{"De Morgen":true,"De Standaard":true, "De Tijd": true, "Gazet van Antwerpen": true, "Het Belang van Limburg": true, "Het Laatste Nieuws":true, "Het Nieuwsblad":true, "VRT":true, "VTM":true}',
            'can_be_contacted' => $canBeContacted,
            'user_group' => "B",
        ]);

        // Setup tutorial article.
        $tutorial = Article::find('tutorial');

        $newTutorial = $tutorial->replicate();
        $newTutorial->article_id = 'tutorial-' . $user->id;
        $newTutorial->save();

        for ($i=1; $i <= 5; $i++) { 
            $comment = Comment::find($i);
            $newComment = $comment->replicate();
            $newComment->article_id = 'tutorial-' . $user->id;
            $newComment->save();
        }

        return $user;
    }
}
