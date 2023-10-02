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
                <meuperfil
                    :api_token="{{ json_encode(Auth::user()->api_token) }}"
                    :datasourcelivros="{{ json_encode($datasourcelivros) }}"
                    :datasourcemeuperfil="{{ json_encode($datasourcemeuperfil)}}"
                    :quantidadelivros="{{ json_encode($quantidadelivros )}}"
                    ></meuperfil>

            </div>

        @endsection


</html>
