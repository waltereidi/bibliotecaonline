<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meu perfil biblioteca online</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
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
