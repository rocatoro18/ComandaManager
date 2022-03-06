<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;
use App\Models\Categoria as ModelsCategoria;
use Illuminate\Contracts\Session\Session;

/**
 * Clase utilizada para controlar todos los
 * metodos relacionados con el modulo
 * de categoria
 */

class CategoriaController extends Controller
{
    /**
     * Se utiliza para desplegar todas las categorías
     * en el index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = ModelsCategoria::paginate(5);
        return view('administrar.categoria')->with('categorias',$categorias);
    }

    /**
     * Se utiliza para mostrar el formulario de crear
     * una categoría nueva
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.crearCategoria');
    }

    /**
     * Se utiliza para almacenar una categoría recién creada
     *
     * @param  \Illuminate\Http\Request  $request Es utilizado para recibir la información que llega del frontend
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
     * Mostrará un objeto en especifico
     *
     * @param  int  $id Utilizado para recibir el id desde el frontend
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Se utiliza para mostrar el formulario donde se va a editar
     * un elemento en especifico
     * 
     * @param  int  $id Utilizado para recibir el id del elemento en especifico
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria = ModelsCategoria::find($id);
        return view('administrar.editarCategoria')->with('categoria',$categoria);
    }

    /**
     * Se utiliza para actualizar un elemento en especifico
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para traer todo el contenido de la solicitud
     * @param  int  $id Utilizado para especificar el elemento a actualizar
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
     * Se utiliza para eliminar un elemento en especifico
     *
     * @param  int  $id Utilizado para referenciar el elemento a eliminar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ModelsCategoria::destroy($id);
        Session()->flash('status','La categoría se ha eliminado con éxito');
        return redirect('administrar/categoria');
    }
}
