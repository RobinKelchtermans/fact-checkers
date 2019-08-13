@extends('layouts.app')

@guest
    {{ redirect('/') }}
@endguest

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    Je mag nu gewoon verder het platform gebruiken. Je data wordt nog gelogd tot 17 mei 2019.
                    <br>
                    <br>
                    @if (auth()->user()->can_be_contacted == 0)
                        Je gaf aan om niet gemailed te worden op het einde van het onderzoek. 
                        Als je dat wilt, kan je op onderstaande knop klikken om toch de resultaten te ontvangen op: 
                        {{ auth()->user()->email }}
                        <br>
                        <br>
                        <form class="text-center" action="/profile/addCanBeContacted" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Ik wil de resultaten ontvangen op mijn e-mailadres</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection