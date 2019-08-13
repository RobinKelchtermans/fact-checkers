<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class HexadSurveyController extends Controller
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
    }

    public function index()
    {
        // If already filled in, skip.
        if (auth()->user()->survey_hexad != null) {
            return redirect('/survey/media');
        }

        activity('show')->log('Hexad survey');
        $qs = Question::all();
        return view('surveys.hexad', ["questions" => $qs->shuffle()]);
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
        $user->survey_hexad = json_encode($request->except('_token'));
        $user->save();

        return redirect('/survey/media');
    }
}
