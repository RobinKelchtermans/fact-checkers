@extends('layouts.immersion')

@section('content')

<div class="header-progress-container sticky-top">
    <ol class="header-progress-list">
        <li class="header-progress-item done end-progress"></li>
        @for ($i = 0; $i < 6; $i++)
            <li class="header-progress-item todo end-progress"></li>
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
                                            <h2>SUS</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-active">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">2</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Eindenquête</h2>
                                            Je bent er bijna! Nog een paar extra vragen over vanalles en nog wat.
                                            <br>
                                            <button type="button" class="btn btn-primary mt-3" id="btnStart">Start</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="text-center" action="/survey/end" method="POST">
            @csrf

            {{-- Hoe vaak denk je in (impliciet) contact te komen met fake news? --}}

            <div class="form-group question carousel-item">
                <label for="oftenFake"><h1>Hoe vaak denk je in (impliciet) contact te komen met fake news?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="Dagelijks">Dagelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="2-3 Dagen">Om de 2 à 3 dagen
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="Wekelijks">Wekelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="Tweewekelijks">Tweewekelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="Maandelijks">Maandelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="oftenFake" autocomplete="off"  value="(bijna) Nooit">(bijna) Nooit
                    </label>
                </div>
            </div>

            {{-- Hoeveel fake news artikels denk je in totaal te hebben geopend? --}}

            <div class="form-group question carousel-item" id="nbOfFakeBox" data-toggle="buttons">
                <label for="nbOfFake">
                    <h1>Hoeveel fake news artikels denk je in totaal te hebben geopend?</h1>
                    <h5 class="text-muted">Indien je geen fake news artikels hebt geopend, mag je 0 invullen.</h5>
                </label>
                <br>
                <input type="number" min="0" class="form-control col-md-6 offset-md-3" name="nbOfFake">
                <br>
                <button class="btn btn-outline-primary next">Volgende</button>
            </div>

            {{-- Heb je ooit gemerkt dat het platform extra functionaliteiten heeft aangeboden? Indien ja, wat en wanneer? --}}

            <div class="form-group question carousel-item" id="sawFunctionalitiesBox" data-toggle="buttons">
                <label for="sawFunctionalities"><h1>Heb je ooit gemerkt dat het platform extra functionaliteiten heeft aangeboden? Indien ja, wat en wanneer?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="sawFunctionalities" autocomplete="off"  value="Nee">Nee
                    </label>
                    <label class="btn btn-outline-primary preventNext">
                        <input type="radio" name="sawFunctionalities" autocomplete="off"  value="Ja">Ja: <input class="" type="text" id="sawFunctionalitiesValue" name="sawFunctionalitiesValue" placeholder="Vul aan...">
                    </label>
                </div>
            </div>

            {{-- Ik vind het een maatschappelijk meerwaarde om dergelijke platformen aan te bieden. --}}

            <div class="form-group question carousel-item" data-toggle="buttons">
                    <label><h1>Ik vind het een maatschappelijk meerwaarde om dergelijke platformen aan te bieden.</h1></label>
                    <br>
                    <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="socialValue" autocomplete="off"  value="Helemaal mee oneens">Helemaal mee oneens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="socialValue" autocomplete="off"  value="Mee oneens">Mee oneens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="socialValue" autocomplete="off"  value="Neutraal">Neutraal
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="socialValue" autocomplete="off"  value="Mee eens">Mee eens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="socialValue" autocomplete="off"  value="Helemaal mee eens">Helemaal mee eens
                        </label>
                    </div>
                </div>


            {{-- Scales --}}

            <div class="form-group question carousel-item" data-toggle="buttons">
                <label><h1>Vond je het een meerwarde om ...</h1></label>
                <br>
                <div class="container">
                    <div class="row">
                        <small class="col-md-6 offset-md-6 pl-0"><span class="float-left">Helemaal niet</span><span class="float-right">Helemaal wel</span></small>
                    </div>
                    <div class="row">
                        <label for="scaleCN" class="col-md-6 text-right">opmerkingen te kunnen plaatsen bij artikels?</label>
                        <input type="range" class="custom-range col-md-6" min="1" max="5" step="1" value="3" id="scaleCN" name="scaleCN">
                    </div>
                    <div class="row">
                        <label for="scaleCI" class="col-md-6 text-right">opmerkingen te kunnen plaatsen in de artikels zelf (markeringen)?</label>
                        <input type="range" class="custom-range col-md-6" min="1" max="5" step="1" value="3" id="scaleCI" name="scaleCI">
                    </div>
                    <div class="row">
                        <label for="scaleUDV" class="col-md-6 text-right">opmerkingen te kunnen up- en downvoten?</label>
                        <input type="range" class="custom-range col-md-6" min="1" max="5" step="1" value="3" id="scaleUDV" name="scaleUDV">
                    </div>
                    <div class="row">
                        <label for="scaleFOM" class="col-md-6 text-right">een score te kunnen geven op de Fake-o-Meter?</label>
                        <input type="range" class="custom-range col-md-6" min="1" max="5" step="1" value="3" id="scaleFOM" name="scaleFOM">
                    </div>
                </div>
                <br>
                <label><h3>Heb je nog opmerkingen bij een van deze zaken?</h3></label>
                <br>
                <textarea class="form-control col-md-6 offset-md-3" name="scaleComments" rows="3"></textarea>
                <br>
                <button class="btn btn-outline-primary next">Volgende</button>
            </div>

            <div class="form-group text-center question carousel-item">
                <div class="justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="card" >
                                    <img src="{{ url('/images/approval.jpg') }}" class="card-img-top" alt="Proud of you meme">
                                    <div class="card-body">
                                        <h5 class="card-title">Einde</h5>
                                        <p class="card-text">Bedankt om alles in te vullen!</p>
                                        <p>
                                            <button type="submit" class="btn btn-primary mt-3">
                                                Antwoorden opslaan
                                            </button>
                                        </p>
                                    </div>
                                </div>
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