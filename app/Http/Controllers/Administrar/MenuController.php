<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Categoria;
use App\Models\Categoria as ModelsCategoria;
use Illuminate\Auth\Events\Validated;
use App\Menu;
use App\Models\Menu as ModelsMenu;
use Illuminate\Contracts\Session\Session;

/**
 * Este controlador es responsable de gestionar todos los metodos
 * necesarios para que funcione el modulo de menu
 */

class MenuController extends Controller
{
    /**
     * Se utiliza para desplegar todos los menus
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = ModelsMenu::all();
        return view('administrar.menu')->with('menus',$menus);
    }

    /**
     * Se utiliza para mostrar el formulario donde
     * se va a crear un menu nuevo
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias = ModelsCategoria::all();

        return view('administrar.crearMenu')->with('categorias',$categorias);
    }

    /**
     * Se utiliza para almacenar un menu recién creado
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para recibir la información proveniente del frontend
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
     * Se utiliza para mostrar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento mostrar
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
     * @param  int  $id Utilizado para recibir el id del elemento a editar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = ModelsMenu::find($id);
        $categorias = ModelsCategoria::all();
        return view('administrar.editarMenu')->with('menu',$menu)->with('categorias',$categorias);
    }

    /**
     * Se utiliza para actualizar un elemento en especifico 
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para recibir la información del frontend
     * @param  int  $id Utilizado para saber que elemento actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validación de informacion
        $request->validate([
            'nombre' => 'required|max:50',
            'precio' => 'required|numeric',
            'categoria_id' => 'required|numeric'
        ]);
        $menu = ModelsMenu::find($id);
        // validar si el usuario subio imagen
        if($request->image){
            $request->validate([
                'image' => 'nullable|file|image|mimes:jpeg,png,jpg|max:5000'
            ]);
            if($menu->image != "noimage.png"){
                $imageName = $menu->image;
                unlink(public_path('menu_images').'/'.$imageName);
            }
            $imageName = date('mdYHis').uniqid().'.'.$request->image->extension();
            $request->image->move(public_path('menu_images'), $imageName);
        }else{
            $imageName = $menu->image;
        }

        $menu->nombre = $request->nombre;
        $menu->precio = $request->precio;
        $menu->image = $imageName;
        $menu->descripcion = $request->descripcion;
        $menu->categoria_id = $request->categoria_id;
        $menu->save();
        $request->session()->flash('status',$request->nombre.' Se ha actualizado con éxito');
        return redirect('/administrar/menu');

    }

    /**
     * Se utiliza para eliminar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento en hay que eliminar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = ModelsMenu::find($id);
        if($menu->image != "noimage.png"){
            unlink(public_path('menu_images').'/'.$menu->image);
        }
        $nombreMenu = $menu->nombre;
        $menu->delete();
        Session()->flash('status',$nombreMenu." Se ha eliminado con éxito");
        return redirect('/administrar/menu');
    }
}
