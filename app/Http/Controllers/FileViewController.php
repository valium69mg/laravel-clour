<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Folder;
use \App\Models\File;
class FileViewController extends Controller
{
    // return view to upload a file
    public function uploadFile() {
        $folders = DB::table('folders')
                        ->where('user_id',Auth::user()->id)
                        ->get();
        if (count($folders) <= 0) {
            $message = 'Folder does not exist';
            return view("files.uploadFile",compact('message'));
        }

        return view("files.uploadFile",compact('folders'));
        
    }

    public function getUpdateFileName($id) {
        $file = File::where("id","=",$id,"and","user_id","=",Auth::user()->id)->first();
        if ($file == null) {
            $errorMessage = 'No such file';
            return view('files.updateFileName',compact('errorMessage'));
        }
        return view('files.updateFileName',compact('file'));
    }
}
