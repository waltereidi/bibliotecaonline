@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifique seu endereço de email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Uma nova verificação de email foi enviada para seu e-mail.') }}
                        </div>
                    @endif

                    {{ __('Antes de prosseguir por favor verifique o link de ativação em seu email.') }}
                    {{ __('Se você não recebeu um email , clique para reenviar') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('reenviar outro e-mail de verificação') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
