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
}
