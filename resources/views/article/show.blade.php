@extends('layouts.app')

@section('content')
{{-- <input type="hidden" name="user-id" value="{{ auth()->user()->id }}"> --}}
<input type="hidden" name="article-id" value="{{ $article->article_id }}">
<input type="hidden" name="score-value" value="{{ $score }}">

<div class="modal fade" id="scoreInfoModal" tabindex="-1" role="dialog" aria-labelledby="scoreInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" data-step="6" data-position="bottom" data-intro="De betekenis van elke score.">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="scoreInfoModalLabel">Uitleg Fake-o-Meter</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @include('partials.fom-scale')
        </div>
        <div class="modal-footer">
            <a href="{{ url('/about') }}" target="_blank" class="btn btn-sm btn-primary">Meer informatie</a>
        </div>
        </div>
    </div>
</div>
<div class="modal fade" id="generalInfoModal" tabindex="-1" role="dialog" aria-labelledby="generalInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" data-step="2" data-position="right" data-intro="Uitleg over hoe je moet fact checken. We raden je aan om dit eerst door te nemen, maar we tonen jou in de volgende stap hoe je dit venster opent.">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="generalInfoModalLabel">Uitleg Fact Checking</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="generalInfo">
            <h3>Doel?</h3>
            <p>
                Het doel is om <b>na te gaan of een artikel al dan niet waar is</b>. Je doet dus aan <a href="{{ url('/about') }}" target="_blank">fact checking</a>.
            </p>
            <h3>Hoe?</h3>
            <p>
                Er zijn drie "onderdelen" bij elk artikel:
                <ul>
                    <li>Fake-o-Meter</li>
                    <li>Opmerkingen in de tekst</li>
                    <li>Opmerkingen in het algemeen</li>
                </ul>
                Je kan op een gemakkelijke manier aanduiden of een artikel al dan niet fake is op de Fake-o-Meter.
                <br>
                Selecteer één of meerdere woorden in de tekst en voeg er een opmerking aan toe.
                <br>
                Geef een algemene opmerking naast/onder het artikel.
                <br>
                <br>
                <b>Je opmerking moet relevant zijn en, indien je iets wilt bewijzen, voeg je de link toe van jouw bron.</b> Bijvoorbeeld een link naar een wetenschappelijke paper of website.
                <br>
                <br>
                Als je akkoord gaat me een opmerking van een andere persoon kan je opmerking upvoten. Indien je niet akkoord gaat, kan je downvoten.
            </p>
            <h3>Waarom?</h3>
            <p>
                In het kort: Je gaat voorbereidend werk doen voor professionele fact checkers. Aan de hand van jouw opmerkingen en opzoekwerk, kunnen zij sneller te werk gaan. <a href="{{ url('/about') }}">Meer informatie</a>.
            </p>
        </div>
        <div class="modal-footer">
            <a href="{{ url('/about') }}" target="_blank" class="btn btn-sm btn-primary">Meer informatie</a>
        </div>
        </div>
    </div>
