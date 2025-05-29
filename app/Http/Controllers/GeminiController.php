<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller 
{
   public function ask(Request $request)
{
    $userMessage = trim($request->input('message'));

    if ($userMessage === '') {
        return response()->json(['reply' => 'Pesan tidak boleh kosong.']);
    }

    $apiKey = env('GEMINI_API_KEY');
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$apiKey";

    $response = Http::post($url, [
        'contents' => [
            ['parts' => [['text' => $userMessage]]]
        ]
    ]);

    if (!$response->successful()) {
        logger('Google API error: '.$response->body());
        return response()->json(['reply' => 'Terjadi kesalahan saat menghubungi Gemini.']);
    }

    $json = $response->json();

    if (isset($json['candidates'][0]['content']['parts'][0]['text'])) {
        $text = $json['candidates'][0]['content']['parts'][0]['text'];
    } else {
        logger('Gemini response unexpected: '.json_encode($json));
        $text = 'Maaf, terjadi kesalahan.';
    }

    return response()->json(['reply' => $text]);
}

}
?>