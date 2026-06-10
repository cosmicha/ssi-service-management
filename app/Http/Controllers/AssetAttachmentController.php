<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetAttachment;
use Illuminate\Http\Request;

class AssetAttachmentController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $request->validate([
            'attachment_type' => ['required'],
            'attachments.*' => ['required','file','max:20480'],
        ]);

        foreach ($request->file('attachments', []) as $file)
        {
            $path = $file->store('asset-documents', 'public');

            AssetAttachment::create([
                'asset_id' => $asset->id,
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'attachment_type' => $request->attachment_type,
                'uploaded_by' => auth()->id(),
            ]);
        }

        return back()->with('success', 'Files uploaded.');
    }

    public function destroy(AssetAttachment $assetAttachment)
    {
        $assetAttachment->delete();

        return back()->with('success', 'Attachment deleted.');
    }
}
