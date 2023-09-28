@extends('layouts.app')

@vite('resources/js/Paginainicial/paginainicial.ts')

@section('content')
<div id="paginainicial">

    <PaginaInicial :token_aplicativo="{{json_encode($token_aplicativo)}}"></PaginaInicial>
</div>

@endsection
