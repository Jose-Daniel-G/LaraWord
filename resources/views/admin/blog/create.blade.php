@extends('adminlte::page')

@section('title', 'Crear Entrada')

@section('content_header')
    <h1>Crear Nueva Entrada de Blog</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            {{-- Alertas por si falla la validación o la API --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible shadow">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Error en el envío</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-outline card-success shadow-sm">
                <form action="{{ route('blog.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Título del Post</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   placeholder="Escribe el título aquí..." required value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="content">Cuerpo del Artículo</label>
                            <textarea name="content" id="content" rows="8" class="form-control" 
                                      placeholder="Escribe el contenido HTML o plano aquí..." required>{{ old('content') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-right">
                        <a href="{{ route('blog.index') }}" class="btn btn-default mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="fas fa-paper-plane mr-1"></i> Publicar en WordPress
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
