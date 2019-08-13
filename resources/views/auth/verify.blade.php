@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                {{-- <div class="card-header">{{ __('Verify Your Email Address') }}</div> --}}
                <div class="card-header">Verifieer je e-mailadres</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{-- {{ __('A fresh verification link has been sent to your email address.') }} --}}
                            Een nieuwe link werd juist gestuurd naar je e-mailadres.
                        </div>
                    @endif

                    Je hebt blijkbaar je e-mailadres nog niet geverifieerd. <a href="{{ route('verification.resend') }}">Stuur me een nieuwe e-mail</a>.
                    {{-- {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>. --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
