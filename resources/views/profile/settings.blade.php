@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show col-sm-4 offset-sm-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show col-sm-4 offset-sm-4">
                    {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <h1>Instellingen</h1>
        </div>
        <form class="col-12" id="form-change-password" role="form" method="POST" action="{{ url('/profile/updatePassword') }}">
            <h3>Wachtwoord aanpassen</h3>
            @csrf
            {{-- @method('UPDATE') --}}
            <div class="form-group row">
                <label for="current-password" class="col-sm-4 control-label">Huidig wachtwoord</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Wachtwoord" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="password" class="col-sm-4 control-label">Nieuw wachtwoord</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Nieuw wachtwoord" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="password_confirmation" class="col-sm-4 control-label">Bevestig nieuw wachtwoord</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Bevestig wachtwoord" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="offset-sm-4 col-sm-6">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </form>
        
        @if (session()->get('userType') == 'Free_Spirit')
            <form class="col-12" id="form-change-avatar" role="form" method="POST" action="{{ url('/profile/updateAvatar') }}" enctype="multipart/form-data">
                <h3>Profielfoto aanpassen</h3>
                @csrf
                <div class="form-group row">
                    <label for="custom-file-input" class="col-sm-4 control-label">Nieuwe profielfoto</label>
                    <div class="custom-file col-sm-8">
                        <input type="file" class="custom-file-input" id="avatar" name="avatar">
                        <label class="custom-file-label" for="avatar">Kies bestand</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-4 col-sm-6">
                        <button type="submit" class="btn btn-primary">Opslaan</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>
<script src="{{ asset('js/settings.js') }}" defer></script>

@endsection