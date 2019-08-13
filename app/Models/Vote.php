<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Vote extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id', 'user_id', "value"
    ];

    public static function updateCommentVotes($comment_id) {
        $votes = Vote::all()->where("comment_id", $comment_id);
        $upvotes = 0;
        $downvotes = 0;
        foreach ($votes as $vote) {
            if ($vote->value == 1) {
                $upvotes++;
            }
            if ($vote->value == -1) {
                $downvotes++;
            }
        }
        
        $comment = Comment::find($comment_id);
        $comment->upvotes = $upvotes;
        $comment->downvotes = $downvotes;
        $comment->save();
    }
}
