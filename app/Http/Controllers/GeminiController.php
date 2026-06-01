<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function analisaJurnal(Request $request)
    {
        // 1. Ambil API Key dari file .env rahasia kita
        $apiKey = config('services.gemini.key') ?? env('GEMINI_API_KEY');
        
        // 2. Ini tempat kamu nanti mengambil input teks atau file jurnal dari user
        $prompt = "Tolong analisis abstrak jurnal ini: " . $request->input('abstrak');

        // 3. Menembak API Gemini (Endpoint resmi tahun 2026 biasanya menggunakan versi v1 atau v1beta)
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        // 4. Mengembalikan hasil analisis ke kodingan Frontend temenmu
        return response()->json($response->json());
    }
}