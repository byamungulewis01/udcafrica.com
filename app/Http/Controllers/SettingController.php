<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $siteSettings = Setting::getGroup('site');
        $emailSettings = Setting::getGroup('email');
        $localizationSettings = Setting::getGroup('localization');

        return Inertia::render('Admin/Settings/Index', [
            'settings' => [
                'site' => $siteSettings,
                'email' => $emailSettings,
                'localization' => $localizationSettings
            ]
        ]);
    }

    public function updateSiteSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_title' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'favicon' => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoName = time() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('uploads/settings'), $logoName);
            $data['logo'] = '/uploads/settings/' . $logoName;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            $faviconName = time() . '_' . $request->file('favicon')->getClientOriginalName();
            $request->file('favicon')->move(public_path('uploads/settings'), $faviconName);
            $data['favicon'] = '/uploads/settings/' . $faviconName;
        }

        foreach ($data as $key => $value) {
            Setting::set($key, $value, 'site');
        }

        return redirect()->back()->with('success', 'Site settings updated successfully');
    }

    public function updateEmailSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string',
            'smtp_password' => 'required|string',
            'smtp_encryption' => 'required|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        foreach ($request->all() as $key => $value) {
            Setting::set($key, $value, 'email');
        }

        return redirect()->back()->with('success', 'Email settings updated successfully');
    }

    public function updateLocalizationSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'timezone' => 'required|string',
            'language' => 'required|string|size:2',
            'date_format' => 'required|string',
            'time_format' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        foreach ($request->all() as $key => $value) {
            Setting::set($key, $value, 'localization');
        }

        return redirect()->back()->with('success', 'Localization settings updated successfully');
    }
}
