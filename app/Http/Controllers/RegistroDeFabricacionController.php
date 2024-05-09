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
            return view('Fabricacion.index', compact('registros_fabricacion','filtroNroOF'));
        }

        /**
            * Muestra la vista para cargar nuevos registros.
        */
        
    //    public function store(Request $request) // Abrir formulario de carga de registros
    //     {
    //         return $request->all();
    //     }


        /**
         * Show the form for creating a new resource.
         */
        public function create() // Abrir formulario de carga de registros
        {
            return view('Fabricacion.create');
        }




        /**
           * Guarda un nuevo registro en la base de datos.
        */
        public function store(Request $request)


        {
            $messages = [
                'nro_of.*.required' => 'El número de OF es obligatorio.',
                'nro_parcial.*.required' => 'El número de parcial es obligatorio.',
                'Nro_OF_Parcial.*.unique' => 'El número de OF parcial ya ha sido registrado.',
                'cant_piezas.*.required' => 'La cantidad de piezas es obligatoria.',
                'cant_piezas.*.numeric' => 'La cantidad de piezas debe ser un número.',
                'fecha_fabricacion.*.required' => 'La fecha de fabricación es obligatoria.',
                'fecha_fabricacion.*.date' => 'La fecha de fabricación no tiene un formato válido.',
                'horario.*.required' => 'El horario es obligatorio.',
                'operario.*.nullable' => 'El nombre del operario es obligatorio.',
                'turno.*.required' => 'El turno es obligatorio.',
                'cant_horas.*.required' => 'La cantidad de horas es obligatoria.',
                'cant_horas.*.numeric' => 'La cantidad de horas debe ser un número.'
            ];

    $validated = $request->validate([
        'nro_of.*' => 'required',
        'Id_Producto.*' => 'required',
        'nro_parcial.*' => 'required',
        'Nro_OF_Parcial.*' => 'required|unique:registro_de_fabricacion,Nro_OF_Parcial',
        'cant_piezas.*' => 'required|numeric',
        'fecha_fabricacion.*' => 'required|date',
        'horario.*' => 'required',
        'operario.*' => 'nullable',  // Asegurando que es opcional
        'turno.*' => 'required',
        'cant_horas.*' => 'required|numeric',
    ], $messages);

    if (!empty($request->nro_of)) {
        foreach ($request->nro_of as $index => $nro_of) {
            if (isset($request->Id_Producto[$index], $request->nro_parcial[$index], $request->cant_piezas[$index], $request->fecha_fabricacion[$index], $request->horario[$index], $request->operario[$index], $request->turno[$index], $request->cant_horas[$index])) {
                $Nro_OF_Parcial = $nro_of . '/' . $request->nro_parcial[$index];
                

                $registro = new RegistroDeFabricacion();
                $registro->Nro_OF = $nro_of;
                $registro->Id_Producto = $request->Id_Producto[$index];
                $registro->Nro_Parcial = $request->nro_parcial[$index];
                $registro->Nro_OF_Parcial = $Nro_OF_Parcial;
                $registro->Cant_Piezas = $request->cant_piezas[$index];
                $registro->Fecha_Fabricacion = $request->fecha_fabricacion[$index];
                $registro->Horario = $request->horario[$index];
                $registro->Nombre_Operario = $request->operario[$index];
                $registro->Turno = $request->turno[$index];
                $registro->Cant_Horas_Extras = $request->cant_horas[$index];
                $registro->save();
            }
        }
        
            return response()->json(['success' => true, 'message' => 'Datos guardados correctamente!']);
        }
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
          public function show(string $id) // Mostrar un registro de fabricación
        {
            $registro_fabricacion = RegistroDeFabricacion::find($id);
            return view('Fabricacion.show', compact('registro_fabricacion'));
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(string $id) // Editar un registro de fabricación
        {
            $registro_fabricacion = RegistroDeFabricacion::find($id);
            return view('Fabricacion.edit', compact('registro_fabricacion'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id) // Actualizar un registro de fabricación
        {
            $registro_fabricacion = RegistroDeFabricacion::find($id);
            $registro_fabricacion->Nro_OF = $request->Nro_OF;
            $registro_fabricacion->Id_Producto = $request->Id_Producto;
            $registro_fabricacion->Nro_Parcial = $request->Nro_Parcial;
            $registro_fabricacion->Cant_Piezas = $request->Cant_Piezas;
            $registro_fabricacion->Fecha_Fabricacion = $request->Fecha_Fabricacion;
            $registro_fabricacion->Horario = $request->Horario;
            $registro_fabricacion->Nombre_Operario = $request->Nombre_Operario;
            $registro_fabricacion->Turno = $request->Turno;
            $registro_fabricacion->Cant_Horas_Extras = $request->Cant_Horas_Extras;
            $registro_fabricacion->save();
            return redirect()->route('fabricacion.index')->with('success', 'Registro actualizado correctamente.');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id) // Eliminar un registro de fabricación
        {
            $registro_fabricacion = RegistroDeFabricacion::find($id);
            $registro_fabricacion->delete();
            return redirect()->route('fabricacion.index')->with('success', 'Registro eliminado correctamente.');
        }
        
    }
