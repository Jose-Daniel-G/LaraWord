@extends('adminlte::page')

@section('title', 'Entradas de WordPress')

@section('content_header')
    <h1>Entradas del Blog (WordPress Headless)</h1>
@stop

@section('content')
    <div class="row">
        @if (count($posts) > 0)
            @foreach ($posts as $post)
                <div class="col-md-6 d-flex align-items-stretch">
                    <div
                        class="card card-outline card-primary mb-4 w-100 d-flex flex-column justify-content-between shadow-sm">

                        {{-- 1. MAPEO DE IMAGEN DESTACADA --}}
                        @if (isset($post['_embedded']['wp:featuredmedia'][0]['source_url']))
                            <img src="{{ $post['_embedded']['wp:featuredmedia'][0]['source_url'] }}" class="card-img-top"
                                alt="{!! $post['title']['rendered'] !!}" style="height: 220px; object-fit: cover;">
                        @else
                            {{-- Contenedor elegante por defecto si el post no tiene imagen en WP --}}
                            <div class="bg-gradient-secondary text-center d-flex align-items-center justify-content-center"
                                style="height: 220px; width: 100%;">
                                <div class="text-white-50">
                                    <i class="fas fa-image fa-3x mb-2"></i>
                                    <br><small>Sin imagen destacada</small>
                                </div>
                            </div>
                        @endif

                        {{-- 2. CABECERA DE LA TARJETA (TÍTULO Y TAXONOMÍAS) --}}
                        <div class="card-header">
                            <h3 class="card-title text-bold" style="font-size: 1.2rem; line-height: 1.4;">
                                {!! $post['title']['rendered'] !!}
                            </h3>

                            <div class="card-tools d-flex align-items-center flex-wrap justify-content-end">
                                {{-- MAPEO DE CATEGORÍAS --}}
                                @if (isset($post['_embedded']['wp:term'][0]) && count($post['_embedded']['wp:term'][0]) > 0)
                                    @foreach ($post['_embedded']['wp:term'][0] as $category)
                                        @if ($category['taxonomy'] === 'category')
                                            <span class="badge badge-success px-2 py-1 shadow-sm mr-1 my-1">
                                                <i class="fas fa-tag mr-1 small"></i>{{ $category['name'] }}
                                            </span>
                                        @endif
                                    @endforeach
                                @endif

                                {{-- FECHA DE PUBLICACIÓN --}}
                                <span class="badge badge-info px-2 py-1 shadow-sm my-1">
                                    <i
                                        class="far fa-calendar-alt mr-1 small"></i>{{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>

                        {{-- 3. CUERPO DE LA TARJETA (EXTRACTO) --}}
                        <div class="card-body flex-grow-1 text-muted">
                            {!! Str::limit($post['excerpt']['rendered'], 150) !!}
                            {{-- Nombre del Autor --}}
                            <div class="text-muted small mb-2">
                                <i class="fas fa-user mr-1"></i> Por:
                                <strong>
                                    {{ $post['_embedded']['author'][0]['name'] ?? 'Administrador' }}
                                </strong>
                            </div>
                        </div>

                        {{-- 4. PIE DE LA TARJETA (ACCIONES BINDING) --}}
                        <div class="card-footer text-right bg-transparent border-top-0">
                            <hr class="mt-0 mb-3">

                            {{-- Enlace dinámico para editar el post específico en tu WP local --}}
                            <a href="http://miwordpress.test/wp-admin/post.php?post={{ $post['id'] }}&action=edit"
                                target="_blank" class="btn btn-sm btn-default text-primary mr-2 shadow-sm">
                                <i class="fas fa-edit mr-1"></i> Editar en WP
                            </a>

                            {{-- Enlace dinámico para ver el artículo completo en Laravel --}}
                            <a href="{{ route('blog.show', $post['id']) }}" class="btn btn-sm btn-primary shadow-sm">
                                Leer entrada completa <i class="fas fa-arrow-right ml-1"></i>
                            </a>

                        </div>

                    </div>
                </div>
            @endforeach
        @else
            {{-- ESTADO VACÍO (Si la API no responde o no hay posts) --}}
            <div class="col-md-12">
                <div class="alert alert-warning shadow">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> No se encontraron entradas sincrónicas</h5>
                    Verifica que tengas posts publicados en tu administrador de <a href="http://miwordpress.test/wp-admin/"
                        target="_blank" class="text-dark text-underline"><b>WordPress</b></a> o comprueba que la variable
                    <code>WORDPRESS_API_URL</code> apunte correctamente en tu archivo <code>.env</code>.
                </div>
            </div>
        @endif
    </div>
@stop
