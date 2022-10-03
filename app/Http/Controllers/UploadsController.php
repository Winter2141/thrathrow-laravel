<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function upload(Request $request)
    {
        $data = $request->validate([
            'artwork' => ['required', 'string', 'min:3', 'mimes:jpg,bmp'],
            'preview' => ['required', 'string', 'min:3', 'mimes:mp3'],
            'purchase' => ['sometimes', 'string', 'min:3', 'mimes:zip']
        ]);
    }

    public function generateUploadTokens(Request $request)
    {
        $data = $request->validate([
            'artwork' => ['required', 'string', 'min:3'],
            'preview' => ['required', 'string', 'min:3'],
            'purchase' => ['sometimes', 'string', 'min:3']
        ]);
    }
}
