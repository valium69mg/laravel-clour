<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\File;
use \App\Models\Folder;
use Illuminate\Support\Facades\Auth;
use Storage;
use \App\Jobs\DeleteZipFilesJob;
class ZipController extends Controller
{
    // zip files from folder
    public function zipFile($id) {
        $basedir = "/home/carlostr/Documents/files_api/files-api/public/storage/";
        // check if folder exists
        $folder = Folder::where("id","=",$id,"and","user_id","=",Auth::user()->id)->first();
        if ($folder == null) {
            return redirect('/403');
        }
        // retrieve files from folder
        $filesFromDb = File::where("user_id","=",Auth::user()->id,"and","user_folder","=",$id)->get();
        // if no files on folder
        if (count($filesFromDb) == 0) {
            return redirect('/403');
        }
        // compress it into zip
        $zip = new \ZipArchive;
        $fileName = $folder->name.'.zip';
        if ($zip->open($fileName, \ZipArchive::CREATE)) {
            $filesFromStorage = Storage::disk('public')->allFiles( $folder->path);
            foreach ($filesFromStorage as $file) {
                $nameInZipFile = basename($basedir.$file);
                $zip->addFile($basedir.$file,$nameInZipFile);
            }
            $zip->close();
        }

        // call job that deletes the zip file sended
        DeleteZipFilesJob::dispatchAfterResponse();
        
        return response()->download($fileName);
    }
}
