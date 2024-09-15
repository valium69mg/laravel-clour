<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    // receive a file
    public function getFile(Request $request) {
        dd($request);
    }
}
