@extends('layouts.app')
<?php
    function getScore($article) {
        switch ($article->score) {
            case 'N':
                $score_class = "secondary";
                $score_text = "Geen score";
                break;
            case 'T':
                $score_class = "success";
                $score_text = "Waar";
                break;
            case 'MT':
                $score_class = "success";
                $score_text = "Grotendeels waar";
                break;
            case 'HT':
                $score_class = "warning";
                $score_text = "Gedeeltelijk waar";
                break;
            case 'MF':
                $score_class = "danger";
                $score_text = "Grotendeels onwaar";
                break;
            case 'F':
                $score_class = "danger";
                $score_text = "Onwaar";
                break;
            case 'Fake':
                $score_class = "danger";
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
        <form class="col-md-4 offset-md-4" role="search" method="POST" action="{{ url('/search') }}">
            @csrf
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="Zoek artikels" value="{{ $query }}">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <p>Zoekterm: <b> {{ $query }} </b></p>
        </div>
        <div class="col-12">
            @if(isset($details))
                
                @foreach($details as $article)
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
                                    <div class="col-lg-4">
                                        @if ($article->picture_link == "")
                                            <img src="/images/no-image-placeholder.jpg" class="img-fluid img-stretch" alt="article image">
                                        @else
                                            <img src="{{ $article->picture_link }}" class="img-fluid img-stretch" alt="article image">
                                        @endif
                                        <span class="badge badge-{{$score_class}}">{{$score_text}}</span>
                                        <small class="float-right text-muted">{{ $formated_date }}</small>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4 class="card-title crop-text-3 text-break"><b><?php echo $article->title; ?></b></h4>
                                        <span class="crop-text-3 text-break"><?php echo $article->description; ?></span>
                                        <span class="text-primary">Lees verder</span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
            @if(isset($message))
                <h3>{{$message}}</h3>
            @endif
        </div>
        
        
    </div>
</div>

@endsection