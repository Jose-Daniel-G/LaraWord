<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos si el usuario envió un filtro de categoría desde la vista (ej. ?categoria=3)
        $categoryId = $request->query('categoria');

        // Base de la URL con el embed activo
        $url = config('services.wordpress.url', env('WORDPRESS_API_URL')) . '/posts?_embed';

        // Si hay un ID de categoría, se lo concatenamos usando el parámetro nativo de WP '&categories='
        if ($categoryId) {
            $url .= '&categories=' . $categoryId;
        }

        $response = Http::get($url);
        $posts = $response->successful() ? $response->json() : [];

        return view('admin.blog.index', compact('posts'));
    }
    public function show($id)
    {
        // 1. Consumimos la API de WordPress usando la variable del .env
        $url = config('services.wordpress.url', env('WORDPRESS_API_URL')) . "/posts/{$id}";

        $response = Http::get($url);

        // 2. Si la petición es exitosa, convertimos el JSON a un array
        $post = $response->successful() ? $response->json() : null;

        // 3. Retornamos la vista de AdminLTE pasándole el artículo
        return view('admin.blog.show', compact('post'));
    }
}
