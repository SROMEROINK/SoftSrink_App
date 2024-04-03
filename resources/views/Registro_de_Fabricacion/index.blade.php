{{-- resources/views/Materia_Prima/index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Fabricación - Registro_De_Fabricación')

@section('content_header')
    <h1>Registro de Fabricación</h1>  
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
                            <th>Total_Mts_MP</th>
                            <th>Precio_Unitario_Pieza</th>
                            <th>Total_Fabricado_ARS</th>            
                        </tr>
                    </thead>
                    <tbody>
                             @php
                                $totalCantPiezas = 0; // Inicializa la variable para almacenar la suma
                             @endphp
                                    @foreach ($registros_fabricacion as $registro_fabricacion)
                                    <!-- Verifica si el filtro está definido o si coincide con el Nro_OF -->
                                    @if (!isset($filtroNroOF) || $registro_fabricacion->listado_of->Nro_OF == $filtroNroOF)
                            <tr>
                                <td>{{$registro_fabricacion ->Id_OF }}</td>
                                <td>{{$registro_fabricacion ->listado_of->Nro_OF }}</td>
                                <td>{{$registro_fabricacion ->listado_of->producto->Prod_Codigo }}</td>
                                <td>{{$registro_fabricacion ->listado_of->producto->Prod_Descripcion }}</td>
                                <td>{{$registro_fabricacion ->listado_of->producto->categoria->Nombre_Categoria }}</td>
                                <td>{{$registro_fabricacion ->listado_of->Nro_Maquina }}</td>
                                <td>{{$registro_fabricacion ->listado_of->Familia_Maquinas }}</td>
                                <td>{{$registro_fabricacion ->Fecha_Fabricacion }}</td>
                                <td>{{$registro_fabricacion ->Nro_Parcial }}</td>
                                <td>{{$registro_fabricacion ->Cant_Piezas }}</td>
                                <td>{{$registro_fabricacion ->Horario}}</td>
                                <td>{{$registro_fabricacion ->Nombre_Operario }}</td>
                                <td>{{$registro_fabricacion ->Turno }}</td>
                                <td>{{$registro_fabricacion ->Cant_Horas_Extras }}</td>
                                <td>{{$registro_fabricacion ->Total_Mts_MP }}</td>
                                <td>{{$registro_fabricacion ->Precio_Unitario_Pieza}}</td>
                                <td>{{$registro_fabricacion ->Total_Fabricado_ARS }}</td>
                                </td>
                                @php
                                $totalCantPiezas += $registro_fabricacion->Cant_Piezas;
                            @endphp
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                  <!-- Agrega una fila adicional al final de la tabla para mostrar la suma -->
                  <tfoot>
                    <tr>
                        <!-- Agrega celdas vacías para las columnas previas -->
                        <td colspan="8" class="danger"></td>
                        <!-- Agrega una celda para mostrar el total de la suma -->
                        <td>Total:</td>
                        <!-- Muestra el resultado de la suma -->
                        <td id="totalCantPiezas"></td>
                        <!-- Agrega celdas vacías para las columnas siguientes -->
                        <td colspan="5"></td>
                    </tr>
                </tfoot>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Agrega los estilos de DataTables aquí -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@section('js')
    <!-- Scripts de DataTables aquí -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.6/js/dataTables.fixedHeader.min.js"></script>

    <script>
//        $(document).ready(function () {
//     var table = $('#registro_de_fabricacion').DataTable({
//         orderCellsTop: true,
//         fixedHeader: true,
//         lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Define las opciones de longitud de página
//     });

//     // Clonar la fila de encabezado y agregar filtros
//     $('#registro_de_fabricacion thead tr').clone(true).appendTo('#registro_de_fabricacion thead');

//     $('#registro_de_fabricacion thead tr:eq(1) th').each(function (i) {
//         var title = $(this).text();
//         $(this).html('<input type="text" placeholder="Buscar...' + title + '" />');

//         $('input', this).on('keyup change', function () {
//             if (table.column(i).search() !== this.value) {
//                 table.column(i).search(this.value).draw();
//             }
//         });
//     });

//     // Escucha el evento de cambio de filtro en la columna "Nro_OF"
//     $('#registro_de_fabricacion thead tr:eq(1) th:nth-child(2) input').on('keyup change', function () {
//         var filtroNroOF = $(this).val(); // Obtiene el valor del filtro aplicado a "Nro_OF"
//         var totalCantPiezas = 0; // Inicializa la variable para almacenar la suma

//         // Recorre solo las filas visibles de la tabla
//         table.rows({ search: 'applied' }).every(function () {
//             // Obtiene los datos de la fila actual como un arreglo
//             var rowData = this.data();

//             // Verifica si el valor de "Nro_OF" coincide con el filtro aplicado
//             if (rowData[1] === filtroNroOF || !filtroNroOF) { // Agrega !filtroNroOF para manejar el caso de que no haya filtro
//                 // Si coincide o no hay filtro, suma el valor de "Cant_Piezas"
//                 var columnIndex = table.column($(this.node()).index()).index(); // Obtiene el índice de la columna visible
//                 totalCantPiezas += parseFloat(rowData[columnIndex]); // Utiliza el índice correcto para la columna
//             }
//         });

//         // Actualiza el valor total en la fila del pie de página
//         $('#registro_de_fabricacion tfoot tr td:nth-child(10)').text(totalCantPiezas);
//     });
// });






            $(document).ready(function () {
            var table = $('#registro_de_fabricacion').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                pageLength: 10, // Mostrar todos los resultados por defecto
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] // Define las opciones de longitud de página
            });

            // Clonar la fila de encabezado y agregar filtros
            $('#registro_de_fabricacion thead tr').clone(true).appendTo('#registro_de_fabricacion thead');

            $('#registro_de_fabricacion thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="Buscar...' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                         // Mostrar todos los resultados después de aplicar el filtro
                        table.page.len(-1).draw();
                    }
                });
            });

            // Escucha el evento de cambio de filtro en la columna "Nro_OF"
            $('#registro_de_fabricacion thead tr:eq(1) th:nth-child(2) input').on('keyup change', function () {
                var filtroNroOF = $(this).val(); // Obtiene el valor del filtro aplicado a "Nro_OF"
                var totalCantPiezas = 0; // Inicializa la variable para almacenar la suma

                // Recorre solo las filas visibles de la tabla
                table.rows({ search: 'applied' }).every(function () {
                    // Obtiene los datos de la fila actual como un arreglo
                    var rowData = this.data();

                    // Verifica si el valor de "Nro_OF" coincide con el filtro aplicado
                    if (rowData[1] === filtroNroOF || !filtroNroOF) { // Agrega !filtroNroOF para manejar el caso de que no haya filtro
                        // Si coincide o no hay filtro, suma el valor de "Cant_Piezas"
                        totalCantPiezas += parseFloat(rowData[9]); // La columna "Cant_Piezas" es la décima columna (el índice es 9)
                    }
                });

                // Actualiza el valor total fuera de la tabla
                $('#totalCantPiezas').text(totalCantPiezas);
            });
        });
    </script>
@stop