<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Meu perfil biblioteca online</title>

        @vite('resources/js/PerfilUsuario/perfilUsuario.ts')
    </head>

        @extends('layouts.app')
        @section('content')
            <div id="perfilUsuario">
                <perfilusuario>

                </perfilusuario>
            </div>

        @endsection


</html>
