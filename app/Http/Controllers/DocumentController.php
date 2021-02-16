<?php

namespace App\Http\Controllers;

use App\FileDocument;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function fileStore(Request $request)
    {
        $doc = $request->file('file');
        $docName = $doc->getClientOriginalName();
        Storage::disk('uploads')->putFileAs('documents', $doc, $docName);

        $fileDocument = FileDocument::create([
            'userId' => Auth::id(),
            'file' => $docName,
        ]);
        return response()->json($fileDocument, 201);
    }

    public function getDocument($id)
    {
        $document = FileDocument::find($id);
        return Storage::disk('uploads')->download("documents/{$document->file}");
    }
}
