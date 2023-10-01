@extends('layouts.app')

@vite('resources/js/livros/livros.ts')

@section('content')

<div id="livros">
    <livros :datasource="{{json_encode($livro)}}"></livros>

</div>

@endsection
