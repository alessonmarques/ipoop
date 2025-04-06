<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function destroy(Photo $photo)
    {
        // Delete the image file
        if (Storage::exists($photo->path)) {
            Storage::delete($photo->path);
        }

        // Delete from database
        $photo->delete();

        return back()->with('success', 'Foto excluída com sucesso.');
    }
}