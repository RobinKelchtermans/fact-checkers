<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Feeds;
use Auth;

use App\Mail\TestMail;
use App\Models\Article;
use App\Models\Toast;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('guest');
    }

    public function index()
    {
        activity('show')->withProperties(['ip' => $_SERVER['REMOTE_ADDR']])->log('Index');

        if (Auth::guest()) {
            return view('index');
        }

        if (auth()->user()->survey_hexad == null) {
            return view('surveys.hexad');
        }
        if (auth()->user()->survey_media == null) {
            return view('surveys.media');
        }

        $sources = [
            "Fake",
        ];

        $user_sources = json_decode(auth()->user()->sources);

        foreach ($user_sources as $key => $value) {
            if ($value) {
                array_push($sources, $key);
            }
        }

        // Only take the first 100 articles.
        $articles = Article::whereIn('source', $sources)->orderBy("published_on", 'desc')->take(100)->get();
        $tutorial_article = Article::where('article_id', 'tutorial-' . auth()->user()->id)->get();
        $most_read = Article::mostRead();

        return view('article.index')->with('articles', $articles)->with('tutorial_article', $tutorial_article)->with('most_read', $most_read);
    }
}
