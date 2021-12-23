<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;
use App\Models\Categoria as ModelsCategoria;
use Illuminate\Contracts\Session\Session;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = ModelsCategoria::paginate(5);
        return view('administrar.categoria')->with('categorias',$categorias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.crearCategoria');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias|max:30'
        ]);
        $categoria = new ModelsCategoria();
        $categoria-> nombre = $request->nombre;
        $categoria-> save();
        $request->session()->flash('status', $request->nombre. " Se ha guardado con éxito");
        return(redirect('/administrar/categoria'));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = ModelsCategoria::find($id);
        return view('administrar.editarCategoria')->with('categoria',$categoria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|unique:categorias|max:30'
        ]);
        $categoria = ModelsCategoria::find($id);
        $categoria->nombre = $request->nombre;
        $categoria->save();
        $request->session()->flash('status', $request->nombre. " Se ha actualizado con éxito");
        return(redirect('/administrar/categoria'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ModelsCategoria::destroy($id);
        Session()->flash('status','La categoría se ha eliminado con éxito');
        return redirect('administrar/categoria');
    }
}
