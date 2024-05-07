<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\RegistroDeFabricacion;

    class RegistroDeFabricacionController extends Controller
    {
            /**
             * Muestra la página principal de registros con un filtro opcional.
             */
        public function index(Request $request)
        {
            // Obtener el valor del filtro de la solicitud
            $filtroNroOF = $request->query('filtroNroOF');
            $registros_fabricacion = RegistroDeFabricacion::with('listado_of.producto')->get();
        
            // Pasar los registros de fabricacón paginados a la vista correspondiente
            return view('Registro_de_Fabricacion.index', compact('registros_fabricacion','filtroNroOF'));
        }

        /**
            * Muestra la vista para cargar nuevos registros.
        */
        
        public function carga()
        {
            // Ejemplo: Redirigir a la página principal de registros de fabricación
            return view('Registro_de_Fabricacion.carga');
        }



        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
           * Guarda un nuevo registro en la base de datos.
        */
        public function storeCarga(Request $request)
{
    $validated = $request->validate([
        'nro_of.*' => 'required',
        'Id_Producto.*' => 'required',
        'nro_parcial.*' => 'required',
        'cant_piezas.*' => 'required|numeric',
        'fecha_fabricacion.*' => 'required|date',
        'horario.*' => 'required',
        'operario.*' => 'required',
        'turno.*' => 'required',
        'cant_horas.*' => 'required|numeric',
    ]);

    $responseData = ['success' => true, 'message' => 'Datos guardados correctamente!'];

    if (!empty($request->nro_of)) {
        foreach ($request->nro_of as $index => $nro_of) {
            if (isset($request->Id_Producto[$index], $request->nro_parcial[$index], $request->cant_piezas[$index], $request->fecha_fabricacion[$index], $request->horario[$index], $request->operario[$index], $request->turno[$index], $request->cant_horas[$index])) {
                $registro = new RegistroDeFabricacion();
                $registro->Nro_OF = $nro_of;
                $registro->Id_Producto = $request->Id_Producto[$index];
                $registro->Nro_Parcial = $request->nro_parcial[$index];
                $registro->Cant_Piezas = $request->cant_piezas[$index];
                $registro->Fecha_Fabricacion = $request->fecha_fabricacion[$index];
                $registro->Horario = $request->horario[$index];
                $registro->Nombre_Operario = $request->operario[$index];
                $registro->Turno = $request->turno[$index];
                $registro->Cant_Horas_Extras = $request->cant_horas[$index];

                try {
                    $registro->save();
                } catch (\Exception $e) {
                    $responseData = ['success' => false, 'message' => 'Error al guardar los datos: ' . $e->getMessage()];
                }
            } else {
                $responseData = ['success' => false, 'message' => 'No se han recibido datos para guardar.'];
            }
        }
    }

    return response()->json($responseData);
}

// Codigo de prueba para insertar un registro

    // public function testInsert()
    // {
    //     $registro = new RegistroDeFabricacion();
    //     $registro->Nro_OF = 1244; // Datos estáticos de prueba
    //     $registro->Id_Producto = 439;
    //     $registro->Nro_Parcial = 11;
    //     $registro->Cant_Piezas = 1100;
    //     $registro->Fecha_Fabricacion = '2024-04-30';
    //     $registro->Horario = 'H.Normales';
    //     $registro->Nombre_Operario = '';
    //     $registro->Turno = 'Mañana';
    //     $registro->Cant_Horas_Extras = 0;
    //     $registro->save();

    //     return 'Datos insertados correctamente';
    // }

        
        /**
         * Display the specified resource.
         */
        public function show(string $id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            //
        }
    }
