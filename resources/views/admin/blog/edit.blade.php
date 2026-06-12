@extends('adminlte::page')
@section('title', 'Detalle de Entrada')
@section('content_header')
    <h1>Detalle de la Entrada del Blog</h1>
@stop
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title text-bold">{!! $post['title']['rendered'] !!}</h3>
            <div class="card-tools">
                <span class="badge badge-info">{{ \Carbon\Carbon::parse($post['date'])->format('d/m/Y') }}</span>
            </div>  
        </div>
        <div class="card-body">
            {!! $post['content']['rendered'] !!}
        </div>
    </div>
@stop