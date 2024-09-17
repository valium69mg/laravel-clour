<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use \App\Models\Folder;
use \App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Redirect;
use \Validator;

class FileError extends Error {

    protected $time;

    public function setTime($time) {
        $this->time = $time->now();
    }

    public function getTime() {
        return $this->time;
    }
}

function generateFileErrorMessage($errorMessage,$uri,$method) {
    $error = new FileError($errorMessage);
    $error->setTime(Carbon::now());
    $errorJson = [
        'errorMessage' => $error->getMessage(),
        'time' => $error->getTime()->toDateTimeString(),
        'requestUri' => $uri,
        'method' => $method,
    ];
    return $errorJson;
}

function generateFileMessage($message,$uri,$method,$filePath) {
    $json = [
        'message' => $message,
        'time' => Carbon::now()->toDateTimeString(),
        'requestUri' => $uri,
        'method' => $method,
        'file_path' => $filePath,
    ];
    return $json;
}

class FileController extends Controller
{

    // receive a single file
    public function getFiles(Request $request) {
    
        // if request does not have a file
        if (count($request->file('files')) == 0) {
            $errorContent = generateFileErrorMessage("Files not attatched",
                             $request->getRequestUri(),$request->getMethod());
            return response(
                $errorContent,
                $status=400
            );
        }
        // validate formats for the file
        $rules = [];
        $files = count($request->file('files')) - 1;
        foreach(range(0, $files) as $index) {
            $rules['files.' . $index] = 'required|mimes:png,jpg,jpeg,webp,gif,svg,webm,mp4,avi,mov,mpg,wmv,mp3,aac,flac,wav';
        }

        $validator = Validator::make($request->all() , $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ) , 400);
        }
        // get same time function for every loop for when saving multiple files and there are no folders created
        $time = time();

        // if folder provided
        if (isset($request->folder))  {
            // folder if no folder is provided
            foreach ($request->file('files') as $file) {
                // if file is validated we proceed to save it
                $extention = $file->getClientOriginalExtension();
                $fileName = $file->getFilename();
                $newFilename = time().'_'.$fileName.'.'.$extention;
                // user folder => <username><id>/ (username's ' ' blank spaces are trimmed out of the folder name)
                $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
                    
                
                // check if folder is valid
                // validate name
                $folders = DB::table('folders')
                            ->where('user_id',Auth::user()->id)
                            ->where('id',$request->folder)
                            ->get();
                // if folder does not exists 
                if (count($folders) === 0) {
                    return redirect('/404');
                }
        
                // if folder exists
                $folder = Folder::where('id','=',$request->folder)->first();
                Storage::disk(name: 'public')->putFileAs($folder->path.'/',$file, $newFilename); 
                // save in model
                $fileModel = new \App\Models\File();
                $fileModel->size = number_format($file->getSize() / 1048576,2);
                $fileModel->name = $newFilename;
                $fileModel->extention = $extention;
                $fileModel->path = 'storage/'.$folder->path.'/'.$newFilename;
                $fileModel->user_folder = $request->folder;
                $fileModel->user_id = Auth::user()->id;
                $fileModel->save();
                
                } 
            }
        else { // if folder is not provided
            
            // create folder
            $folder = new Folder();
            // fixed time because they go on the same folder
            $folder->name = $time;
            $folder->user_id = Auth::user()->id;
            $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
            $folder->path = 'files/'.$userFolderName.'/'.$folder->name;
            $folder->save();
            foreach ($request->file('files') as $file) {  
                // file params
                $extention = $file->getClientOriginalExtension();
                $fileName = $file->getFilename();
                $newFilename = time().'_'.$fileName.'.'.$extention; 
                // save in local storage
                Storage::disk(name: 'public')->putFileAs($folder->path.'/',$file, $newFilename); 
                // save in model
                $fileModel = new \App\Models\File();
                $fileModel->size = number_format($file->getSize() / 1048576,2);
                $fileModel->name = $newFilename;
                $fileModel->extention = $extention;
                $fileModel->path = 'storage/'.$folder->path.'/'.$newFilename;
                $fileModel->user_folder = $folder->id;
                $fileModel->user_id = Auth::user()->id;
                $fileModel->save();
            }
        }
        
        
        // succesfull response
        $message = 'File(s) uploaded succesfully';
        return redirect()->back()->with('message', $message);
    }

    public function updateFileName($id,Request $request){
        $file = File::where('id','=',$id)->first();
        if ($file == null) {
            return redirect('/404');
        }
        if ($file->user_id != Auth::user()->id) {
            return redirect('/403');
        } 
        // validate request body
        if ($request->name == null) {
            return redirect('/400');
        }
        // validate if file name is availible
        $checkFileExistance = File::where("name","=",$request->name,
                                            "and","user_id","=",Auth::user()->id)->first();
        if ($checkFileExistance != null) {
            return redirect('/403');
        }
        // if all validation succeed we save the new name file
        $file->name = $request->name;
        $file->save();

        return Redirect::route('folders.getFolderById',$file->user_folder);
    }


    // delete file
    public function deleteFile($id) {
        $file = File::where('id','=',$id)->get();
        // if file does not exists
        if (count($file) <= 0) {
            return redirect('/404');
        }
        // if file exists

        // if file is not owned by the user
        if ($file[0]->user_id != Auth::user()->id) {
            return redirect('/404');
        }
        $query = Storage::disk('public')->delete(substr($file[0]->path,8));
        if ($query === true) {
            $file[0]->delete();
            return redirect()->back();
        }
        return redirect()->back();
    }


    
}

