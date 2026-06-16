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
        try {
            // Ponemos un tiempo de espera máximo de 3 segundos para no congelar Laravel
            $response = Http::timeout(3)->get($url);
            $posts = $response->successful() ? $response->json() : [];
            // Si hay un ID de categoría, se lo concatenamos usando el parámetro nativo de WP '&categories='
            if ($categoryId) {
                $url .= '&categories=' . $categoryId;
            }
        } catch (\Exception $e) {
            // Si WordPress está apagado o el puerto cambió, evitamos el "Crash" y enviamos un array vacío
            $posts = [];
            // Opcional: Podrías registrar el error en los logs de Laravel para auditoría
            // \Log::error("Error conectando a WordPress Headless: " . $e->getMessage());
        }


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
    public function create()
    {
        return view('admin.blog.create');
    }
    // Método para CREAR un post desde Laravel hacia WordPress
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // Consumimos las variables dinámicas del .env
        $url = config('services.wordpress.url', env('WORDPRESS_API_URL')) . '/posts';
        $user = env('WORDPRESS_API_USER');
        $password = env('WORDPRESS_API_PASSWORD');

        try {
            $response = Http::withBasicAuth($user, $password)->post($url, [
                'title'   => $request->title,
                'content' => $request->content,
                'status'  => 'publish' // Se publica inmediatamente en WP
            ]);

            if ($response->successful()) {
                return redirect()->route('blog.index')->with('success', '¡Post publicado!');
            }

            return back()->withErrors('Error en WP: ' . $response->body())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors('Fallo de conexión: ' . $e->getMessage())->withInput();
        }
    }

    // Método para ELIMINAR un post desde tu panel de AdminLTE
    public function destroy($id)
    {
        $url      = config('services.wordpress.url');
        $user     = config('services.wordpress.user');
        $password = config('services.wordpress.password');

        // Mandamos una petición DELETE pasándole el ID del post a la API
        $response = Http::withBasicAuth($user, $password)->delete($url . '/posts/' . $id);

        if ($response->successful()) {
            return redirect()->route('blog.index')->with('success', 'Entrada eliminada correctamente.');
        }
    }
}
