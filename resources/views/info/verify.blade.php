@extends('layouts.app')

@section('content')
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
            <div class="row my-3 step-active">
                <div class="col-3 d-flex align-items-center">
                    <h1 class="step-number text-center">2</h1>
                </div>
                <div class="col-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h2>Verifieer je e-mailadres</h2>
                                Ga eens kijken in je inbox, normaal gezien vind je daar een mail van ons ;) Kijk ook zeker naar je spam-folder.
                                <br>
                                Geen mail te zien? <a href="{{ route('verification.resend') }}">Stuur een nieuwe mail</a>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-3 step-todo">
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
@endsection