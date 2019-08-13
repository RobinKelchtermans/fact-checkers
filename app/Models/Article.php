<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'title', 'description', 'content', 'author', 'published_on', 'source', 'picture_link', 'url', 'score',
    ];

    protected $primaryKey = 'article_id';
    public $incrementing = false;

    public static function mostRead() {
        $viewed_articles = \Activity::where('log_name', 'show')
                ->where('description', 'Article')
                ->orderBy('created_at', 'desc')
                ->take(500)
                ->get();

        $grouped_articles = collect($viewed_articles)->groupBy('subject_id')->map(function ($el) {
            $n = $el->count();
            $article = Article::find($el[0]->subject_id);
            if ($article == null) {
                return 0;
            }
            $hours = round((time() - strtotime($article->published_on)) / (60 * 60 * 3)) + 1;
            if ($hours < 1) $hours = 1;
            return $n/$hours;
        })->sortByDesc(function($value) {
            return $value;
        })->take(5);

        $most_read = [];
        foreach ($grouped_articles as $key => $value) {
            $article = Article::find($key);
            if ($article != null) {
                array_push($most_read, $article);                
            }
        }
        return $most_read;
    }
}