</div>
<?php
    $show_comments = Cookie::get('show_comments');
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'y',
            'm' => 'm',
            'w' => 'w',
            'd' => 'd',
            'h' => 'h',
            'i' => 'm',
            's' => 's',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . $v;
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) : 'just now';
    }

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

    function getBadges($user) {
        $r = '';
        if (session()->get('show_gamification') && session()->get('userType') == 'Socialiser') {
            $r = '<span class="badge badge-secondary">';
                if (strtotime($user->created_at) > strtotime('-1 week'))
                    $r .= 'Nieuw';
                elseif($user->reputation > 0.950)
                    $r .= 'Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>';
                elseif($user->reputation > 0.900)
                    $r .= 'Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>';
                elseif($user->reputation > 0.800)
                    $r .= 'Pro <i class="fas fa-sm fa-star"></i>';
                elseif($user->reputation > 0.700)
                    $r .= 'Top';
                else
                    $r .= 'Normal';
            $r.= '</span>';
        }
        return $r;
    }

    function getCommentHTML($child, $article, $votes) {
        $up = (checkIfVoted($votes, $child->id, 1) ? "voted" : "");
        $down = (checkIfVoted($votes, $child->id, -1) ? "voted" : "");
        $diff = ($child->upvotes - $child->downvotes);

        $badges = getBadges(App\User::find($child->user_id));

        $s = "<div class='row mb-2 ml-1' id='comment-$child->id'>
                <div class='col-1 d-flex justify-content-end mt-2 p-0'>
                    <div>";
        
        if (Auth::user()->id == $child->user_id && session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null) {
            $s .= '<img src="' . asset('storage/' . session()->get('avatar_path')) . '" alt="avatar" class="avatar-navbar">';
        } else {
            $s .= '<i class="fas fa-user fa-lg"></i>';
        }
        $s .= "
                        <br>
                        <span class='badge badge-light votes'>$diff</span>
                    </div>
                </div>
                <div class='col-10 pr-0 pl-1'>
                    <p class='card-text comment overflow-hidden mb-0'>
                        <b><a href='#'>$child->firstname $child->lastname</b></a>
                        $badges
                        $child->text
                    </p>
                    <small>
                        <a href='javascript:void(0)' onclick='upvote($child->id)' class='upvote ml-2 $up'>Upvote</a> &middot; 
                        <a href='javascript:void(0)' onclick='downvote($child->id)' class='downvote $down'>Downvote</a> &middot;         
                        <a href='javascript:void(0)' class='reply' onclick='startAnswer(" . $child->parent_id . ")'>Antwoord</a> &middot; " . time_elapsed_string($child->created_at) . "
                    </small>
                </div>";

        if ( Auth::user()->id == $child->user_id) {
            $s .= "<div class='col-1 d-flex justify-content-start align-items-center mb-4 p-0'>";
            $s .= "<a tabindex='0' class='btn p-0 popover-options' data-container='body' data-toggle='popover' data-trigger='focus' data-placement='top'";
            $s .= 'data-content="<form action=\'' . url("comment/$child->id") . '\' method=\'POST\'>
                                        <input type=\'hidden\' name=\'_token\' value=\'' . csrf_token() . '\'>                                                              
                                        <input type=\'hidden\' name=\'_method\' value=\'DELETE\'> 
                                        <input type=\'hidden\' name=\'article_text\' value=\'\'>
                                        <input type=\'hidden\' name=\'article_id\' value=\'' . $article->article_id . '\'>
                                        <button type=\'submit\' class=\'btn btn-sm btn-light\'>Verwijder</button>
                                    </form>">';
            $s .= "<i class='fas fa-ellipsis-h'></i></a>
                </div>";
        }
            
        $s .= "</div>";
        return trim(preg_replace('/\n/', '', $s));
    }

    function checkIfVoted($votes, $commentId, $val) {
        if ($votes->contains("comment_id", $commentId)) {
            if ($votes->first(function($item) use ($val, $commentId) { 
                    return $item->value == $val && $item->comment_id == $commentId; 
                })) {
                return true;
           }
        }
        return false;
    }
