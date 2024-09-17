<?php

namespace App\Http\Controllers;
use App\Models\Folder;
use \App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use \App\Models\User;
class ManageFilesController extends Controller
{
    // get folders
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
        // if folder not present 
        if (count($folder) === 0) {
            return redirect('/404');
        }

        // if folder present we extract files
        $filesOnFolder = DB::table('files')
                                ->orderByDesc('created_at')
                                ->where('user_id',$user->id)
                                ->where('user_folder',$folder[0]->id)
                                ->get();
        
        return view('folders.getFolder',compact(['folder','filesOnFolder']));
    }

     // create folders
     public function createFolder(Request $request) {
        // validate name
        $folder = DB::table('folders')
                            ->where('name',$request->name)
                            ->where('user_id',Auth::user()->id)
                            ->get();
        // if folder exists
        if (count($folder) !== 0) {
            $errorMessage = "Folder already exists";
            return view("folders.createFolder",compact("errorMessage"));
        }
                                
        // if it does not exists
        $folder = new Folder();
        //$folder->name = $request->name;
        $folder->name = $request->name;
        $folder->user_id = Auth::user()->id;
        $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
        $path = "files/".$userFolderName.'/'.time();
        $folder->path = $path;
        $folder->save();
        // success
        $message = "Folder ".$folder->name." created with success";
        return view("folders.createFolder",compact("message"));
    }

    // delete folder
    public function deleteFolder($id) {
        
        // delete file
        $folderModel = Folder::where('id','=',$id)->get();
        if (count($folderModel) <= 0) {
            return redirect('/404');
        }
        // check if folder is owned by the user
        if ($folderModel[0]->user_id != Auth::user()->id) {
            // if not we redirect to 404
            return redirect('/404');
        }
        $folderPath = $folderModel[0]->path;
        $query = Storage::disk('public')->deleteDirectory($folderPath);
        
        // delete model from folder model
        $folderModel[0]->delete();

        
        // delete files from file model
        $files = File::where('user_folder',$id)->get();
        if (count($files) > 0) {
            foreach ($files as $file) {
                $file->delete();
            }
        }
        if ($query === true) {
            return redirect()->route('folders.getFolders');
        } else {
            return response()->json(["errorMessage" => "could not erase folder with ".$id." id"]);
        }

    }

    public function updateFolderName($id, Request $request) {
        $folder = Folder::where("id",$id)->first();
        // if the folder id does not exists
        if ($folder == null) {
            return redirect('/404');
        }
        // check if the user owns he folder
        if ($folder->user_id != Auth::user()->id) {
            return redirect('/404');
        }
        // if params are not met
        if (!isset($request->name)) {
            return redirect('/404');
        }
        // validate if folder name is availible
        $checkFolderExistance = Folder::where("name",$request->name)->first();
        if ($checkFolderExistance != null) {
            return redirect('/403');
        }
        $folder->name = $request->name;
        $folder->save();
        return redirect()->route('folders.getFolders');
    }
    // views
    public function getFolderPage() {
        return view("folders.createFolder");
    }


}
