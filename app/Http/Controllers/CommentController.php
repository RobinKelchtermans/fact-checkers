<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Challenge;
use App\Models\Article;
use App\Models\Toast;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'comment' => 'required|string|min:3|max:50000',
            'article_id' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        $comment = Comment::create([
            'article_id' => $request->article_id,
            'user_id' => $request->user_id,
            'text' => $request->comment,
            'type' => $request->type,
            'associated_text_id' => $request->associated_text_id,
            'parent_id' => $request->parent_id,
            'upvotes' => 0,
            'downvotes' => 0,
        ]);

        if ($request->article_text != null) {
            $article = Article::findOrFail($request->article_id);
            $article->content = $request->article_text;
            $article->save();
        }

        activity('create')->performedOn(Comment::findOrFail($comment->id))->withProperties([ 'text' => $request->comment ])->log('Comment');

        if (session()->get('show_gamification')) {
            if(session()->get('userType') == "Achiever") {
                $messages = Challenge::getCommentMessage(auth()->user()->id);
                if ($messages != null) {
                    $toasts = [];
                    foreach ($messages as $message) {
                        array_push($toasts, new Toast($message));
                    }
                    \Session::flash('toasts', $toasts); 
                }
            }
        }

        return redirect()->to('/article/' . $request->article_id . '#comment-' . $comment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        activity('delete')->performedOn(Comment::findOrFail($comment->id))->log('Comment deleted.');
        if ($request->article_text != null && $request->article_text != "") {
            $article = Article::findOrFail($request->article_id);
            $article->content = $request->article_text;
            $article->save();
        }
        Comment::destroy($comment->id);
        return redirect()->back();
    }
}
