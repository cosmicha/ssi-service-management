<?php

namespace App\Http\Controllers;

use App\Models\Asset;

class QrAssetController extends Controller
{
    public function show(string $qr)
    {
        $asset = Asset::with(['customer','branch','category'])
            ->where('qr_uuid', $qr)
            ->orWhere('id', $qr)
            ->firstOrFail();

        $incidents = method_exists($asset, 'incidents')
            ? $asset->incidents()->latest()->limit(10)->get()
            : collect();

        $tasks = method_exists($asset, 'tasks')
            ? $asset->tasks()->latest()->limit(10)->get()
            : collect();

        return view('assets.qr-portal', compact('asset','incidents','tasks'));
    }
}
