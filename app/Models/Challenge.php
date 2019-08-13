<?php

namespace App\Models;

class Challenge
{

    private static $messages = [];

    public static function getAll($user_id) {
        $last24Hours = now('Europe/Brussels')->subDay()->format('Y-m-d h:i:s');
        $today = today('Europe/Brussels');

        $viewed_articles = \Activity::all()
                                    ->where('causer_id', $user_id)
                                    ->where('log_name', 'show')
                                    ->where('description', 'Article')
                                    ->sortByDesc('created_at')
                                    ->unique('subject_id');
        $total_viewed_articles = count($viewed_articles);
        $total_viewed_articles_today = count($viewed_articles->where('created_at', '>', $today));

        $created_comments = \Activity::all()
                                    ->where('causer_id', $user_id)
                                    ->where('log_name', 'create')
                                    ->where('description', 'Comment');
        $total_created_comments = count($created_comments);
        $total_created_comments_today = count($created_comments->where('created_at', '>', $today));

        $given_scores = \Activity::all()
                                    ->where('causer_id', $user_id)
                                    ->where('log_name', 'create')
                                    ->where('description', 'Score');
        $total_given_scores = count($given_scores);
        $total_given_scores_today = count($given_scores->where('created_at', '>', $today));

        return [
            'viewed_articles' => $total_viewed_articles,
            'viewed_articles_today' => $total_viewed_articles_today,
            'created_comments' => $total_created_comments,
            'created_comments_today' => $total_created_comments_today,
            'given_scores' => $total_given_scores,
            'given_scores_today' => $total_given_scores_today,
        ];
    }

    public static function getViewMessage($user_id) {
        $atl = 15;
        $al1 = 15;
        $al2 = 100;
        $al3 = 500;

        $challenges = Challenge::getAll(auth()->user()->id);

        if ($challenges['viewed_articles_today'] == $atl) {
            self::addMessage("Je hebt al $atl artikels gelezen vandaag, blijf zo doorgaan!");
        }

        switch ($challenges['viewed_articles']) {
            case $al1:
                self::addMessage("Je hebt al $al1 artikels gelezen!");
                break;
            case $al2:
                self::addMessage("Je hebt al $al2 artikels gelezen!");
                break;
            case $al3:
                self::addMessage("Je hebt al $al3 artikels gelezen!");
                break;
        }

        return self::$messages;
    }

    public static function getScoreMessage($user_id) {
        $stl = 10;
        $sl1 = 10;
        $sl2 = 75;
        $sl3 = 400;

        $challenges = Challenge::getAll(auth()->user()->id);

        if ($challenges['given_scores_today'] == $stl) {
            self::addMessage("Je hebt al $stl scores gegeven vandaag, blijf zo doorgaan!");
        }

        switch ($challenges['given_scores']) {
            case $sl1:
                self::addMessage("Je hebt al $sl1 scores gegeven!");
                break;
            case $sl2:
                self::addMessage("Je hebt al $sl2 scores gegeven!");
                break;
            case $sl3:
                self::addMessage("Je hebt al $sl3 scores gegeven!");
                break;
        }
        
        return self::$messages;
    }

    public static function getCommentMessage($user_id) {
        $ctl = 5;
        $cl1 = 5;
        $cl2 = 50;
        $cl3 = 300;

        $challenges = Challenge::getAll(auth()->user()->id);

        if ($challenges['created_comments_today'] == $ctl) {
            self::addMessage("Je hebt al $ctl opmerkingen geplaatst vandaag, blijf zo doorgaan!");
        }

        switch ($challenges['created_comments']) {
            case $cl1:
                self::addMessage("Je hebt al $cl1 opmerkingen geplaatst!");
                break;
            case $cl2:
                self::addMessage("Je hebt al $cl2 opmerkingen geplaatst!");
                break;
            case $cl3:
                self::addMessage("Je hebt al $cl3 opmerkingen geplaatst!");
                break;
        }
        
        return self::$messages;
    }

    private static function addMessage($message) {
        array_push(self::$messages, "<b>Je hebt een nieuw doel bereikt!</b> " . $message);
    }

}
