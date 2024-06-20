<?php

namespace App\Http\Controllers;

use App\Models\profile_pictures;
use Illuminate\Http\Request;

class PfpController extends Controller
{
    //
    public function show($id)
    {
        $file_path = env('FILE_STORAGE_PATH') . '/' . profile_pictures::where('id', $id)->value('pfp_path');

        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }
}
