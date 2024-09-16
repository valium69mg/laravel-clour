<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileViewController extends Controller
{
    // return view to upload a file
    public function uploadFile() {
        return view("files.uploadFile");
    }
}
