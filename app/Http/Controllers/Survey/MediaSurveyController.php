<?php

namespace App\Http\Controllers\Survey;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class MediaSurveyController extends Controller
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
        if (auth()->user()->survey_media != null) {
            return redirect('/tutorialInfo');
        }

        activity('show')->log('Media survey');
        return view('surveys.media');
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
            'Papieren krant' => $request['scalePK'],
            'Smartphone' => $request['scaleSP'],
            'Tablet' => $request['scaleT'],
            'Computer' => $request['scaleC'],
            'Papieren krant' => $request['scalePK'],
        ];

        if ($request['scaleOVal'] != null) {
            array_merge($scales, [$request['scaleOVal'] => $request['scaleO']]);
        }

        if ($request['sawFakeValue'] == null) {
            $sawFake = $request['sawFake'];
        } else {
            $sawFake = 'Ja, ' . $request['sawFakeValue'];
        }

        if ($request['alreadyFactCheckingValue'] == null) {
            $alreadyFactChecking = $request['alreadyFactChecking'];
        } else {
            $alreadyFactChecking = 'Ja, ' . $request['alreadyFactCheckingValue'];
        }

        $responses = [
            'Hoe vaak lees je het nieuws?' 
                => $request['often'],
            'Wat is je voornaamelijkste bron van nieuws?' 
                => ($request['sourceValue'] == null) ? $request['source'] : $request['sourceValue'],
            'Welke (online) kranten lees je?' 
                => $request['reading'],
            'Op een schaal van 1 tot 10, hoeveel gebruik je volgende zaken voor het lezen van het nieuws?' 
                => $scales,
            'Waar of wanneer lees je het nieuws?' 
                => array_filter($request['when']),
            'Hoe vaak denk je in (impliciet) contact te komen met fake news?' 
                => $request['oftenFake'],
            'Hoe betrouwbaar vind je (online) kranten?' 
                => $request['trustworthy'],
            'Hoe betrouwbaar vind je sociale media (nieuwsgewijs)?' 
                => $request['trustworthySM'],
            'Heb je ooit bewust een fake news artikel gezien? Indien ja, wat heb je gedaan?' 
                => $sawFake,
            'Ben je bereid om aan fact checking te doen?' 
                => $request['doFactChecking'],
            'Heb je al eerder aan fact checking gedaan?' 
                => $alreadyFactChecking,
        ];

        $user = $request->user();
        $user->survey_media = json_encode($responses);
        $user->save();

        return redirect('/tutorialInfo');
    }
}
