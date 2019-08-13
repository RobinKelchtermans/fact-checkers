<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class SUSSurveyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }

    public function index()
    {
        // If already filled in, skip.
        if (auth()->user()->survey_sus != null) {
            return redirect('/survey/end');
        }

        activity('show')->log('SUS survey');
        return view('surveys.sus');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $user->survey_sus = json_encode($request->except('_token'));
        $user->save();

        return redirect('/survey/end');
    }
}
