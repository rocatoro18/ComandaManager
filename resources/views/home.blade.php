@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Menú') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-sm-4">
                            <a href="/administrar">
                            <h4>Administrar</h4>
                            <img width="50px" src="{{asset('images/administrar.png')}}"/>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/cajero">
                            <h4>Cajero</h4>
                            <img width="50px" src="{{asset('images/cajero.png')}}"/>
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/reporte">
                            <h4>Reporte</h4>
                            <img width="50px" src="{{asset('images/reporte.png')}}"/>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
