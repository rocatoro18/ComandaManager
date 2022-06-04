<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa as ModelsMesa;
use Illuminate\Contracts\Session\Session;

/**
 * Este controlador es responsable de gestionar todos los metodos
 * necesarios para que funcione el modulo de mesa
 */

class MesaController extends Controller
{
    /**
     * Se utiliza para desplegar todas las mesas
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mesas = ModelsMesa::all();
        return view('administrar.mesa')->with('mesas',$mesas);
    }

    /**
     * Se utiliza para mostrar el formulario donde se crean 
     * mesas nuevas
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.crearMesa');
    }

    /**
     * Se utiliza para almacenar un elemento recién creado
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para recibir la información del elemento a almacenar
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
     * Se utiliza para desplegar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento en especifico mostrar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Se utiliza para mostrar el formulario donde se va a editar
     * un elemento en especifico
     * @param  int  $id Utilizado para saber que elemento en especifico editar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mesa = ModelsMesa::find($id);
        return view('administrar/editarMesa')->with('mesa',$mesa);
    }

    /**
     * Se utiliza para actualizar un elemento en especifico en el almacenamiento
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para recibir la información a actualizar
     * @param  int  $id Utilizado para saber que elemento en especifico actualizar
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
     * Se utiliza para eliminar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento en especifico eliminar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        ModelsMesa::destroy($id->mesa_delete_id);
        Session()->flash('status','La mesa se ha eliminado con éxito');
        return redirect('/administrar/mesa');
    }
}
