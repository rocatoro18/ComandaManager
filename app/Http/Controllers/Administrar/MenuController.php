<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;
use App\Models\Categoria as ModelsCategoria;
use Illuminate\Auth\Events\Validated;
use App\Menu;
use App\Models\Menu as ModelsMenu;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrar.menu');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = ModelsCategoria::all();

        return view('administrar.crearMenu')->with('categorias',$categorias);
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
            'nombre' => 'required|unique:menus|max:50',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|numeric'
        ]);
        
        // Si el usuario no sube una imagen, usar noimage.png para el menú
        $imageName = "noimage.png";
        
        //Si el usuario subio una imagen
        if($request->image){
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5000'
            ]);
            $imageName = date('mdYHis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        }
        
        // Guardar informacion en la tabla menus
        $menu = new ModelsMenu();

        $menu->nombre = $request->nombre;
        $menu->precio = $request->precio;
        $menu->image = $imageName;
        $menu->descripcion = $request->descripcion;
        $menu->categoria_id = $request->categoria_id;
        $menu->save();
        $request->session()->flash('status',$request->nombre.' Se ha guardado con éxito');
        return redirect('/administrar/menu');
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
        //
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
        //
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
