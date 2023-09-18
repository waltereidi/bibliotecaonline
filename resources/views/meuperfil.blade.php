<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meu perfil biblioteca online</title>

        @vite('resources/js/MeuPerfil/meuperfil.ts')
    </head>

        @extends('layouts.app')
        @section('content')
            <div id="meuPerfil">
                <dadosmeuperfil :authentication="{{ json_encode(Auth::user()->api_token) }}"></dadosmeuperfil>

                <livrosmeuperfil  :authentication="{{ json_encode(Auth::user()->api_token) }}"></livrosmeuperfil>
            </div>

        @endsection


</html>
