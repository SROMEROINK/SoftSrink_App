{{-- resources\views\Fabricacion\show.blade.php --}}

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
                            <th>Nro_Parcial</th>
                            <th>Nro_OF_Parcial</th>
                            <th>Cant_Piezas</th>
                            <th>Fecha_Fabricacion</th>
                            <th>Horario</th>
                            <th>Nombre_Operario</th>
                            <th>Turno</th>
                            <th>Cant_Horas_Extras</th>
                            <th width="100px">Acciones</th>        
                        </tr>
                    </thead>
                    <tbody>
                        @php
                                $totalCantPiezas = 0; // Inicializa la variable para almacenar la suma
                        @endphp
                        @foreach ($registros as $registro)
                        <tr>
                            <td>{{$registro->Id_OF}}</td>
                            <td>{{$registro->listado_of->Nro_OF}}</td>
                            <td>{{$registro->Nro_Parcial}}</td>
                            <td>{{$registro->Nro_OF_Parcial}}</td>
                            <td>{{$registro->Cant_Piezas}}</td>
                            <td>{{$registro->Fecha_Fabricacion}}</td>
                            <td>{{$registro->Horario}}</td>
                            <td>{{$registro->Nombre_Operario}}</td>
                            <td>{{$registro->Turno}}</td>
                            <td>{{$registro->Cant_Horas_Extras}}</td>
                            <td>
                                <a href="{{ route('fabricacion.edit', $registro->Id_OF) }}" class="btn btn-info btn-sm">Editar</a>
                                <form action="{{ route('fabricacion.destroy', $registro->Id_OF) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Está seguro que desea eliminar este registro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm trigger-delete" data-id="{{ $registro->Id_OF }}">Eliminar</button>
                                </form>
                            </td>
                            @php
                                $totalCantPiezas += $registro->Cant_Piezas;
                            @endphp
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@stop

@section('css')
    <!-- Agrega los estilos de DataTables aquí -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <style>
        /* Estilos para centrar los datos en DataTables */
        #registro_de_fabricacion th,
        #registro_de_fabricacion td {
            text-align: center; /* Centra el contenido de las celdas */
        }

        <style>
        /* Estilos personalizados para el título */
        .titulo-cantidad {
            font-weight: bold;
            color: blue; /* Cambia el color del texto a azul */
        }

        /* Estilos personalizados para el número */
        .total-numero {
            background-color: green; /* Cambia el color de fondo a verde */
            color: white; /* Cambia el color del texto a blanco */
            padding: 3px 5px; /* Añade un poco de relleno */
            border-radius: 3px; /* Agrega bordes redondeados */
        }

        #registro_de_fabricacion td {
    white-space: nowrap; /* Evita que los contenidos de la celda se partan en líneas múltiples */
}

    </style>

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $('#registro_de_fabricacion').DataTable({
        responsive: true,
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 50,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        columnDefs: [
            { targets: [10], orderable: false, searchable: false }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        }
    });

    $('.trigger-delete').on('click', function() {
    var id = $(this).data('id');
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, deseo eliminar el registro!',
        cancelButtonText: 'No, quiero cancelar!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/fabricacion/' + id,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    swalWithBootstrapButtons.fire({
                        title: 'Eliminado!',
                        text: response.message,
                        icon: 'success',
                        showConfirmButton: true
                    }).then(() => {
                        window.location.href = response.redirect; // Utiliza la URL de redirección enviada desde el servidor
                    });
                },
                error: function() {
                    swalWithBootstrapButtons.fire(
                        'Error',
                        'No se pudo eliminar el registro.',
                        'error'
                    );
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Cancelado',
                'El registro está a salvo :)',
                'error'
            );
        }
    });
});
        
  
        
//         else if (result.dismiss === Swal.DismissReason.cancel) {
//             swalWithBootstrapButtons.fire(
//                 'Cancelado',
//                 'El registro está a salvo :)',
//                 'error'
//             );
//         }
//     });
// });




    var totalCantPiezas = 0;
    var table = $('#registro_de_fabricacion').DataTable();
    table.rows().every(function() {
        var rowData = this.data();
        totalCantPiezas += parseFloat(rowData[4]);
    });
    $('#totalCantPiezas').text(totalCantPiezas);
});
</script>

@stop
