<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller
{
    public function index()
    {
        return view('admin.site-settings.index');
    }

    public function edit()
    {
        $settings = SiteSetting::first();

        return view('admin.site-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name'       => 'required|string|max:255',
            'tagline'         => 'nullable|string|max:255',
            'meta_title'      => 'nullable|string|max:255',
            'meta_description'=> 'nullable|string',
            'meta_keywords'   => 'nullable|string',
            'logo'            => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'contact_email'   => 'nullable|email',
            'contact_phone'   => 'nullable|string|max:20',
            'address'         => 'nullable|string',
            'footer_text'     => 'nullable|string',
        ]);

        $settings = SiteSetting::first();

        $data = [
            'site_name'        => $request->site_name,
            'tagline'          => $request->tagline,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'contact_email'    => $request->contact_email,
            'contact_phone'    => $request->contact_phone,
            'address'          => $request->address,
            'footer_text'      => $request->footer_text,
        ];

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if it exists and is not the default
            if ($settings->logo && $settings->logo !== 'logo_icon/shopping.png') {
                Storage::disk('public')->delete($settings->logo);
            }
            $data['logo'] = $request->file('logo')->store('logo_icon', 'public');
        }

        $settings->update($data);

        return redirect()->back()->with('success', 'Site settings updated successfully!');
    }
}
