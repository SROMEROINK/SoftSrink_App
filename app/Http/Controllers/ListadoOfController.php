<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listado_de_OF\Listado_OF;

class ListadoOfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listados_of = Listado_OF::all();
    
        // Pasar los Ingresos_mp paginados a la vista correspondiente
        return view('Listado_de_OF.index', compact('listados_of'));
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
    public function store(Request $request)
    {
        //
    }

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
