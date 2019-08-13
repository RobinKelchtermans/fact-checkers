@extends('layouts.immersion')

@section('content')
<div class="header-progress-container sticky-top">
    <ol class="header-progress-list">
        <li class="header-progress-item done"></li>
        @for ($i = 0; $i < count($questions) + 1; $i++)
        <li class="header-progress-item todo"></li>
        @endfor
    </ol>
</div>
<div id="text-carousel" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner" id="questions">
        <div class="col-12 text-center carousel-item active" id="intro">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row my-3 step-done">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">1</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Registratie</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-done">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">2</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Verifieer je e-mailadres</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-active">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">3</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Hexad user type test</h2>
                                            <p>
                                                Nu dat we zeker zijn dat je uniek bent, ga je een test afleggen en een vragenlijst.
                                                <br>
                                                We starten met de <i>User Types Hexad</i> test. Deze korte test zal je <a href="{{url("/about")}}" target="_blank">type gebruiker</a> bepalen en zo zal het platform er anders uitzien.
                                            </p>
                                            <button type="button" class="btn btn-primary" id="btnStart">Start</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-todo">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">4</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Mediagebruik</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-todo">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">5</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Tutorial</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="text-center" action="/survey/hexad" method="POST">
            @csrf
            @foreach ($questions as $q)
                <div class="form-group question carousel-item">
                    <label for="{{ $q->id }}"><h1>{{ $q->question }}</h1></label>
                    <br>
                    <div class="btn-group btn-group-toggle next answer d-none d-md-block" data-reference="{{ $q->reference }}" data-correlation="{{ $q->correlation }}" data-type="{{ $q->userType }}" data-toggle="buttons">
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-3">Helemaal niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-2">Niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-1">Deels niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="0">Neutraal
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="1">Deels akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="2">Akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="3">Helemaal akkoord
                        </label>
                    </div>
                    <div class="btn-group-vertical btn-group-toggle next answer d-block d-md-none" data-reference="{{ $q->reference }}" data-correlation="{{ $q->correlation }}" data-type="{{ $q->userType }}" data-toggle="buttons">
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-3">Helemaal niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-2">Niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="-1">Deels niet akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="0">Neutraal
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="1">Deels akkoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="2">Akoord
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $q->reference }}" autocomplete="off" value="3">Helemaal akkoord
                        </label>
                    </div>
                </div>
            @endforeach
            <div class="form-group text-center question carousel-item" id="result">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-4">
                        <div class="card">
                            <img src="" alt="user type image" class="card-img-top">
                            <input type="hidden" name="userType" value="" id="userTypeValue">
                            <input type="hidden" name="userInfo" value="" id="userInfoValue">
                            <div class="card-body">
                                <h3 class="card-title"></h3>
                                <p class="card-text"></p>
                                <p>Dit zal een invloed hebben op hoe je het platform ervaart. Meer informatie kan je <a href="{{ url('/about') }}" target="_blank">hier</a> terugvinden.</p>
                                <button type="submit" class="btn btn-primary">Antwoorden opslaan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </form>
    </div>
</div>
<script src="{{ asset('js/survey/main.js') }}" defer></script>
@endsection