<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class FilterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('surveys');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $sources = JSON_decode($user->sources);

        $prop = $request->id;
        $sources->$prop = ($request->value == 'true');
        $newSources = JSON_encode($sources);

        $user->sources = $newSources;
        $user->save();
        return $user;
    }

}
