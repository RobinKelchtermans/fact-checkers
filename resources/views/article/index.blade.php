@extends('layouts.app')

<?php
    function getScore($article) {
        switch ($article->score) {
            case 'N':
                $score_class = "secondary";
                $score_text = "Geen score";
                break;
            case 'T':
                $score_class = "thrust-rating-t";
                $score_text = "Waar";
                break;
            case 'MT':
                $score_class = "thrust-rating-mt";
                $score_text = "Grotendeels waar";
                break;
            case 'HT':
                $score_class = "thrust-rating-ht";
                $score_text = "Gedeeltelijk waar";
                break;
            case 'MF':
                $score_class = "thrust-rating-mf";
                $score_text = "Grotendeels onwaar";
                break;
            case 'F':
                $score_class = "thrust-rating-f";
                $score_text = "Onwaar";
                break;
            case 'Fake':
                $score_class = "thrust-rating-fake";
                $score_text = "Fake news";
                break;
            
            default:
                $score_class = "secondary";
                $score_text = "Geen score";
                break;
        }
        return [$score_class, $score_text];
    }

    function formattedDate($article) {
        $date = new DateTime($article->published_on);
        $formated_date = $date->format("H:i");

        $today = new DateTime();
        $today->setTime( 0, 0, 0 );

        $match_date = new DateTime($article->published_on);
        $match_date->setTime( 0, 0, 0 );
        $diff = $today->diff( $match_date );

        if ((integer)$diff->format( "%R%a" ) < 0) {
            $formated_date = $date->format("d M | H:i");
        }
        return $formated_date;
    }
?>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 px-1" data-step="1" data-position="right" data-intro="We zitten nu op de home pagina en hier kan je jouw persoonlijk nieuwsoverzicht terugvinden.">
            @if (count($articles) == 0)
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            Er werden geen artikels in deze categorie gevonden. Probeer later nog eens.
                        </div>
                    </div>
                </div>
            @endif
            @if(isset($_GET['tutorial']) && $_GET['tutorial'] == "true") 
                <?php 
                    $article = $tutorial_article->first(); 
                    $date = new DateTime($article->published_on);
                    $formated_date = $date->format("H:i");
                ?>                
                <a href="/article/{{ $article->article_id }}?tutorial=true" class="article-card"> 
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row" data-step="3" data-intro="Om een artikel te openen dat je interessant vindt, klik je er gewoon op.">
                                <div class="col-md-4">
                                    @if ($article->picture_link == "")
                                        <img src="/images/no-image-placeholder.jpg" class="img-fluid img-stretch" alt="article image">
                                    @else
                                        <img src="{{ $article->picture_link }}" class="img-fluid img-stretch" alt="article image">
                                    @endif
                                    <span class="badge badge-thrust-rating-fake" data-step="2" data-intro="Bij elk artikel staat wat de andere lezers vonden van het artikel. Er zijn 6 levels op de schaal, we leggen het later in detail uit.">Fake news</span>
                                    <small class="float-right text-muted">{{ $formated_date }}</small>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="card-title crop-text-3 text-break"><b><?php echo $article->title; ?></b></h4>
                                    <span class="crop-text-3 text-break"><?php echo $article->description; ?></span>
                                    <span class="text-primary">Lees verder</span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endif
            @foreach ($articles as $article)
                <?php
                    $scores = getScore($article);
                    $score_class = $scores[0];
                    $score_text = $scores[1];

                    $formated_date = formattedDate($article);
                ?>
                <a href="/article/{{ $article->article_id }}" class="article-card"> 
                    <div class="card mb-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if ($article->picture_link == "")
                                        <img src="/images/no-image-placeholder.jpg" class="img-fluid img-stretch" alt="article image">
                                    @else
                                        <img src="{{ $article->picture_link }}" class="img-fluid img-stretch" alt="article image">
                                    @endif
                                    <span class="badge badge-{{$score_class}}">{{$score_text}}</span>
                                    <small class="float-right text-muted">{{ $formated_date }}</small>
                                </div>
                                <div class="col-md-8">
                                    <h4 class="card-title crop-text-3 text-break"><b><?php echo $article->title; ?></b></h4>
                                    <span class="crop-text-3 text-break"><?php echo $article->description; ?></span>
                                    <span class="text-primary">Lees verder</span> 
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="col-md-3 px-1">
            <div class="card sticky-top most-read-card">
                <div class="card-header">Meest gelezen</div>
                <div class="card-body">
                    @foreach ($most_read as $article)
                        <?php
                            $scores = getScore($article);
                            $score_class = $scores[0];
                            $score_text = $scores[1];
        
                            $formated_date = formattedDate($article);
                        ?>
                        <a href="/article/{{ $article->article_id }}" class="article-card"> 
                            <div class="row">
                                <div class="col-4 p-1">
                                    @if ($article->picture_link == "")
                                        <img src="/images/no-image-placeholder.jpg" class="img-fluid img-stretch" alt="article image">
                                    @else
                                        <img src="{{ $article->picture_link }}" class="img-fluid img-stretch" alt="article image">
                                    @endif
                                    {{-- <span class="badge badge-{{$score_class}}">{{$score_text}}</span> --}}
                                </div>
                                <div class="col-8 p-1">
                                    <h6 class="crop-text-3 text-break"><b><?php echo $article->title; ?></b></h6>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($_GET['tutorial']) && $_GET['tutorial'] == "true") 
    <script src="{{ asset('js/intro.min.js') }}" defer></script>
    <script src="{{ asset('js/tutorial.js') }}" defer></script>
@endif

@endsection