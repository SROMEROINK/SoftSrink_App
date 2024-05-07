@extends('adminlte::page')

@section('title', 'Carga de Producción')

@section('content_header')
    <h1>Carga de Producción</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('carga.fabricacion.submit') }}">
        @csrf
        <table class="table table-bordered" id="tablaProduccion">
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
                <!-- La fila inicial queda vacía y no visible como plantilla -->
            </tbody>
                <tr>
                    <td><input type="number" name="nro_of[]"></td>
                    <td><input type="number" name="Id_Producto[]"></td>
                    <td><input type="number" name="nro_parcial[]"></td>
                    <td><input type="number" name="cant_piezas[]"></td>
                    <td><input type="date" name="fecha_fabricacion[]"></td>
                    <td>
                        <select class="form-control horario" type="text" name="horario[]">
                            <option value="">Seleccione</option>
                            <option value="1">H.Normales</option>
                            <option value="2">H.Extras</option>
                            <option value="3">H.Extras/Sábados</option>
                        </select>
                            <!-- Campo oculto para mantener el valor del select deshabilitado -->
                            <input type="hidden" name="operario_hidden[]" value="">
                    </td>
                    <td>
                        <select class="form-control operario" type="text"  name="operario[]" disabled>
                            <!-- Las opciones de este select se actualizarán dinámicamente -->
                        </select>
                    </td>
                    <td><input type="text" class="form-control turno" name="turno[]" readonly></td>
                    <td><input type="number" name="cant_horas[]" readonly></td>
                    <td><button type="button" class="btn btn-danger eliminar">Eliminar</button></td>
                </tr>
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
            // Definir la fila base como una plantilla
        var filaBase = `<tr>
                            <td><input type="number" name="nro_of[]"></td>
                            <td><input type="number" name="Id_Producto[]"></td>
                            <td><input type="number" name="nro_parcial[]"></td>
                            <td><input type="number" name="cant_piezas[]"></td>
                            <td><input type="date" name="fecha_fabricacion[]"></td>
                            <td>
                                <select class="form-control horario" name="horario[]">
                                    <option value="">Seleccione</option>
                                    <option value="1">H.Normales</option>
                                    <option value="2">H.Extras</option>
                                    <option value="3">H.Extras/Sábados</option>
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

        // Evento para añadir una nueva fila usando la plantilla
        $('#agregarFila').click(function() {
            $('#tablaProduccion tbody').append(filaBase);
        });

        // Evento para eliminar una fila
        $(document).on('click', '.eliminar', function() {
            $(this).closest('tr').remove();
        });
    });

    // Evento para manejar el cambio en el select de Horario

    $('form').submit(function(event) {
    // Habilitar todos los campos para asegurarse de que se envíen:
    $(this).find(':input:disabled').prop('disabled', false);
});

$('form').submit(function(event) {
    // Mostrar en consola el estado de los campos
    console.log($("select[name='operario[]']").map(function(){return $(this).val();}).get());
    $(this).find(':input:disabled').prop('disabled', false);
});



            // Evento para manejar el cambio en el select de Item
            $(document).on('change', '.horario', function() {

                var horarioValue = $(this).val();
                var $row = $(this).closest('tr');
                var $operarioSelect = $row.find('.operario');
                var $operarioSelect = $(this).closest('tr').find('.operario');
                var $turnoInput = $row.find('.turno');
                var $turnoInput = $(this).closest('tr').find('.turno');
                var $cantHorasInput = $(this).closest('tr').find('input[name="cant_horas[]"]');
                

                // Limpiar campos previos
                $operarioSelect.empty();
                $turnoInput.val("");
                $cantHorasInput.val("");

                if (horarioValue === "1") {
                $turnoInput.val("Mañana"); // Establecer Turno a Mañana cuando Horario es H.Normales
                $cantHorasInput.val(9); // Puedes ajustar las horas si es necesario
                $operarioSelect.prop('disabled', true);
                $turnoInput.prop('disabled', true);
            } else {
                    var opcionesOperario = {
                        "2": [{ value: "1", text: "B.Abtt" },{ value: "2", text: "G.Silva" }, { value: "3", text: "T.Berraz" }],
                        "3": [{ value: "1", text: "B.Abtt" },{ value: "2", text: "G.Silva" }, { value: "3", text: "T.Berraz" }]
                    };
                            opcionesOperario[horarioValue].forEach(function(opcion) {
                                $operarioSelect.append(new Option(opcion.text, opcion.value));
                            });
                            $operarioSelect.prop('disabled', false);

                        if (horarioValue === "2") {
                            $turnoInput.val("Tarde");
                            $cantHorasInput.val(3);
                        } else if (horarioValue === "3") {
                            $turnoInput.val("Mañana");
                            $cantHorasInput.val(6);
                        }
                    }
                });

      // Manejar el envío del formulario
    $('form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    if (response.success) {
                        alert('Datos guardados correctamente');
                    } else {
                        // Muestra errores de validación
                        alert('Errores: ' + response.errors.join('\n'));
                    }
                },
                error: function(xhr) {
                    // Error de servidor
                    alert('Error: ' + xhr.responseText);
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

</script>
@stop







<td><input type="number" name="nro_of[]"></td>
                    <td><input type="number" name="Id_Producto[]"></td>
                    <td><input type="number" name="nro_parcial[]"></td>
                    <td><input type="number" name="cant_piezas[]"></td>
                    <td><input type="date" name="fecha_fabricacion[]"></td>
                    <td><input type="text" name="horario[]"></td>
                    <td><input type="text" name="operario[]"></td>
                    <td><input type="text" name="turno[]"></td>
                    <td><input type="number" name="cant_horas[]"></td>




