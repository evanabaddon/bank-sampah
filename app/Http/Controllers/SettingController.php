<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Settings;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function create()
    {
        return view('settings.form');
    }

    public function store(Request $request)
    {
        $datasetting = $request->except('_token');

        
        // Upload file app_logo
        if ($request->hasFile('app_logo')) {
            // Validasi file
            $request->validate([
                'app_logo' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
        
            $path = $request->file('app_logo')->store('public/logo');
            $datasetting['app_logo'] = Storage::url($path);
        }

        // upload app_stempel
        if ($request->hasFile('app_stempel')) {
            // Validasi file
            $request->validate([
                'app_stempel' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
        
            $path = $request->file('app_stempel')->store('public/stempel');
            $datasetting['app_stempel'] = Storage::url($path);
        }

        Settings::set($datasetting);
        
        return back()->with('success', 'Pengaturan berhasil disimpan')->with('success', 'Pengaturan berhasil disimpan');
    }


}
