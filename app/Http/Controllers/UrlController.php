<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UrlController extends Controller
{
    public function index()
    {
        return view('url');
    }

    public function parse(Request $request)
    {
        try {
            $url = $request->input('url');

            if (!$url) {
                return view('url', [
                    'error' => 'Ingresá una URL'
                ]);
            }

            // Request HTTP
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0'
            ])->withOptions([
                'verify' => false
            ])->get($url);

            if (!$response->successful()) {
                throw new \Exception('Request fallida');
            }

            $html = $response->body();

            $data = [];

            // TITLE
            preg_match('/<title>(.*?)<\/title>/i', $html, $matches);
            $data['title'] = $matches[1] ?? null;

            // DESCRIPTION
            preg_match('/<meta[^>]+name="description"[^>]+content="([^"]+)"/i', $html, $matches);
            $data['description'] = $matches[1] ?? null;

            // OG IMAGE (más robusto)
            preg_match('/<meta[^>]+property="og:image"[^>]+content="([^"]+)"/i', $html, $matches);
            $data['image'] = $matches[1] ?? null;

            // FAVICON
            preg_match('/<link[^>]+rel="icon"[^>]+href="([^"]+)"/i', $html, $matches);
            $data['favicon'] = $matches[1] ?? null;

            // 🔥 FIX favicon relativo
            if (!empty($data['favicon']) && str_starts_with($data['favicon'], '/')) {
                $parsed = parse_url($url);
                $base = $parsed['scheme'] . '://' . $parsed['host'];
                $data['favicon'] = $base . $data['favicon'];
            }

            // 🔥 YOUTUBE DETECTION
            if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {

                preg_match('/(v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches);

                if (!empty($matches[2])) {
                    $data['youtube'] = $matches[2];
                }
            }

            return view('url', [
                'data' => $data
            ]);

        } catch (\Exception $e) {

            return view('url', [
                'error' => 'No se pudo obtener la URL'
            ]);
        }
    }
}