@extends('layouts.immersion')

@section('content')

<div class="header-progress-container sticky-top">
    <ol class="header-progress-list">
        <li class="header-progress-item done media-progress"></li>
        @for ($i = 0; $i < 12; $i++)
            <li class="header-progress-item todo media-progress"></li>
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
                        <div class="row my-3 step-done">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">3</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Hexad user type test</h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3 step-active">
                            <div class="col-3 d-flex align-items-center">
                                <h1 class="step-number text-center">4</h1>
                            </div>
                            <div class="col-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            <h2>Mediagebruik</h2>
                                            We komen aan de laatste vragenlijst! We pijlen naar je mediagebruik in 12 vragen.
                                            <br>
                                            <button type="button" class="btn btn-primary mt-3" id="btnStart">Start</button>
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
        <form class="text-center" action="/survey/media" method="POST">
            @csrf

            {{-- HOE VAAK --}}

            <div class="form-group question carousel-item">
                <label for="often"><h1>Hoe vaak lees je het nieuws?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="often" autocomplete="off"  value="Dagelijks">Dagelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="often" autocomplete="off"  value="Wekelijks">Wekelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="often" autocomplete="off"  value="Maandelijks">Maandelijks
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="often" autocomplete="off"  value="(bijna) Nooit">(bijna) Nooit
                    </label>
                </div>
            </div>

            {{-- BRON --}}

            <div class="form-group question carousel-item" id="sourceBox" data-toggle="buttons">
                <label for="source"><h1>Wat is je voornaamelijkste bron van nieuws?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="source" autocomplete="off"  value="Papieren krant">Papieren krant
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="source" autocomplete="off"  value="Online krant">Online krant
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="source" autocomplete="off"  value="TV Journaal">TV Journaal
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="source" autocomplete="off"  value="Facebook">Facebook
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="source" autocomplete="off"  value="Twitter">Twitter
                    </label>
                    <label class="btn btn-outline-primary preventNext">
                        <input type="radio" name="source" autocomplete="off"  value="Ander">Ander: <input class="" type="text" id="sourceValue" name="sourceValue" placeholder="Vul aan...">
                    </label>
                </div>
            </div>

            {{-- WELKE --}}

            <div class="form-group question carousel-item" data-toggle="buttons">
                <label for="reading"><h1>Welke (online) kranten lees je?</h1></label>
                <h5 class="text-muted">Selecteer één of meerdere opties</h5>
                <br>
                <div class="btn-group btn-group-toggle newspapers d-flex flex-wrap justify-content-center">
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/demorgen.jpg" alt="De Morgen">
                        <input type="checkbox" name="reading[]" value="De Morgen">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/destandaard.png" alt="De Standaard" style="background: white">
                        <input type="checkbox" name="reading[]" value="De Standaard">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/detijd.png" alt="De Tijd" style="background: white">
                        <input type="checkbox" name="reading[]" value="De Tijd">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/gva.png" alt="Gazet van Antwerpen">
                        <input type="checkbox" name="reading[]" value="Gazet van Antwerpen">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/hbvl.png" alt="Het Belang van Limburg">
                        <input type="checkbox" name="reading[]" value="Het Belang van Limburg">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/hetnieuwslad.jpg" alt="Het Nieuwsblad">
                        <input type="checkbox" name="reading[]" value="Het Nieuwsblad">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/hln.png" alt="Het Laatste Nieuws" style="background: white">
                        <input type="checkbox" name="reading[]" value="Het Laatste Nieuws">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/vrt.png" alt="VRT NWS" style="background: white">
                        <input type="checkbox" name="reading[]" value="VRT NWS">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        <img src="/images/vtm.jpg" alt="VTM Nieuws" style="background: white">
                        <input type="checkbox" name="reading[]" value="VTM Nieuws">
                    </label>
                </div>
                <br>
                <button class="btn btn-outline-primary next">Volgende</button>
            </div>

            {{-- Waar & wanneer --}}

            <div class="form-group question carousel-item" data-toggle="buttons">
                <label for="when"><h1>Waar of wanneer lees je het nieuws?</h1></label>
                <h5 class="text-muted">Selecteer één of meerdere opties</h5>
                <br>
                <div class="btn-group btn-group-toggle newspapers d-flex flex-wrap justify-content-center">
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Thuis
                        <input type="checkbox" name="when[]" value="Thuis">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Werk of school
                        <input type="checkbox" name="when[]" value="Werk of school">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Tijdens een maaltijd
                        <input type="checkbox" name="when[]" value="Tijdens een maaltijd">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Café
                        <input type="checkbox" name="when[]" value="Café">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Toilet
                        <input type="checkbox" name="when[]" value="Toilet">
                    </label>
                    <label class="btn btn-outline-primary d-flex align-items-center">
                        Ander:
                        <input type="text" name="when[]" placeholder="Vul aan...">
                    </label>
                </div>
                <br>
                <button class="btn btn-outline-primary next">Volgende</button>
            </div>

            {{-- Scales --}}

            <div class="form-group question carousel-item" data-toggle="buttons">
                <label for="when"><h1>Hoe vaak gebruik je [...] om het nieuws te lezen?</h1></label>
                <br>
                <div class="container">

                    <div class="row">
                        <small class="col-md-8 offset-md-4 pl-0"><span class="float-left">Nooit</span><span class="float-right">Altijd</span></small>
                    </div>
                    <div class="row">
                        <label for="scalePK" class="col-md-4">Papieren krant</label>
                        <input type="range" class="custom-range col-md-8" min="0" max="10" step="1" value="5" id="scalePK" name="scalePK">
                    </div>
                    <div class="row">
                        <label for="scaleSP" class="col-md-4">Smartphone</label>
                        <input type="range" class="custom-range col-md-8" min="0" max="10" step="1" value="5" id="scaleSP" name="scaleSP">
                    </div>
                    <div class="row">
                        <label for="scaleT" class="col-md-4">Tablet</label>
                        <input type="range" class="custom-range col-md-8" min="0" max="10" step="1" value="5" id="scaleT" name="scaleT">
                    </div>
                    <div class="row">
                        <label for="scaleC" class="col-md-4">Computer</label>
                        <input type="range" class="custom-range col-md-8" min="0" max="10" step="1" value="5" id="scaleC" name="scaleC">
                    </div>
                    <div class="row">
                        <label for="scaleO" class="col-md-4">Ander: <input class="col-8 p-0 mt-2" type="text" name="scaleOVal" placeholder="Vul aan..."></label>
                        <input type="range" class="custom-range col-md-8" min="0" max="10" step="1" value="5" id="scaleO" name="scaleO">
                    </div>
                </div>
                <br>
                <button class="btn btn-outline-primary next">Volgende</button>
            </div>

            {{-- Hoe vaak denk je in (impliciet) contact te komen met fake news? --}}

            <div class="form-group question carousel-item">
                <label for="oftenFake"><h1>Hoe vaak denk je (impliciet) in contact te komen met fake news?</h1></label>
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

            {{-- Hoe betrouwbaar vind je (online) kranten? --}}

            <div class="form-group question carousel-item">
                <label for="trustworthy"><h1>Hoe betrouwbaar vind je (online) kranten?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthy" autocomplete="off"  value="Helemaal niet betrouwbaar">Helemaal niet betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthy" autocomplete="off"  value="Niet betrouwbaar">Niet betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthy" autocomplete="off"  value="Neutraal">Neutraal
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthy" autocomplete="off"  value="Betrouwbaar">Betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthy" autocomplete="off"  value="Helemaal betrouwbaar">Helemaal betrouwbaar
                    </label>
                </div>
            </div>

            {{-- Hoe betrouwbaar vind je sociale media (nieuwsgewijs)? --}}

            <div class="form-group question carousel-item">
                <label for="trustworthySM"><h1>Hoe betrouwbaar vind je sociale media (nieuwsgewijs)?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthySM" autocomplete="off"  value="Helemaal niet betrouwbaar">Helemaal niet betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthySM" autocomplete="off"  value="Niet betrouwbaar">Niet betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthySM" autocomplete="off"  value="Neutraal">Neutraal
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthySM" autocomplete="off"  value="Betrouwbaar">Betrouwbaar
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="trustworthySM" autocomplete="off"  value="Helemaal betrouwbaar">Helemaal betrouwbaar
                    </label>
                </div>
            </div>

            {{-- Heb je ooit bewust een fake news artikel gezien? Indien ja, wat heb je gedaan? --}}

            <div class="form-group question carousel-item" id="sawFakeBox" data-toggle="buttons">
                <label for="sawFake"><h1>Heb je ooit bewust een fake news artikel gezien? Indien ja, heb je iets gedaan en wat?</h1></label>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="sawFake" autocomplete="off"  value="Nee">Nee
                    </label>
                    <label class="btn btn-outline-primary preventNext">
                        <input type="radio" name="sawFake" autocomplete="off"  value="Ja">Ja: <input class="" type="text" id="sawFakeValue" name="sawFakeValue" placeholder="Vul aan...">
                    </label>
                </div>
            </div>

            {{-- Ben je bereid om aan fact checking te doen?  --}}

            <div class="form-group question carousel-item">
                <label for="doFactChecking"><h1>Ben je bereid om aan fact checking te doen? </h1></label>
                <h5 class="text-muted"><a href="{{ url('/about')}}" target="_blank">Fact checking</a> is het controleren van feitelijke beweringen in non-fictieve tekst om de juistheid en juistheid van de feitelijke uitspraken in de tekst te bepalen.</h5>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="doFactChecking" autocomplete="off"  value="Altijd">Ja, ik zou dit (bijna) altijd doen
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="doFactChecking" autocomplete="off"  value="Vaak">Ja, ik zou dit wel vaker doen
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="doFactChecking" autocomplete="off"  value="Soms">Ja, ik zou dit occasioneel doen
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="doFactChecking" autocomplete="off"  value="Nooit">Nee, ik zou dit (bijna) nooit doen
                    </label>
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="doFactChecking" autocomplete="off"  value="Nutteloos">Nee, ik vind fact checken nutteloos
                    </label>
                </div>
            </div>

            {{-- Heb je al eerder aan fact checking gedaan? --}}

            <div class="form-group question carousel-item" id="alreadyFactCheckingBox" data-toggle="buttons">
                <label for="alreadyFactChecking"><h1>Heb je al eerder aan fact checking gedaan?</h1></label>
                <h5 class="text-muted"><a href="{{ url('/about')}}" target="_blank">Fact checking</a> is het controleren van feitelijke beweringen in non-fictieve tekst om de juistheid en juistheid van de feitelijke uitspraken in de tekst te bepalen.</h5>
                <br>
                <div class="btn-group btn-group-toggle next d-flex flex-wrap justify-content-center" data-toggle="buttons">
                    <label class="btn btn-outline-primary">
                        <input type="radio" name="alreadyFactChecking" autocomplete="off"  value="Nee">Nee
                    </label>
                    <label class="btn btn-outline-primary preventNext">
                        <input type="radio" name="alreadyFactChecking" autocomplete="off"  value="Ja">Ja: <input class="" type="text" id="alreadyFactCheckingValue" name="alreadyFactCheckingValue" placeholder="Waar?">
                    </label>
                </div>
            </div>

            <div class="form-group text-center question carousel-item" id="result">
                <div class="justify-content-center">
                    <h1>Einde!</h1>
                    <p>
                        <button type="submit" class="btn btn-primary mt-3" id="submitBtn">
                            Antwoorden opslaan
                        </button>
                    </p>
                </div>
            </div>        
        </form>
    </div>
</div>

<script src="{{ asset('js/survey/main.js') }}" defer></script>
@endsection