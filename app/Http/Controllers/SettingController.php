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

            // save image to root/public/logo folder
            // $path = $request->file('app_logo')->store('public/logo');

            // move image to public_path() / logo folder
            $file = $request->file('app_logo');
            $filename = $request->file('app_logo')->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            
            $datasetting['app_logo'] = $filename;

        }

        // upload app_stempel
        if ($request->hasFile('app_stempel')) {
            // Validasi file
            $request->validate([
                'app_stempel' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
        
            // move image to public_path() / logo folder
            $file = $request->file('app_stempel');
            $filename = $request->file('app_stempel')->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            
            $datasetting['app_stempel'] = $filename;
        }

        Settings::set($datasetting);
        
        return back()->with('success', 'Pengaturan berhasil disimpan')->with('success', 'Pengaturan berhasil disimpan');
    }


}
