@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <div class="row">
                            <div class="col-md-3 order-md-last">
                                <div class="alert alert-secondary" role="alert">
                                    <h5>Al een account?</h5>
                                    <a class="card-link" href="{{ route('login') }}">Log je hier in</a>
                                </div>
                                
                            </div>
                            <div class="col-md-9">
                                <h2>Hi! Je vraagt jou waarschijnlijk af wat dit is?</h2>
                                <p class="mb-0">
                                    Dat is ook een terechte vraag. 
                                    Je hebt deze link waarschijnlijk onlangs gekregen, 
                                    maar je weet niet goed wat het allemaal nu juist is.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h3>Kort samengevat</h3>
                        Kort samengevat is deze website een platform waar je gewoon je <b>dagdagelijks nieuws</b> kan <b>lezen</b>.
                        Maar er is natuurlijk meer dan dat. Het doel van dit platform is <b>om artikels te gaan fact checken</b>. 
                        Bij <a href="{{ url('/about') }}" title="Meer informatie over fact checking" target="_blank">fact checking</a>
                        ga je nagaan of een artikel al dan niet juist is. Je krijgt de mogelijkheid om opmerkingen toe te voegen en een score
                        te geven bij elk artikel.
                        <br>
                        <br>
                        Je doet dit niet zomaar, want er zit <b>wetenschappelijk onderzoek</b> achter. Meer bepaald zal je in contact
                        komen met <a href="{{ url('/about') }}" title="Meer informatie over gamification" target="_blank">gamification</a>. 
                        In dit onderzoek willen we nagaan of gepersonaliseerde gamification een invloed heeft op het al dan niet fact checken. 
                        Je kan steeds meer informatie vinden over het onderzoek op de <a href="/about">over het onderzoek</a> pagina.
                        <br>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary btn-lg" href="/register" role="button">Registreer je hier</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-text">
                        <h3>Verloop van het onderzoek</h3>
                        We leggen kort uit hoe het onderzoek zal verlopen. 
                        Klik op één van de blokjes om meer informatie te krijgen.
                    </div>
                </div>
            </div>
        </div>        
    </div>
    @include('about.process')
</div>
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection