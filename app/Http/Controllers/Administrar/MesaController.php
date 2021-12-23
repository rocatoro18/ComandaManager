<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa as ModelsMesa;


class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mesas = ModelsMesa::all();
        return view('administrar.mesa')->with('mesas',$mesas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.crearMesa');
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
            'nombre' => 'required|unique:mesas|max:30'
        ]);
        $mesa = new ModelsMesa();
        $mesa->nombre = $request->nombre;
        $mesa->save();
        $request->session()->flash('status','Mesa '.$request->nombre.' Se ha creado con éxito');
        return redirect('administrar/mesa');
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
        $mesa = ModelsMesa::find($id);
        return view('administrar/editarMesa')->with('mesa',$mesa);
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
        $request->validate(['nombre'=>'required|unique:mesas|max:30']);
        $mesa = ModelsMesa::find($id);
        $mesa->nombre = $request->nombre;
        $mesa->save();
        $request->session()->flash('status','La mesa se ha actualizado a '.$request->nombre.' con éxito');
        return redirect('/administrar/mesa');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
