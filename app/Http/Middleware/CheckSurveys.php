<?php

namespace App\Http\Middleware;

use Closure;

class CheckSurveys
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::guest()) {
            return route('login');
        }
        if (auth()->user()->survey_hexad == null) {
            return response()->view('surveys.hexad');
        }
        if (auth()->user()->survey_media == null) {
            return response()->view('surveys.media');
        }

        // Set gamification
        $time = strtotime(auth()->user()->created_at);
        $one_week_ago = strtotime('-2 week');

        if (auth()->user()->user_group == 'A') {
            if ($time > $one_week_ago) {
                session(['show_gamification' => false]);
            } else {
                session(['show_gamification' => true]);
            }
        } else {
            if ($time > $one_week_ago) {
                session(['show_gamification' => true]);
            } else {
                session(['show_gamification' => false]);
            }
        }

        return $next($request);
    }
}
