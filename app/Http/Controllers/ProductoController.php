<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Producto; // Asegúrate de usar el namespace correcto de tu modelo

    class ProductoController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
    
        public function index()
        {
            // Obtener los productos de la base de datos y paginarlos
            $productos = Producto::paginate(10); // Esto paginará los resultados, mostrando 10 productos por página
        
            // Pasar los productos paginados a la vista correspondiente
            return view('productos.index', compact('productos'));
        }
        

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request) // para guardar en la BD el nuevo registro
        {
            //
        }

        /**
         * Display the specified resource.
         */
        public function show(string $id) // visualizar un solo registro a detalle
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        // public function edit(string $id) // para abrir un formulario para edicion de un registro
        //{
            //
        //}


        public function edit(Producto $producto)
        {
            // Aquí debes devolver la vista de edición y pasar el producto a esa vista
            return view('productos.edit', compact('producto'));
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id) // para actualizar la  informacion del registro que se esta editando en la base de datos
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
    /* public function destroy(string $id) //  eliminar un registro especifico
        {
            //
        }*/


        public function destroy(Producto $producto)
        {
            // Aquí debes eliminar el producto y luego redirigir a donde necesites
            $producto->delete();

            return redirect()->route('productos.index')->with('success', 'Producto eliminado con éxito'); //  eliminar un registro especifico
        }
    }
