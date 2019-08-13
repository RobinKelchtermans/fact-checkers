@extends((isset($_GET['tutorial']) && $_GET['tutorial'] == "true") ? 'layouts.tutorial' : 'layouts.app')


<?php
    $sources = collect(JSON_decode(auth()->user()->sources));
    $userType = collect(JSON_decode(auth()->user()->survey_hexad))['userType'];
    $userInfo = collect(JSON_decode(auth()->user()->survey_hexad))['userInfo'];
?>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div data-step="3" data-intro="Informatie over jezelf.">
                        <a href="{{ url('/settings') }}" style="color: darkgrey"><i class="fas fa-cog fa-lg float-right mt-3"></i></a>

                        {{-- Socialiser --}}
                        @if (session()->get('show_gamification') && session()->get('userType') == 'Socialiser')
                            <span class="badge badge-secondary">
                                @if (strtotime(auth()->user()->created_at) > strtotime('-1 week'))
                                    Nieuw
                                @elseif(auth()->user()->reputation > 0.950)
                                    Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>
                                @elseif(auth()->user()->reputation > 0.900)
                                    Pro <i class="fas fa-sm fa-star"></i> <i class="fas fa-sm fa-star"></i>
                                @elseif(auth()->user()->reputation > 0.800)
                                    Pro <i class="fas fa-sm fa-star"></i>
                                @elseif(auth()->user()->reputation > 0.700)
                                    Top
                                @else
                                    Normal
                                @endif
                            </span>
                        @endif

                        <h1>
                            {{-- Free Spirit --}}
                            @if (session()->get('show_gamification') && session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') != null)
                                <img src="{{ asset('storage/' . session()->get('avatar_path')) }}" alt="avatar" class="avatar img-thumbnail">
                            @endif

                            

                            {{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                            
                            {{-- Free Spirit --}}
                            @if (session()->get('show_gamification') && session()->get('userType') == 'Free_Spirit' && session()->get('avatar_path') == null)
                                <a href="{{ url('/settings')}}" role="button" class="btn btn-secondary btn-sm">Stel een profielfoto in</a>
                            @endif
                        </h1>
                        
                        <p class="text-muted">
                            {{ auth()->user()->email }}
                        </p>
                        <p>
                            <img src="{{ url('/images/' . $userType . '.jpg') }}" class="mr-3 img-thumbnail float-left" alt="{{$userType}}" style="max-width: 7em">
                            <h4 class="mt-0">Je bent een {{$userType}}</h4>
                            {{$userInfo}}
                            <br>
                            <a href="{{ url('/about') }}">Meer informatie</a>
                        </p>
                    </div>
                </div>
            </div>

            @if(session()->get('show_gamification'))
                {{-- Philantropist --}}
                @if ($userType == "Philantropist")
                    @include('profile.personalisation.philantropist-reach')
                @endif

                {{-- Achiever --}}
                @if ($userType == "Achiever")
                    @include('profile.personalisation.achiever-challenges')
                @endif

                {{-- Player --}}
                @if ($userType == "Player")
                    @include('profile.personalisation.player-leaderbord')
                @endif

                {{-- Disruptor --}}
                @if ($userType == "Disruptor")
                    @include('profile.personalisation.disruptor-form')
                @endif
            @endif
            
            <div class="card my-3">
                <div class="card-header" data-toggle="collapse" data-target="#collapseLast" aria-expanded="false" aria-controls="collapseLast" style="cursor:pointer">
                    <h4 class="d-flex align-items-center">
                        Onlangs gelezen
                        <i class="fas fa-bars ml-auto p-2"></i>
                    </h4>
                </div>
                <div class="card-body collapse" id="collapseLast">
                    <div class="row">
                        @if (count($articles) == 0)
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        Je hebt nog geen artikels gelezen.
                                    </div>
                                </div>
                            </div>
                        @endif
                        @foreach ($articles as $article)
                            <?php
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
                            ?>
                            <a href="/article/{{ $article->article_id }}" class="article-card col-lg-4 col-sm-6 p-1"> 
                                <div class="card m-0">
                                    @if ($article->picture_link == "")
                                        <img src="/images/no-image-placeholder.jpg" class="card-img-top" alt="article image">
                                    @else
                                        <img src="{{ $article->picture_link }}" class="card-img-top" alt="article image">
                                    @endif
                                    <div class="card-body p-1">
                                        <span class="badge badge-{{$score_class}}">{{$score_text}}</span>
                                        <small class="float-right text-muted">{{ $formated_date }}</small>

                                        <h4 class="crop-text-3 text-break"><b><?php echo $article->title; ?></b></h4>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" data-step="4" data-intro="Hier kan je aanduiden welke mediabronnen je wilt zien in je persoonlijk nieuwsoverzicht.<br><b>Opgelet!</b> Er moeten steeds 3 bronnen aangeduid staan.">
                <div class="card-header">
                    <h4>Filters</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="sources">
                        <div class="alert alert-danger d-none" role="alert" id="notEnoughSources">
                            Je moet minstens 3 nieuwsbronnen aanduiden. <a href="{{ url('/about') }}" target="_blank"><i class="fas fa-sm fa-question-circle"></i></a>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['De Morgen']) checked='checked' @endif id="toggleDM" data-id="De Morgen">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">De Morgen</label>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['De Standaard']) checked='checked' @endif id="toggleDS" data-id="De Standaard">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">De Standaard</label>
                        </div>
                        {{-- <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['De Tijd']) checked='checked' @endif id="toggleDT" data-id="De Tijd">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">De Tijd</label>
                        </div> --}}
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['Gazet van Antwerpen']) checked='checked' @endif id="toggleGVA" data-id="Gazet van Antwerpen">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">Gazet van Antwerpen</label>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['Het Belang van Limburg']) checked='checked' @endif id="toggleHBVL" data-id="Het Belang van Limburg">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">Het Belang van Limburg</label>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['Het Laatste Nieuws']) checked='checked' @endif id="toggleHLN" data-id="Het Laatste Nieuws">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">Het Laatste Nieuws</label>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['Het Nieuwsblad']) checked='checked' @endif id="toggleNB" data-id="Het Nieuwsblad">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">Het Nieuwsblad</label>
                        </div>
                        <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['VRT']) checked='checked' @endif id="toggleVRT" data-id="VRT">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">VRT NWS</label>
                        </div>
                        {{-- <div class="col-12">
                            <label class="switch">
                                <input type="checkbox" class="filters" @if($sources['VTM']) checked='checked' @endif id="toggleVTM" data-id="VTM">
                                <span class="slider round"></span>
                            </label>
                            <label class="pl-2">VTM Nieuws</label>
                        </div> --}}
                    </div>
                    {{-- <hr>
                    <div class="row" id="categories">
                        <div class="col">
                            Momenteel kan je nog niet filteren op categorieën.
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/filter.js') }}" defer></script>

@if(isset($_GET['tutorial']) && $_GET['tutorial'] == "true") 
    <script src="{{ asset('js/intro.min.js') }}" defer></script>
    <script src="{{ asset('js/tutorial.js') }}" defer></script>
@endif

@endsection