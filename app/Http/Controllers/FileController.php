<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        if (count($request->files) <= 0) {
            $errorContent = generateFileErrorMessage("Files not attatched",
                             $request->getRequestUri(),$request->getMethod());
            return response(
                $errorContent,
                $status=400
            );
        }
        // validate formats for the file
        $request->validate([
            'file' => 'required|mimes:png,jpg,jpeg,webp,gif,svg,webm,mp4,avi,mov,mpg,wmv,mp3,aac,flac,wav',
        ]); 

        foreach ($request->files as $file) {
                // if file is validated we proceed to save it
                $extention = $file->getClientOriginalExtension();
                $fileName = $file->getFilename();
                $newFilename = time().'_'.$fileName.'.'.$extention;
                // user folder => <username><id>/ (username's ' ' blank spaces are trimmed out of the folder name)
                $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
                
                // if folder provided
                if (isset($request->folder)) {
                // check if folder is valid
                // validate name
                $folder = DB::table('folders')
                            ->where('name',$request->name)
                            ->get();
                // if folder does not exists 
                if (count($folder) === 0) {
                    return redirect('/404');
                }
                // if folder exists
                Storage::disk(name: 'public')->putFileAs('files/'.$userFolderName.'/'.$request->folder.'/',$file, $newFilename); 
                // save in model
                $fileModel = new \App\Models\File();
                $fileModel->name = $newFilename;
                $fileModel->extention = $extention;
                $fileModel->path = 'storage/'.'files/'.$userFolderName.'/'.$request->folder.'/'.$newFilename;
                // get folder id
                $folderId = DB::table('folders')->where('name',$request->folder)->get();
                // if no folder found by provided name
                if (count($folderId) <=0) {
                    $errorMessage = 'Folder does not exists';
                    return view("files.uploadFile",compact('errorMessage'));
                }
                // assign folder id
                $fileModel->user_folder = $folderId[0]->id;
                $fileModel->user_id = Auth::user()->id;
                $fileModel->save();
            } else { // if folder is not provided
                // create folder
                $folder = new Folder();
                $folder->name = time();
                $folder->user_id = Auth::user()->id;
                $folder->path = 'files/'.$userFolderName.'/'.$folder->name;
                $folder->save();
                 // save in local storage
                Storage::disk(name: 'public')->putFileAs($folder->path.'/',$file, $newFilename); 
                // save in model
                $fileModel = new \App\Models\File();
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
        return view("files.uploadFile",compact('message'));
    }

    
}

