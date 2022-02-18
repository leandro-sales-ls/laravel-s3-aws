<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function sendFile(Request $request)
    {
        if ($request->file('file')->isValid()) {
            return $request->file('file')->store('imagens', 's3');
        }
        
    }
}
