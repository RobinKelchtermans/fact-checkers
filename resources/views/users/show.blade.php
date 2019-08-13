@extends('layouts.app')

@section('content')
<?php
    $userType = collect(JSON_decode($user->survey_hexad))['userType'];
    $userInfo = collect(JSON_decode($user->survey_hexad))['userInfo'];
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ $user->firstname }} {{ $user->lastname }}</h1>
            <p>
                <img src="{{ url('/images/' . $userType . '.jpg') }}" class="mr-3 img-thumbnail float-left" alt="{{$userType}}" style="max-width: 7em">
                <h4 class="mt-0">{{$userType}}</h4>
                {{$userInfo}}
            </p>
            <p class="mt-5">
                We zijn nog volop aan het werken aan de profielpagina's. Later meer ;)
            </p>
        </div>
    </div>
</div>

@endsection