<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Score;
use App\Models\Article;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $request->user()->id;
        $article_id = $request->id;
        $value = $request->value;

        $score = Score::firstOrNew([
            'article_id' => $article_id,
            'user_id' => $user_id
        ]);

        // If new, give extra reputation to user.
        if (!$score->exists) {
            $request->user()->changeReputationScoreVote();
            activity('create')->performedOn(Article::find($article_id))->log('Score');
        } else {
            activity('update')->performedOn(Article::find($article_id))->log('Score');
        }

        $score->value = $value;
        $score->save();


        Score::updateArticleScore($article_id);

        
        return "OK";
    }

}
