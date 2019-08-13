<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Feeds\DeMorgenFeed;
use App\Models\Feeds\DeStandaardFeed;
use App\Models\Feeds\VRTFeed;
use App\Models\Feeds\HLNFeed;
use App\Models\Feeds\HetNieuwsbladFeed;
use App\Models\Feeds\VTMFeed;
use App\Models\Feeds\DeTijdFeed;
use App\Models\Feeds\GVAFeed;
use App\Models\Feeds\HBVLFeed;

class FeedLoaderController extends Controller
{
    public function index()
    {
        if (auth()->guest()) {
            return view('index');
        }

        if (auth()->user()->is_admin == 0) {
            return view('index');
        }

        $articlesDM = [];
        $articlesDS = [];
        $articlesDT = [];

        $articlesVRT = [];
        $articlesHNB = [];
        $articlesVTM = [];

        $articlesHLN = [];
        $articlesGVA = [];
        $articlesHBVL = [];

        $DeMorgenFeed = new DeMorgenFeed();
        $articlesDM = $DeMorgenFeed->getAndSaveLatestArticles();
        $DeMorgenFeed = null;

        $VRTFeed = new VRTFeed();
        $articlesVRT = $VRTFeed->getAndSaveLatestArticles();
        $VRTFeed = null;

        $HLNFeed = new HLNFeed();
        $articlesHLN = $HLNFeed->getAndSaveLatestArticles();
        $HLNFeed = null;

        $GVAFeed = new GVAFeed();
        $articlesGVA = $GVAFeed->getAndSaveLatestArticles();
        $GVAFeed = null;

        // Het Nieuwsblad doet soms moeilijk... Dus als laatste laden
        $HetNieuwsbladFeed = new HetNieuwsbladFeed();
        $articlesHNB = $HetNieuwsbladFeed->getAndSaveLatestArticles();
        $HetNieuwsbladFeed = null;

        // De standaard doet soms moeilijk... Dus als laatste laden
        $DeStandaardFeed = new DeStandaardFeed();
        $articlesDS = $DeStandaardFeed->getAndSaveLatestArticles();
        $DeStandaardFeed = null;

        $HBVLFeed = new HBVLFeed();
        $articlesHBVL = $HBVLFeed->getAndSaveLatestArticles();
        $HBVLFeed = null;

        // ================

        // VTM is brak!
        // $VTMFeed = new VTMFeed();
        // $articlesVTM = $VTMFeed->getAndSaveLatestArticles();
        // $VTMFeed = null;

        // De Tijd suckt
        // $DeTijdFeed = new DeTijdFeed();
        // $articlesDT = $DeTijdFeed->getAndSaveLatestArticles();
        // $DeTijdFeed = null;

        // =====================

        $articles = array_merge($articlesDM, $articlesDS, $articlesVRT, $articlesHLN, $articlesGVA, $articlesHNB, $articlesHBVL);

        echo (count($articles)) . " articles retrieved successfully!";

        dd($articles);
    }
}
