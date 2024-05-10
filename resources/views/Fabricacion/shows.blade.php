{{-- resources/views/Materia_Prima/index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Editar - Registros')

@section('content_header')
    <h2>Actualizar OF</h2>  
    <h1>
        Cantidad de piezas fabricadas: 
        <span id="totalCantPiezas" class="total-numero">0</span>
    </h1>
    <a href="{{ route('fabricacion.create') }}" class="btn btn-success">Ir a Carga de Producción</a>

    <style>
        /* Estilos personalizados para el título */
        .titulo-cantidad {
            font-weight: bold;
            color: blue; /* Cambia el color del texto a azul */
        }

    </style>

@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-16">

                <!-- Tu contenido va aquí -->
                <table id="registro_de_fabricacion" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id_OF</th>
                            <th>Nro_OF</th>
                            <th>Código de Producto</th>
                            <th>Descripción</th>
                            <th>Clase Familia</th>
                            <th>Nro de Máquina</th>
                            <th>Familia de Máquinas</th>
                            <th>Fecha_Fabricacion</th>
                            <th>Nro_Parcial</th>
                            <th>Cant_Piezas</th>
                            <th>Horario</th>
                            <th>Nombre_Operario</th>
                            <th>Turno</th>
                            <th>Cant_Horas_Extras</th>
                            <th>colspan="2"</th>          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($registro_fabricacion as $registro_fabricacion)
                            <tr>
                                <td>{{$registro_fabricacion ->Id_OF }}</td>
                                <td>{{$registro_fabricacion ->listado_of->Nro_OF }}</td>
                                <td>{{$registro_fabricacion ->listado_of->producto->Id_Producto }}</td>
                                <td>{{$registro_fabricacion ->Nro_Parcial }}</td>
                                <td>{{$registro_fabricacion ->Nro_OF_Parcial }}</td>
                                <td>{{$registro_fabricacion ->Cant_Piezas }}</td>
                                <td>{{$registro_fabricacion ->Fecha_Fabricacion }}</td>
                                <td>{{$registro_fabricacion ->Horario}}</td>
                                <td>{{$registro_fabricacion ->Nombre_Operario }}</td>
                                <td>{{$registro_fabricacion ->Turno }}</td>
                                <td>{{$registro_fabricacion ->Cant_Horas_Extras }}</td>
                                <td>
                                    <form action="{{ route('fabricacion.update', $registro_fabricacion->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="Nro_OF">Número OF</label>
                                            <input type="text" class="form-control" id="Nro_OF" name="Nro_OF" value="{{ $registro_fabricacion->Nro_OF }}">
                                        </div>
                                        <!-- Más campos como este -->
                                        <button type="submit" class="btn btn-primary">Actualizar</button>
                                </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('js')

</script>
@stop
