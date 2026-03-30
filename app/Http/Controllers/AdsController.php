<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ads = Ad::where('active', true)->orderBy('created_at', 'desc')->get();
        return view('ads.index', compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img_en' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'active' => 'boolean',
        ]);

        // Create ads directory if it doesn't exist
        $adsDir = public_path('ads');
        if (!file_exists($adsDir)) {
            mkdir($adsDir, 0755, true);
        }

        // Store Arabic Image
        $file = $request->file('img');
        $image = imagecreatefromstring($file->get());
        $filename = time() . '_ar_' . uniqid() . '.webp';
        $path = $adsDir . '/' . $filename;
        imagewebp($image, $path, 85);
        imagedestroy($image);
        $curr_path = 'ads/' . $filename;

        // Store English Image if provided
        $curr_path_en = null;
        if ($request->hasFile('img_en')) {
            $file_en = $request->file('img_en');
            $image_en = imagecreatefromstring($file_en->get());
            $filename_en = time() . '_en_' . uniqid() . '.webp';
            $path_en = $adsDir . '/' . $filename_en;
            imagewebp($image_en, $path_en, 85);
            imagedestroy($image_en);
            $curr_path_en = 'ads/' . $filename_en;
        }

        $ad = Ad::create([
            'path' => $curr_path,
            'path_en' => $curr_path_en,
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'],
            'description_ar' => $validated['description_ar'],
            'description_en' => $validated['description_en'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'active' => $validated['active'] ?? true,
        ]);

        return redirect()->route('ad.index')->with('success', 'تم إنشاء الإعلان بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ad $ad)
    {
        return view('ads.show', compact('ad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ad $ad)
    {
        return view('ads.edit', compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ad $ad)
    {
        $validated = $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'img_en' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'active' => 'boolean',
        ]);

        $updateData = [
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'],
            'description_ar' => $validated['description_ar'],
            'description_en' => $validated['description_en'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'active' => $validated['active'] ?? $ad->active,
        ];

        // Handle Arabic image update if provided
        if ($request->hasFile('img')) {
            // Delete old Arabic image
            if ($ad->path && file_exists(public_path($ad->path))) {
                unlink(public_path($ad->path));
            }

            // Create ads directory if it doesn't exist
            $adsDir = public_path('ads');
            if (!file_exists($adsDir)) {
                mkdir($adsDir, 0755, true);
            }

            // Store new Arabic image
            $file = $request->file('img');
            $image = imagecreatefromstring($file->get());
            $filename = time() . '_ar_' . uniqid() . '.webp';
            $path = $adsDir . '/' . $filename;
            imagewebp($image, $path, 85);
            imagedestroy($image);

            $updateData['path'] = 'ads/' . $filename;
        }

        // Handle English image update if provided
        if ($request->hasFile('img_en')) {
            // Delete old English image
            if ($ad->path_en && file_exists(public_path($ad->path_en))) {
                unlink(public_path($ad->path_en));
            }

            // Create ads directory if it doesn't exist
            $adsDir = public_path('ads');
            if (!file_exists($adsDir)) {
                mkdir($adsDir, 0755, true);
            }

            // Store new English image
            $file_en = $request->file('img_en');
            $image_en = imagecreatefromstring($file_en->get());
            $filename_en = time() . '_en_' . uniqid() . '.webp';
            $path_en = $adsDir . '/' . $filename_en;
            imagewebp($image_en, $path_en, 85);
            imagedestroy($image_en);

            $updateData['path_en'] = 'ads/' . $filename_en;
        }

        $ad->update($updateData);

        return redirect()->route('ad.index')->with('success', 'تم تحديث الإعلان بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ad $ad)
    {
        // Delete Arabic Image
        if ($ad->path && file_exists(public_path($ad->path))) {
            unlink(public_path($ad->path));
        }
        
        // Delete English Image
        if ($ad->path_en && file_exists(public_path($ad->path_en))) {
            unlink(public_path($ad->path_en));
        }
        
        $ad->delete();
        
        return redirect()->route('ad.index')->with('success', 'تم حذف الإعلان بنجاح');
    }
}
