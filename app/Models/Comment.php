<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'user_id', 'text', 'type', 'associated_text_id', 'upvotes', 'downvotes', 'parent_id',
    ];

    // public function messages()
    // {
    //     return [
    //         'comment.required' => 'Een opmerking is verplicht',
    //         'article_id.required'  => 'A message is required',
    //     ];
    // }
}
