<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class EndSurveyController extends Controller
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
        if (auth()->user()->survey_end != null) {
            return redirect('/endInfo');
        }

        activity('show')->log('End survey');
        return view('surveys.end');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $scales = [
            'Normal comments' => $request['scaleCN'],
            'Inline comments' => $request['scaleCI'],
            'Up- and downvote' => $request['scaleUDV'],
            'Fake-o-Meter' => $request['scaleFOM'],
            'Remarks' => $request['scaleComments']
        ];

        if ($request['sawFunctionalities'] == null) {
            $sawFunctionalities = $request['sawFunctionalities'];
        } else {
            $sawFunctionalities = 'Ja, ' . $request['sawFunctionalitiesValue'];
        }

        $responses = [
            'Hoe vaak denk je in (impliciet) contact te komen met fake news?' 
                => $request['oftenFake'],
            'Hoeveel fake news artikels denk je in totaal te hebben geopend?' 
                => $request['nbOfFake'],
            'Welke (online) kranten lees je?' 
                => $request['reading'],
            'Heb je ooit gemerkt dat het platform extra functionaliteiten heeft aangeboden? Indien ja, wat en wanneer?' 
                => $sawFunctionalities,
            'Ik vind het een maatschappelijk meerwaarde om dergelijke platformen aan te bieden.' 
                => $request['socialValue'],
            'Vond je het een meerwarde om ...' 
                => $scales,
        ];

        $user = $request->user();
        $user->survey_end = json_encode($responses);
        $user->save();

        return redirect('/endInfo');
    }
}
