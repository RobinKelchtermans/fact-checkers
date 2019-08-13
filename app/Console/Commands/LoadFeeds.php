<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Feeds\DeMorgenFeed;
use App\Models\Feeds\DeStandaardFeed;
use App\Models\Feeds\VRTFeed;
use App\Models\Feeds\HLNFeed;
use App\Models\Feeds\HetNieuwsbladFeed;
use App\Models\Feeds\VTMFeed;
use App\Models\Feeds\DeTijdFeed;
use App\Models\Feeds\GVAFeed;
use App\Models\Feeds\HBVLFeed;

class LoadFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:load {source}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve the articles of the given source';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $source = $this->argument('source');
        $this->info('Retrieving articles from ' . $source);
        $articles = [];

        switch ($source) {
            case 'DeMorgen':
                $DeMorgenFeed = new DeMorgenFeed();
                $articles = $DeMorgenFeed->getAndSaveLatestArticles();
                $DeMorgenFeed = null;
                break;

            case 'VRT':
                $VRTFeed = new VRTFeed();
                $articles = $VRTFeed->getAndSaveLatestArticles();
                $VRTFeed = null;
                break;
                
            case 'HLN':
                $HLNFeed = new HLNFeed();
                $articles = $HLNFeed->getAndSaveLatestArticles();
                $HLNFeed = null;
                break;

            case 'GVA':
                $GVAFeed = new GVAFeed();
                $articles = $GVAFeed->getAndSaveLatestArticles();
                $GVAFeed = null;
                break;

            case 'HBVL':
                $HBVLFeed = new HBVLFeed();
                $articles = $HBVLFeed->getAndSaveLatestArticles();
                $HBVLFeed = null;
                break;

            case 'HetNieuwsblad':
                $HetNieuwsbladFeed = new HetNieuwsbladFeed();
                $articles = $HetNieuwsbladFeed->getAndSaveLatestArticles();
                $HetNieuwsbladFeed = null;
                break;

            case 'DeStandaard':
                $DeStandaardFeed = new DeStandaardFeed();
                $articles = $DeStandaardFeed->getAndSaveLatestArticles();
                $DeStandaardFeed = null;
                break;
            
            default:
                # code...
                break;
        }

        echo "We saved (or tried, if duplicates) " . count($articles) . " articles into the database.\n";
        dd($articles);
    }
}
