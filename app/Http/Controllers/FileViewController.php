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
            return view("files.uploadFile");
        }

        return view("files.uploadFile",compact('folders'));
        
    }

    public function getUpdateFileName($id) {
        $file = File::where("id","=",$id,"and","user_id","=",Auth::user()->id)->first();
        if ($file == null) {
            return redirect()->route('/403');
        }
        return view('files.updateFileName',compact('file'));
    }
}