?>
<div class="overlay"></div>
<i id="marked-tooltip" data-toggle="tooltip" data-placement="top" title="Je kan geen tekst selecteren die al aangeduid is of uit verschillende paragrafen komt" data-animation="true" data-trigger="manual"></i>
<div class="px-3" data-step="9" data-intro="We zijn klaar! Je mag op dit artikel wat uitproberen, niemand anders kan zien wat je hier doet.">
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show col-sm-4 offset-sm-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="row" data-step="1" data-position="top" data-intro="Op deze pagina staat je gekozen artikel. We overlopen elk onderdeel." id="step-1">
        <div class="col-xl-8 mb-3">
            <div class="row">
                <div class="smooth-transition px-1 @if($show_comments) col-sm-8 @else col-sm-12 @endif" id="articleBox" data-show-comments="@if($show_comments) true @else false @endif" data-show-comments-original="@if($show_comments) true @else false @endif">
                    <div class="card">
                        <div class="card-header p-2">
                            <span data-toggle="modal" data-target="#generalInfoModal" style="cursor:pointer">
                                <i class="fas fa-lg fa-question-circle" data-step="3" data-intro="Je kan de uitleg altijd hier terugvinden."></i>
                            </span>
                            <span class="badge badge-{{$score_class}} thrust-label">{{$score_text}}</span>
                            <div class="d-flex align-items-center float-right">
                                <small class="text-muted">{{ $formated_date }}</small>
                                <small class="text-muted ml-2"><button id="toggleCommentsBtn" type="button" class="btn btn-sm btn-outline-dark @if($show_comments) active @endif"><i class="far fa-lg fa-comments"></i></button></small>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- {{$article->source}} --}}
                            <div class="highlightable" id="article">
                                {!! $article->content !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div data-step="4" data-scrollTo="tooltip" data-intro="Hier staan de opmerkingen voor in het artikel zelf. Om zelf een opmerking toe te voegen <b>selecteer je een stukje tekst</b> van het artikel." class="smooth-transition p-0 @if($show_comments) col-sm-4 @else col-sm-0 @endif" id="inlineComments">
                        <div class="card d-none mr-2" id="templateInlineComment" style="width: 90%">
                            <div class="row card-body">
                                <div class="col-1 d-flex justify-content-end mt-3 p-0">
                                    @if (session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                        <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                                    @else
                                        <i class="fas fa-user fa-lg"></i>
                                    @endif
                                </div>
                                <div class="col-10">
                                    <p class="card-text mb-0 mt-2">
                                        <form method="POST" action="{{ url('comment') }}" class="form-comment">
                                            @csrf
                                            <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                                            <input type="hidden" name="type" value="inline">
                                            <input type="hidden" name="associated_text_id" value="">
                                            <input type="hidden" name="article_text" value="">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <div class="form-group">
                                                <textarea class="form-control comment" name="comment" rows="2" placeholder="Schrijf je opmerking hier..." required="required"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary float-right btn-comment">Reageer</button>
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                    
                        @foreach ($comments as $comment)
                            @if ($comment->type == "inline")
                            <div class="d-none inline-comment-mini" id="comment-{{$comment->id}}-mini" data-associated_text_id="{{$comment->associated_text_id}}" onclick="toggleInlineComment({{$comment->id}})">
                                <button type="button" class="btn btn-sm btn-outline-dark"><i class="far fa-lg fa-comment"></i></button>
                            </div>
                            <div class="card inline-comment d-none" id="comment-{{$comment->id}}" data-associated_text_id="{{$comment->associated_text_id}}" style="width:100%">
                                <div class="container">
                                <div class="row p-2">
                                    <i class="fas fa-times fa-sm close-comment" onclick="toggleInlineComment({{$comment->id}})"></i>

                                    <div class="col-1 d-flex justify-content-end mt-2 p-0">
                                        <div>
                                            @if (auth()->user()->id == $comment->user_id && session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                                <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                                            @else
                                                <i class="fas fa-user fa-lg"></i>
                                            @endif
                                            <br>
                                            <span class="badge badge-light votes">{{$comment->upvotes - $comment->downvotes}}</span>
                                        </div>
                                    </div>
                                    <div class="col-10">
                                        <p class="card-text comment overflow-hidden mb-0">
                                            <b><a href="{{ url('/users/' . $comment->user_id) }}"> {{ $comment->firstname }} {{ $comment->lastname }}</b></a>
                                            <?php $user = App\User::find($comment->user_id); ?>
                                            @include('profile.personalisation.socialiser-badges')
                                            {{ $comment->text }}
                                        </p>
                                        <small>
                                            <a href="javascript:void(0)" onclick="upvote({{ $comment->id }})" class="upvote ml-2 @if(checkIfVoted($votes, $comment->id, 1)) voted @endif">Upvote</a> &middot; 
                                            <a href="javascript:void(0)" onclick="downvote({{ $comment->id }})" class="downvote @if(checkIfVoted($votes, $comment->id, -1)) voted @endif">Downvote</a> &middot; 
                                            <a href="#" class="reply" onclick="startAnswer({{ $comment->id }})">Antwoord</a> &middot; 
                                            {{ time_elapsed_string($comment->created_at) }}
                                        </small>
                                        <div id="comment-{{$comment->id}}-answers">
                                            <?php 
                                                foreach ($comments as $child) {
                                                    if ($comment->id == $child->parent_id) {
                                                        echo getCommentHTML($child, $article, $votes);
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    @if ( Auth::user()->id  == $comment->user_id)
                                    <div class="col-1 d-flex justify-content-start align-items-center mb-4 p-0 comment-options">
                                        <a tabindex="0" class="btn p-0 popover-options" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="top" 
                                                data-content='<form action="{{ url("comment/$comment->id") }}" method="POST">
                                                                @csrf
                                                                @method("DELETE")
                                                                <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                                                                <input type="hidden" name="article_text" value="">
                                                                <button type="submit" class="btn btn-sm btn-light">Verwijder</button>
                                                            </form>'>
                                            <i class="fas fa-ellipsis-h"></i></a>
                                    </div>
                                    @endif
                                </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                </div>
            </div>
        </div>


        {{-- Comment section --}}


        <div class="col-xl-4 px-1">
            <div class="card mb-1" data-step="5" data-intro="Hier kan je een score geven door op een van de bolletje te klikken.">
                <div class="card-body">
                    <h4 class="card-title">
                        Fake-o-Meter
                        <span data-toggle="modal" data-target="#scoreInfoModal" style="cursor:pointer">
                            <i class="fas fa-xs fa-question-circle" data-step="7" data-intro="Je kan de uitleg altijd hier terugvinden."></i>
                        </span>
                    </h4>
                    <hr>
                    <p class="card-text d-flex align-items-center">
                        <i class="far fa-2x fa-times-circle thrust-rating thrust-rating-fake" data-value="Fake"></i>
                        <i class="far fa-2x fa-check-circle thrust-rating thrust-rating-f" data-value="F"></i>
                        <i class="far fa-2x fa-check-circle thrust-rating thrust-rating-mf" data-value="MF"></i>
                        <i class="far fa-2x fa-check-circle thrust-rating thrust-rating-ht" data-value="HT"></i>
                        <i class="far fa-2x fa-check-circle thrust-rating thrust-rating-mt" data-value="MT"></i>
                        <i class="far fa-2x fa-check-circle thrust-rating thrust-rating-t" data-value="T"></i>
                        <span class="text-muted ml-3" id="given-rating">Geef een score</span>
                    </p>
                </div>
            </div>
            <div class="card" data-step="8" data-intro="Hier kan je opmerkingen toevoegen die relevant zijn voor het hele artikel.">
                <div class="card-body">
                    <h4 class="card-title">Opmerkingen</h4>
                    <hr>
                        <div class="d-none" id="templateSubComment">
                            <div class="row mb-2 ml-1">
                                <div class="col-1 d-flex justify-content-end mt-3 p-0">
                                    @if (session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                        <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                                    @else
                                        <i class="fas fa-user fa-lg"></i>
                                    @endif
                                </div>
                                <div class="col-10">
                                    <p class="card-text mb-0 mt-2">
                                        <form method="POST" action="{{ url('comment') }}">
                                            @csrf
                                            <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                                            <input type="hidden" name="parent_id" value="">
                                            <input type="hidden" name="type" value="normal">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <div class="form-group">
                                                <textarea class="form-control comment" name="comment" rows="2" placeholder="Schrijf je opmerking hier..." required="required"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary float-right">Reageer</button>
                                        </form>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @foreach ($comments as $comment)
                            @if ($comment->type == "normal" && $comment->parent_id == null)
                                <div class="row mb-2" id="comment-{{$comment->id}}">
                                    <div class="col-1 d-flex justify-content-end mt-2 p-0">
                                        <div>
                                            @if (auth()->user()->id == $comment->user_id && session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                                <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                                            @else
                                                <i class="fas fa-user fa-lg"></i>
                                            @endif
                                            <br>
                                            <span class="badge badge-light votes">{{$comment->upvotes - $comment->downvotes}}</span>
                                        </div>
                                    </div>
                                    <div class="col-10 pl-1">
                                        <p class="card-text comment overflow-hidden mb-0">
                                            <b><a href="{{ url('/users/' . $comment->user_id) }}"> {{ $comment->firstname }} {{ $comment->lastname }}</b></a>
                                            <?php $user = App\User::find($comment->user_id); ?>
                                            @include('profile.personalisation.socialiser-badges')
                                            {{ $comment->text }}
                                        </p>
                                        <small>
                                            <a href="javascript:void(0)" onclick="upvote({{ $comment->id }})" class="upvote ml-2 @if(checkIfVoted($votes, $comment->id, 1)) voted @endif">Upvote</a> &middot; 
                                            <a href="javascript:void(0)" onclick="downvote({{ $comment->id }})" class="downvote @if(checkIfVoted($votes, $comment->id, -1)) voted @endif">Downvote</a> &middot; 
                                            <a href="javascript:void(0)" class="reply" onclick="startAnswer({{ $comment->id }})">Antwoord</a> &middot; 
                                            {{ time_elapsed_string($comment->created_at) }}
                                        </small>
                                        <div id="comment-{{$comment->id}}-answers">
                                            <?php 
                                                foreach ($comments as $child) {
                                                    if ($comment->id == $child->parent_id) {
                                                        echo getCommentHTML($child, $article, $votes);
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    @if ( Auth::user()->id  == $comment->user_id)
                                    <div class="col-1 d-flex justify-content-start align-items-center mb-4 p-0">
                                        <a tabindex="0" class="btn p-0 popover-options" data-container="body" data-html="true" data-toggle="popover" data-trigger="focus" data-placement="top" 
                                                data-content='<form action="{{ url("comment/$comment->id") }}" method="POST">
                                                                @csrf
                                                                @method("DELETE")
                                                                <button type="submit" class="btn btn-sm btn-light">Verwijder</button>
                                                            </form>'>
                                            <i class="fas fa-ellipsis-h"></i></a>
                                    </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                        <div class="row mb-2">
                            <div class="col-1 d-flex justify-content-end mt-3 p-0">
                                @if (session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                    <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar-navbar">
                                @else
                                    <i class="fas fa-user fa-lg"></i>
                                @endif
                            </div>
                            <div class="col-10">
                                <p class="card-text mb-0 mt-2">
                                    <form method="POST" action="{{ url('comment') }}" class="form-comment">
                                        @csrf
                                        <input type="hidden" name="article_id" value="{{ $article->article_id }}">
                                        <input type="hidden" name="type" value="normal">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="form-group">
                                            <textarea class="form-control comment" name="comment" rows="2" placeholder="Schrijf je opmerking hier..." required="required"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary float-right btn-comment">Reageer</button>
                                    </form>
                                </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/readmore.js') }}" defer></script>
<script src="{{ asset('js/articles.js') }}" defer></script>
<script src="{{ asset('js/intro.min.js') }}" defer></script>

@if(isset($_GET['tutorial']) && $_GET['tutorial'] == "true") 
    <script src="{{ asset('js/tutorial.js') }}" defer></script>
@endif

@endsection