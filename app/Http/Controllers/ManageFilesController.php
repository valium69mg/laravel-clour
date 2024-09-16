<?php

namespace App\Http\Controllers;
use App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageFilesController extends Controller
{
    //
    public function getUserFolders() {
        $user = Auth::user();
        $folders =  DB::table('folders')
                                ->orderBy('created_at')
                                ->where('user_id',$user->id)
                                ->get();
        return view('folders.getFolders',compact('folders'));
    }

    public function getUserFolder($id) {
        $user = Auth::user();
        $folder =  DB::table('folders')
                                ->orderByDesc('created_at')
                                ->where('user_id',$user->id)
                                ->where('id',$id)
                                ->get();
        
        $filesOnFolder = DB::table('files')
                                ->orderByDesc('created_at')
                                ->where('user_id',$user->id)
                                ->where('user_folder',$folder[0]->id)
                                ->get();
        return view('folders.getFolder',compact(['folder','filesOnFolder']));
    }

     // create folders
     public function createFolder(Request $request) {
        $folder = new Folder();
        $folder->name = $request->name;
        $folder->user_id = Auth::user()->id;
        $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
        $path = " storage/files/".$userFolderName.'/'.$folder->name;
        $folder->path = $path;
        $folder->save();
        
        // success
        $message = "Folder ".$folder->name." created with success";
        return view("folders.createFolder",compact("message"));
    }

    public function getFolderPage() {
        return view("folders.createFolder");

    }
}
