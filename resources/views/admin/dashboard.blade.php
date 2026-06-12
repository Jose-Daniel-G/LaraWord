@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Panel de Control</h1>
@stop

@section('content')
    {{-- LÍNEA 11: Protegida usando ?? 0 para evitar el error de count() si la variable no existe --}}
    @php
        $totalPosts = isset($posts) && is_array($posts) ? count($posts) : ($total_posts ?? 0);
    @endphp

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalPosts }}</h3>
                        <p>Publicaciones del Blog</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-blog"></i>
                    </div>
                    <a href="{{ route('admin.blog.index') }}" class="small-box-footer">
                        Ver publicaciones <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ count($usuarios ?? []) }}</h3>
                        <p>Usuarios Registrados</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                        Más información <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">¡Bienvenido al Sistema!</h3>
                    </div>
                    <div class="card-body">
                        <p>Has iniciado sesión correctamente a través de <strong>Jetstream (Livewire)</strong> y estás visualizando el panel corporativo maquetado con <strong>AdminLTE</strong>.</p>
                        <p>Usa el menú lateral para navegar entre el Dashboard y la sección de tu API de Blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Puedes añadir estilos personalizados aquí si los necesitas --}}
@stop

@section('js')
    <script> console.log('Panel de AdminLTE cargado correctamente.'); </script>
@stop