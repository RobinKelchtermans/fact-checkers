<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Article;

class SearchController extends Controller
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
    public function index()
    {
        $q = Input::get ( 'q' );
        $articles = Article::where('title', 'like', '%' . $q . '%')->orWhere('description', 'like', '%' . $q . '%')->get()->sortByDesc('published_on');
        if ($q != null && count ( $articles ) > 0)
            return view('article.search')->withDetails($articles)->withQuery($q);
        else
            return view('article.search')->withMessage('Geen artikels gevonden...')->withQuery($q);
    }

}
