{{-- resources/views/Fabricacion/edit.blade.php --}}

@extends('adminlte::page')

@section('title', 'Editar Registro')

@section('content_header')
    <h1>Actualizar OF {{ $registro_fabricacion->Nro_OF }}</h1>
@stop

@section('content')
    <!-- Mostrar mensaje de advertencia si existe en la sesión -->
    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    @endif

    <form id="updateForm" method="POST">
        @csrf
    @method('PUT')
    <div class="form-group">
        <label for="Nro_OF">Número OF:</label>
        <input type="number" class="form-control" id="Nro_OF" name="Nro_OF" value="{{ $registro_fabricacion->Nro_OF }}" required>
    </div>
    <div class="form-group">
        <label for="Nro_Parcial">Nro Parcial:</label>
        <input type="number" class="form-control" id="Nro_Parcial" name="Nro_Parcial" value="{{ $registro_fabricacion->Nro_Parcial }}" required>
    </div>
    <div class="form-group">
        <label for="Nro_OF_Parcial">Nro OF Parcial:</label>
        <input type="text" class="form-control" id="Nro_OF_Parcial" name="Nro_OF_Parcial" value="{{ $registro_fabricacion->Nro_OF_Parcial }}" required>
    </div>
    <div class="form-group">
        <label for="Cant_Piezas">Cantidad de Piezas:</label>
        <input type="number" class="form-control" id="Cant_Piezas" name="Cant_Piezas" value="{{ $registro_fabricacion->Cant_Piezas }}" required>
    </div>
    <div class="form-group">
        <label for="Fecha_Fabricacion">Fecha de Fabricación:</label>
        <input type="date" class="form-control" id="Fecha_Fabricacion" name="Fecha_Fabricacion" value="{{ $registro_fabricacion->Fecha_Fabricacion }}" required>
    </div>
    <div class="form-group">
        <label for="Horario">Horario:</label>
        <input type="text" class="form-control" id="Horario" name="Horario" value="{{ $registro_fabricacion->Horario }}" required>
    </div>
    <div class="form-group">
        <label for="Nombre_Operario">Nombre del Operario:</label>
        <input type="text" class="form-control" id="Nombre_Operario" name="Nombre_Operario" value="{{ $registro_fabricacion->Nombre_Operario }}" required>
    </div>
    <div class="form-group">
        <label for="Turno">Turno:</label>
        <input type="text" class="form-control" id="Turno" name="Turno" value="{{ $registro_fabricacion->Turno }}" required>
    </div>
    <div class="form-group">
        <label for="Cant_Horas_Extras">Cantidad de Horas Extras:</label>
        <input type="number" class="form-control" id="Cant_Horas_Extras" name="Cant_Horas_Extras" value="{{ $registro_fabricacion->Cant_Horas_Extras }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
    <input type="hidden" name="id" value="{{ $registro_fabricacion->Id_OF }}">

</form>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#updateForm').on('submit', function(e) {
            e.preventDefault(); // Detiene el envío normal del formulario
            var formData = $(this).serialize(); // Serializa los datos del formulario

            $.ajax({
                url: '{{ route('fabricacion.update', ['fabricacion' => $registro_fabricacion->Id_OF]) }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro actualizado correctamente',
                        showConfirmButton: false,
                        timer: 1500
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location = '{{ route('fabricacion.showByNroOF', ['nroOF' => $registro_fabricacion->Nro_OF]) }}';
                        }
                    });
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el registro.'
                    });
                }
            });
        });
    });
</script>
@stop
