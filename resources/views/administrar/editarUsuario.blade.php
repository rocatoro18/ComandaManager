@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            @include('administrar.inc.sidebar')
            <div class="col-md-8">
            <i class="fas fa-user-cog"></i>Editar un Usuario          
                <hr>
                <form action="/administrar/user/{{$user->id}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" value="{{old('name',$user->name)}}" class="form-control" placeholder="Nombre">                 
                    </div>
                    @error('name')
                            <small style="color: red;">*{{$message}}</small>
                            <br>
                    @enderror
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{old('email',$user->email)}}" class="form-control" placeholder="Email">                 
                    </div>      
                    @error('email')
                            <small style="color: red;">*{{$message}}</small>
                            <br>
                    @enderror
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">                 
                    </div>
                    @error('password')
                            <small style="color: red;">*{{$message}}</small>
                            <br>
                    @enderror
                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select name="role" class="form-control">
                            <option value="admin" {{$user->role == 'admin' ? 'selected' : ''}}>Admin</option>
                            <option value="cajero" {{$user->role == 'cajero' ? 'selected' : ''}}>Cajero</option>
                        </select>                
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

@endsection