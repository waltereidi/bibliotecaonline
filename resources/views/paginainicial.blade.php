@extends('layouts.app')

@vite('resources/js/Paginainicial/paginainicial.ts')

@section('content')


<div id="paginainicial">
    <PaginaInicial :token_aplicativo="'sdsd'"></PaginaInicial>
</div>

@endsection
