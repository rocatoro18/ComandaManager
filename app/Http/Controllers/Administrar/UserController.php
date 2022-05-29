<?php

namespace App\Http\Controllers\Administrar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User as ModelsUser;

/**
 * Este controlador es responsable de gestionar todos los metodos
 * necesarios para que funcione el modulo de usuario
 */

class UserController extends Controller
{
    /**
     * Se utiliza para mostrar todos los usuario en el index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ModelsUser::all();
        return view('administrar.usuario')->with('users',$users);
    }

    /**
     * Se utiliza para mostrar el formulario donde se va a crear un nuevo usuario
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('administrar.crearUsuario');
    }

    /**
     * Se utiliza para almacenar un usuario recién creado
     *
     * @param  \Illuminate\Http\Request  $request Se utiliza para recibir la informacion del frontend del usuario a almacenar
     * @return \Illuminate\Http\Response 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|min:4|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);
        $user = new ModelsUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        $request->session()->flash('status', $request->name. ' Se ha creado con éxito');
        return redirect('/administrar/user');
    }

    /**
     * Se utiliza para mostrar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento en especifico mostrar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Se utiliza para mostrar el formulario donde se va a editar un elemento en especifico
     *
     * @param  int  $id Utilizado para saber que elemento en especifico editar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = ModelsUser::find($id);
        return view('administrar.editarUsuario')->with('user',$user);
    }

    /**
     * Se utiliza para actualizar un elemento en especifico
     *
     * @param  \Illuminate\Http\Request  $request Utilizado para recibir la información desde el frontend
     * @param  int  $id Utilizado para saber que elemento en especifico actualizar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:4|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);
        $user = ModelsUser::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        $request->session()->flash('status', $request->name. ' Se ha actualizado con éxito');
        return redirect('/administrar/user');
    }

    /**
     * Se utiliza para eliminar un elemento en especifico del almacenamiento
     *
     * @param  int  $id Utilizado para saber que elemento en especifico eliminar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ModelsUser::destroy($id);
        Session()->flash('status','El usuario se ha eliminado con éxito');
        return redirect('/administrar/user');
    }
}
