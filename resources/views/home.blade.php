{{-- resources\views\home.blade.php --}}
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
<style>
    /* Agrega esto a tu archivo CSS */
.sidebar-mini.sidebar-collapse .nav-sidebar .nav-link {
    width: auto;
}

.sidebar-mini.sidebar-collapse .nav-sidebar .nav-item {
    width: auto;
}
</style>

    @section('js')
    <script>
$(document).ready(function () {
    // Agregar eventos para expandir y contraer el menú lateral
    $('.main-sidebar').on('mouseenter', function () {
        $('body').removeClass('sidebar-collapse').addClass('sidebar-open');
    }).on('mouseleave', function () {
        $('body').removeClass('sidebar-open').addClass('sidebar-collapse');
    });
});

    </script>
@stop

{{-- @section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop --}}