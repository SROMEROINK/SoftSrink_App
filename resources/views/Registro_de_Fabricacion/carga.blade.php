@extends('adminlte::page')

@section('title', 'Carga de Producción')

@section('content_header')
    <h1>Carga de Producción</h1>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/carga_blade.css') }}">
@stop

@section('content')


    <form method="post" action="{{ route('carga.fabricacion.submit') }}">
        @csrf
        <table class="table table-bordered custom-font centered-form"  id="tablaProduccion">
            <thead>
                <tr>
                    <th>N° OF</th>
                    <th>Id_Producto</th>
                    <th>N° de Parcial</th>
                    <th>Cant.Piezas</th>
                    <th>Fecha de Fabricación</th>
                    <th>Horario</th>
                    <th>Operario</th>
                    <th>Turno</th>
                    <th>Cant. de Horas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- La fila inicial queda vacía y oculta para ser usada como plantilla -->
            </tbody>
        </table>
        <div class="btn-der">
            <button type="button" class="btn btn-success" id="agregarFila">Agregar Fila</button>
            <input type="submit" class="btn btn-primary" value="Guardar Cambios">
        </div>
    </form>
@stop

@section('js')

<script>
    $(document).ready(function() {
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
        // Bienvenida con SweetAlert2
        Swal.fire(
            '¡Bienvenido a la carga de datos!',
            'Tenga cuidado al duplicar los parciales de las OF!!',
            'success'
        );



        }); 

        // Agregar una fila base a la tabla
        var filaBase = `<tr>
                            <td><input type="number" name="nro_of[]"></td>
                            <td><input type="number" name="Id_Producto[]"></td>
                            <td><input type="number" name="nro_parcial[]"></td>
                            <td><input type="number" name="cant_piezas[]"></td>
                            <td><input type="date" name="fecha_fabricacion[]"></td>
                            <td>
                                <select class="form-control horario" name="horario[]">
                                    <option value="">Seleccione</option>
                                    <option value="H.Normales">H.Normales</option>
                                    <option value="H.Extras">H.Extras</option>
                                    <option value="H.Extras/Sábados">H.Extras/Sábados</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control operario" name="operario[]" disabled>
                                    <!-- Las opciones de este select se actualizarán dinámicamente -->
                                </select>
                            </td>
                            <td><input type="text" class="form-control turno" name="turno[]" readonly></td>
                            <td><input type="number" name="cant_horas[]" readonly></td>
                            <td><button type="button" class="btn btn-danger eliminar">Eliminar</button></td>
                        </tr>`;

        $('#agregarFila').click(function() {
            $('#tablaProduccion tbody').append(filaBase);
        });

        $(document).on('change', '.horario', function() {
            var $row = $(this).closest('tr');
            
            var horarioValue = $(this).val();
            var $operarioSelect = $row.find('.operario');
            var $turnoInput = $row.find('.turno');
            var $cantHorasInput = $row.find('input[name="cant_horas[]"]');

            $operarioSelect.empty();
            $turnoInput.val("");
            $cantHorasInput.val("");

            if (horarioValue === "H.Normales") {
                $turnoInput.val("Mañana");
                $cantHorasInput.val(8);
                $operarioSelect.prop('disabled', true);
            } else {
                var opcionesOperario = {
                    "H.Extras": [{ value: "B.Abtt", text: "B.Abtt" },{ value: "G.Silva", text: "G.Silva" }, { value: "T.Berraz", text: "T.Berraz" }],
                    "H.Extras/Sábados": [{ value: "B.Abtt", text: "B.Abtt" },{ value: "G.Silva", text: "G.Silva" }, { value: "T.Berraz", text: "T.Berraz" }]
                };

                opcionesOperario[horarioValue].forEach(function(opcion) {
                    $operarioSelect.append(new Option(opcion.text, opcion.value));
                });
                $operarioSelect.prop('disabled', false);

                if (horarioValue === "H.Extras") {
                    $turnoInput.val("Tarde");
                    $cantHorasInput.val(3);
                } else if (horarioValue === "H.Extras/Sábados") {
                    $turnoInput.val("Mañana");
                    $cantHorasInput.val(6);
                }
            }
        });

        $(document).on('click', '.eliminar', function() {
            $(this).closest('tr').remove();
        });

        $('form').submit(function(event) {
    event.preventDefault();
    $(this).find(':input:disabled').prop('disabled', false);
    var formData = $(this).serialize();

    $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: formData,
        success: function(response) {
            // Utiliza SweetAlert2 para mostrar un mensaje de éxito
            Swal.fire({
                icon: 'success',
                title: '¡Datos guardados correctamente!',
                text: 'Los datos se han guardado con éxito.'
            }).then(function() {
                // Opcional: recargar la página o redirigir
                location.reload(); 
            });
        },
        error: function(xhr) {
            // Utiliza SweetAlert2 para mostrar un mensaje de error
            Swal.fire({
                icon: 'error',
                title: 'Error al guardar',
                text: 'No se pudo guardar la información: ' + xhr.statusText
            });
        }
    });
});

    // Función para buscar y llenar el ID del Producto basado en el Nro de OF
    function buscarIdProducto(nroOf, $fila) {
        if (nroOf) {
            $.ajax({
                url: '/listado-of/get-id-producto/' + encodeURIComponent(nroOf),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $fila.find('input[name="Id_Producto[]"]').val(response.id_producto);
                    } else {
                        alert(response.message); // Mensaje de error si no se encuentra el producto
                        $fila.find('input[name="Id_Producto[]"]').val('');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error al buscar el ID del producto: ' + error);
                }
            });
        }
    }

    // Evento para detectar el cambio en el campo de N° OF
    $(document).on('change', 'input[name="nro_of[]"]', function() {
        var nroOf = $(this).val();
        var $fila = $(this).closest('tr'); // La fila donde se hizo el cambio
        buscarIdProducto(nroOf, $fila);
    });

    // Auto-cierre de alertas después de 5 segundos
    $(".alert").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert").slideUp(500);
        });
</script>
@stop
