<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Vote;
use App\Models\Comment;

class VoteController extends Controller
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
        $comment_id = $request->id;
        $value = $request->value;

        if ($value == 'upvote') {
            $value = 1;
        } 
        elseif ($value == 'downvote') {
            $value = -1;
        } 
        else {
            $value = 0;
        }

        $vote = Vote::firstOrNew([
            'comment_id' => $comment_id,
            'user_id' => $user_id
        ]);
        $vote->value = $value;
        $vote->save();

        activity('update')->performedOn(Comment::find($comment_id))->log('Vote');

        Vote::updateCommentVotes($comment_id);

        $comment = Comment::find($comment_id);

        $user = User::find($comment->user_id);
        if ($value == 1) {
            $user->changeReputationUpvote();
        } 
        else {
            $user->changeReputationDownvote();
        }

        return ($comment->upvotes - $comment->downvotes);
    }

}
