<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Article;
use App\User;

class Score extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'user_id'
    ];

    public static function updateArticleScore($article_id) {
        $scores = Score::all()->where("article_id", $article_id);
        $total = 0;
        foreach ($scores as $score) {
            $score->value = Score::translateScore($score->value);
            $user = User::find($score->user_id);
            $total += $user->reputation;
        }

        // If two much people from a low score vote, do not update the value.
        // 1.5 means that 3 normal people should vote
        if ($total > 1.5) {
            $median = Score::translateScore(round($scores->median("value")));
            $article = Article::find($article_id);
            $article->score = $median;
            $article->save();
        }
    }

    private static function translateScore($score) {
        if (is_string($score)) {
            switch ($score) {
                case 'Fake':
                    $score = 0;
                    break;

                case 'F':
                    $score = 1;
                    break;
                    
                case 'MF':
                    $score = 2;
                    break;
                
                case 'HT':
                    $score = 3;
                    break;
                
                case 'MT':
                    $score = 4;
                    break;

                case 'T':
                    $score = 5;
                    break;
                
                default:
                    throw "value unknown";
                    break;
            }
        } else {
            switch ($score) {
                case 0:
                    $score = 'Fake';
                    break;

                case 1:
                    $score = 'F';
                    break;
                    
                case 2:
                    $score = 'MF';
                    break;
                
                case 3:
                    $score = 'HT';
                    break;
                
                case 4:
                    $score = 'MT';
                    break;

                case 5:
                    $score = 'T';
                    break;
                
                default:
                    throw "value unknown";
                    break;
            }
        }
        return $score;
    }
}
