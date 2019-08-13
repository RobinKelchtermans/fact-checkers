@extends('layouts.app')

@section('content')
<div class="container bg-white shadow py-2 rounded">
    <div class="row">
        <div class="col-12">
            <div class="alert alert-primary" role="alert">
                We hebben geprobeerd om zo veel mogelijk informatie kort samen te vatten. Zit je nog steeds met vragen? Mail dan naar: <i>robin punt kelchtermans at student punt kuleuven punt be</i>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3 col-xl-2 text-right">
            <div class="nav flex-column nav-pills" id="tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="home-tab" data-toggle="pill" href="#home" role="tab" aria-controls="home" aria-selected="true">Algemeen</a>
            <a class="nav-link" id="FOM-tab" data-toggle="pill" href="#FOM" role="tab" aria-controls="FOM" aria-selected="false">Fake-o-Meter</a>
            <a class="nav-link" id="types-tab" data-toggle="pill" href="#types" role="tab" aria-controls="types" aria-selected="false">Persoonstypes</a>
            <a class="nav-link" id="who-tab" data-toggle="pill" href="#who" role="tab" aria-controls="who" aria-selected="false">Wie zijn we</a>
            <a class="nav-link" id="purpose-tab" data-toggle="pill" href="#purpose" role="tab" aria-controls="purpose" aria-selected="false">Doel onderzoek</a>
            <a class="nav-link" id="process-tab" data-toggle="pill" href="#process" role="tab" aria-controls="process" aria-selected="false">Verloop onderzoek</a>
            <a class="nav-link" id="data-tab" data-toggle="pill" href="#data" role="tab" aria-controls="data" aria-selected="false">Beheer gegevens</a>
            <a class="nav-link" id="faq-tab" data-toggle="pill" href="#faq" role="tab" aria-controls="faq" aria-selected="false">FAQ</a>
            </div>
        </div>
        <div class="col-sm-9 col-xl-10">
            <div class="tab-content text-justify" id="tabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    @include('about.home')
                </div>
                <div class="tab-pane fade" id="FOM" role="tabpanel" aria-labelledby="FOM-tab">
                    @include('about.fom')
                </div>
                <div class="tab-pane fade" id="types" role="tabpanel" aria-labelledby="types-tab">
                    @include('about.types')
                </div>
                <div class="tab-pane fade" id="who" role="tabpanel" aria-labelledby="who-tab">
                    @include('about.who')
                </div>
                <div class="tab-pane fade" id="purpose" role="tabpanel" aria-labelledby="purpose-tab">
                    @include('about.purpose')
                </div>
                <div class="tab-pane fade" id="process" role="tabpanel" aria-labelledby="process-tab">
                    @include('about.process')
                </div>
                <div class="tab-pane fade" id="data" role="tabpanel" aria-labelledby="data-tab">
                    @include('about.data')
                </div>
                <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    @include('about.faq')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/about.js') }}" defer></script>
@endsection