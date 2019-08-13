@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 d-block d-sm-none">
            <div class="alert alert-danger" role="alert">
            We hebben gemerkt dat je op een gsm (of ander klein scherm) bezig bent. We raden je aan om te registreren op een computer, aangezien een breder scherm handiger is.
            <br>
            <br>
            Je mag je nieuws steeds via gsm lezen, maar voor het fact checken raden we jou ook aan om een computer te gebruiken ;)
            </div>
        </div>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Registratie</div>

                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <h5>Opgepast!</h5>
                        <br>
                        Aangezien dit om <b>wetenschappelijk onderzoek</b> gaat, vragen we jou om het volledig registratieproces te doorlopen in één keer. Dit zou <b>ongeveer 10 tot 15 minuten</b> duren. Nadien zal je het platform voor 28 dagen gebruiken. Langer mag natuurlijk ook ;)
                        <br>
                        Meer info over het onderzoek kan je <a href="{{ url('/about') }}">hier</a> vinden en waarom je <a href="{{ url('/about') }}">bepaalde gegevens</a> moet invullen.
                    </div>
                    <div class="row ">
                        <div class="col-12">
                            <small class="float-right">
                                * = verplicht veld
                            </small>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">Voornaam*</label>
                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-right">Achternaam*</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required>

                                @if ($errors->has('lastname'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mailadres*</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- CUSTOM --}}

                        <div class="form-group row">
                            <label for="age" class="col-md-4 col-form-label text-md-right">Leeftijd*</label>

                            <div class="col-md-6">
                                <input id="age" type="number" min="0" max="130" class="form-control{{ $errors->has('age') ? ' is-invalid' : '' }}" name="age" value="{{ old('age') }}">

                                @if ($errors->has('age'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">Geslacht*</label>

                            <input type="hidden" name="gender" value="">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" type="radio" name="gender" id="genderMan" value="Man" @if(old('gender')) checked @endif>
                                    <label class="form-check-label" for="genderMan">
                                        Man
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" type="radio" name="gender" id="genderWoman" value="Vrouw" @if(old('gender')) checked @endif>
                                    <label class="form-check-label" for="genderWoman">
                                        Vrouw
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input {{ $errors->has('gender') ? ' is-invalid' : '' }}" type="radio" name="gender" id="genderOther" value="Ander" @if(old('gender')) checked @endif>
                                    <label class="form-check-label" for="genderOther">
                                        Ander
                                    </label>
                                </div>
                                @if ($errors->has('gender'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="motherTongue" class="col-md-4 col-form-label text-md-right">Moedertaal*</label>

                            <input type="hidden" name="motherTongue" value="">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="motherTongue" id="motherTongueNL" value="Nederlands" @if(old('motherTongue')) checked @endif>
                                    <label class="form-check-label" for="motherTongueNL">
                                        Nederlands
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="motherTongue" id="motherTongueEN" value="Engels" @if(old('motherTongue')) checked @endif>
                                    <label class="form-check-label" for="motherTongueEN">
                                        Engels
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="motherTongue" id="motherTongueFR" value="Frans" @if(old('motherTongue')) checked @endif>
                                    <label class="form-check-label" for="motherTongueFR">
                                        Frans
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="motherTongue" id="motherTongueOther" value="Ander" @if(old('motherTongue')) checked @endif>
                                    <label class="form-check-label" for="motherTongueOther">
                                        Ander
                                    </label>
                                </div>

                                @if ($errors->has('motherTongue'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('motherTongue') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="education" class="col-md-4 col-form-label text-md-right">Opleiding (gehaald of mee bezig)*</label>

                            <input type="hidden" name="education" value="">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationHS" value="Middelbaar" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationHS">
                                        Middelbaar of lager
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationPBA" value="PBA" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationPBA">
                                        Professionele Bachelor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationABA" value="ABA" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationABA">
                                        Academische Bachelor
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationMa" value="Master" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationMa">
                                        Master
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationPhD" value="PhD" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationPhD">
                                        Doctoraat
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="education" id="educationOther" value="Ander" @if(old('education')) checked @endif>
                                    <label class="form-check-label" for="educationOther">
                                        Ander
                                    </label>
                                </div>

                                @if ($errors->has('education'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('education') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="howHere" class="col-md-4 col-form-label text-md-right">Hoe ben je hier terecht gekomen?</label>

                            <div class="col-md-6">
                                <textarea class="form-control{{ $errors->has('howHere') ? ' is-invalid' : '' }}" id="howHere" rows="3" name="howHere" value="{{ old('howHere') }}"></textarea>

                                @if ($errors->has('howHere'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('howHere') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- PASSWORD --}}

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Wachtwoord*</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required aria-describedby="passwordHelpBlock">
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    Je wachtwoord moet minstens 6 tekens lang zijn.
                                </small>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Bevestig wachtwoord*</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        {{-- INFORMED CONSENT --}}

                        <div class="form-group row">    
                            <div class="col-md-8 offset-md-4">
                                <div id="informedConsentBox" class="alert alert-secondary" role="alert">
                                    @include('partials.informedConsent')
                                </div>
                                <a href="{{ url('/files/informatiebrochure.pdf') }}" target="_blank">Download PDF-versie</a>
                            </div>
                        </div>

                        {{-- CHECKBOXES --}}

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="hidden" name="canBeContacted" value="off">
                                    <input type="checkbox" class="custom-control-input" id="canBeContacted" name="canBeContacted">
                                    <label class="custom-control-label" for="canBeContacted">
                                        Ik wil op de hoogte gehouden worden van het eindresultaat van het onderzoek via e-mail.
                                    </label>
                                </div>

                                @if ($errors->has('canBeContacted'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('canBeContacted') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="privacyPolicy" name="privacyPolicy" onclick="toggleSubmit()">
                                    <label class="custom-control-label" for="privacyPolicy">
                                        * Ik heb de voorwaarden gelezen. Ik word gevraagd om 28 dagen het platform te gebruiken en zal fake news tegenkomen. Ik heb het recht om op eender welk moment, ongeacht de reden, met deze proef te stoppen.
                                    </label>
                                </div>

                                @if ($errors->has('privacyPolicy'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('privacyPolicy') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" id="submitBtn" disabled="disabled">
                                    Registreer
                                </button>
                                <br>
                                <span id="ICFAccept"> Je moet de hele informatiebrochure (grijs kader) doornemen voordat je kan registreren.</span>
                                <div class="d-none" id="registerBtnSpinner">
                                    Loading...
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/register.js') }}" defer></script>
@endsection
