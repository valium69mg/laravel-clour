<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
    protected $allowedExtensions = [
        'jpeg',
        'jpg',
        'png',
        'webp',
    ];

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
            'file' => 'required|mimes:png,jpg,jpeg,webp',
        ]); 

        foreach ($request->files as $file) {
            // if file is validated we proceed to save it
            $extention = $file->getClientOriginalExtension();
            $fileName = $file->getFilename();
            $newFilename = time().'_'.$fileName.'.'.$extention;
            // user folder => <username><id>/ (username's ' ' blank spaces are trimmed out of the folder name)
            $userFolderName = str_replace(' ', '', Auth::user()->name.Auth::user()->id);
            Storage::disk('public')->putFileAs('files/'.$userFolderName,$file, $newFilename);

            // save in model
            $fileModel = new \App\Models\File();
            $fileModel->name = $newFilename;
            $fileModel->extention = $extention;
            $fileModel->path = 'storage/files/'.$userFolderName.'/'.$newFilename;
            $fileModel->user_folder = $userFolderName;
            $fileModel->save();
        }
        
        
        // succesfull response
        $message = 'File(s) uploaded succesfully';
        return view("files.uploadFile",compact('message'));
    }
}

