<?php

namespace App\Http\Controllers;

use App\Models\profile_pictures;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    //
    public function storePfp(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $imageName = time().'.'.$request->file->extension();
        $storagePath = env('FILE_STORAGE_PATH');

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        $fileSize = $request->file->getSize();

        $request->file->move($storagePath, $imageName);

        profile_pictures::create([
            'pfp_path' => $imageName,
            'size' => $fileSize
        ]);

        $pfp_id = profile_pictures::where('pfp_path', $imageName)->first()->id;

        return response()->json(['succes'=>'je picca is naar de server gebossed', 'id'=>$pfp_id]);
    }
}
