@extends('adminlte::page')

@section('title', 'Tablero')

@section('content_header')
    <h1>Tablero</h1>
@stop

@section('content')
    <p>Aqui ira el contenido de la página</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_customs.css">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop