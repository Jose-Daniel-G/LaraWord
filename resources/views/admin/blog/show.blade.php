@extends('adminlte::page')

@section('title', $post['title']['rendered'] ?? 'Detalle del Post')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>{!! $post['title']['rendered'] !!}</h1>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver al listado
        </a>
    </div>
@stop

@section('content')
    <div class="card card-outline card-primary shadow">
        <div class="card-body" style="font-size: 1.1rem; line-height: 1.8;">
            <div class="text-muted mb-4">
                <i class="far fa-calendar-alt mr-1"></i> Publicado el: {{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y h:i A') }}
            </div>
            <hr>
            {{-- Pintamos el contenido HTML completo que genera Gutenberg de WordPress --}}
            <div class="wp-content">
                {!! $post['content']['rendered'] !!}
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <a href="http://miwordpress.test/wp-admin/post.php?post={{ $post['id'] }}&action=edit" target="_blank" class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i> Corregir o Editar entrada
            </a>
        </div>
    </div>
@stop