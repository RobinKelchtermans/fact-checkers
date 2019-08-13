<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 
        'lastname', 
        'email', 
        'email_verified_at', 
        'password', 
        'can_be_contacted', 
        'user_group', 
        'sources', 
        'categories', 
        'information',
        'survey_hexad',
        'survey_media',
        'survey_sus',
        'survey_end',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected static $logAttributes = ['survey_hexad', 'survey_media', 'survey_sus', 'survey_end', 'sources', 'categories'];
    protected static $logName = 'system';

    private function increaseReputation($points) {
        $this->reputation += $points;
        $this->reputation = round($this->reputation, 5);

        if ($this->reputation > 1) {
            $this->reputation = 1;
        }
        $this->save();
    }

    public function changeReputationUpvote() {
        $points = (1-$this->reputation) / 100;
        $this->increaseReputation($points);
    }

    public function changeReputationDownvote() {
        $points = -($this->reputation / 100);
        $this->increaseReputation($points);
    }

    /**
     * If the user has a lower reputation than a given threshold, reading an 
     * article will improve its reputation.
     *
     * @return void
     */
    public function changeReputationRead() {
        if ($this->reputation < 0.5) {
            $points = 0.001;
            $this->increaseReputation($points);
        }
    }

    public function changeReputationScoreVote() {
        $points = 0.002;
        $this->increaseReputation($points);
    }
}
