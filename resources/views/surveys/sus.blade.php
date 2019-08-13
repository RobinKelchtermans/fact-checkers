@extends('layouts.immersion')

@section('content')

<div class="header-progress-container sticky-top">
    <ol class="header-progress-list">
        <li class="header-progress-item done sus-progress"></li>
        @for ($i = 0; $i < 11; $i++)
            <li class="header-progress-item todo sus-progress"></li>
        @endfor
    </ol>
</div>
<div id="text-carousel" class="carousel slide" data-ride="carousel" data-interval="false">
    <div class="carousel-inner" id="questions">
        <div class="col-12 text-center carousel-item active" id="intro">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row my-3 step-active">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">1</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>SUS</h2>
                                            Eerst en vooral willen we jou bedanken om 28 dagen lang het nieuws via dit platform te lezen!
                                            <br>
                                            <br>
                                            Om het onderzoek af te ronden, ga je nog 2 korte vragenlijsten invullen. 
                                            We starten met de SUS-vragenlijst (system usability scale). 
                                            Deze vragenlijst pijlt naar jouw ervaring met het platform.
                                            <br>
                                            <button type="button" class="btn btn-primary mt-3" id="btnStart">Start</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-todo">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">2</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Eindenquête</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form class="text-center" action="/survey/sus" method="POST">
            @csrf
            <?php
                $questions = [
                    1 => 'Ik denk dat ik deze website vaak zal gebruiken.',
                    2 => 'Ik vind de website onnodig complex.',
                    3 => 'Ik vond deze website makkelijk te gebruiken.',
                    4 => 'Ik denk dat ik technisch support nodig heb om deze website te kunnen gebruiken.',
                    5 => 'Ik vind de verschillende functies op deze website goed geïntegreerd.',
                    6 => 'Ik vind dat er te veel inconsistentie in deze website zit.',
                    7 => 'Ik kan me voorstellen dat de meeste mensen snel door hebben hoe ze deze website moeten gebruiken.',
                    8 => 'Ik vond deze website erg omslachtig te gebruiken.',
                    9 => 'Ik voelde me zelfverzekerd toen ik deze website gebruikte.',
                    10 => 'Ik moet veel leren over deze website voordat ik het goed kan gebruiken.',
                ];
            ?>
            @foreach ($questions as $key => $question)
                <div class="form-group question carousel-item" data-toggle="buttons">
                    <label for="source"><h1>{{ $question }}</h1></label>
                    <br>
                    <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $key }}" autocomplete="off"  value="Helemaal mee oneens">Helemaal mee oneens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $key }}" autocomplete="off"  value="Mee oneens">Mee oneens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $key }}" autocomplete="off"  value="Neutraal">Neutraal
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $key }}" autocomplete="off"  value="Mee eens">Mee eens
                        </label>
                        <label class="btn btn-outline-primary">
                            <input type="radio" name="{{ $key }}" autocomplete="off"  value="Helemaal mee eens">Helemaal mee eens
                        </label>
                    </div>
                </div>
            @endforeach

            <div class="form-group question carousel-item">
                <label for="source"><h1>Heb je nog opmerkingen over het platform?</h1></label>
                <br>
                <textarea class="form-control col-md-6 offset-md-3" name="comments" rows="3"></textarea>
                <br>
                <button type="submit" class="btn btn-primary mt-3" >
                    Doorsturen
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/survey/main.js') }}" defer></script>
@endsection