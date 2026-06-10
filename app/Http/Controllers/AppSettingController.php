<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    public function edit()
    {
        $setting = AppSetting::current();

        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = AppSetting::current();

        $data = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'app_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        unset($data['logo']);

        $setting->update($data);

        return back()->with('success', 'Settings updated.');
    }
}
