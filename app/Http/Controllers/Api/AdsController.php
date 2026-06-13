<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    
    public function index()
    {
        $ads = Ads::latest()->get();
        return response()->json($ads);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'ad_page' => 'required|in:home,predictions,match_details',
            'is_active' => 'boolean',
            'ad_duration' => 'numeric|min:0',
        ]);

        $ad = Ads::create($validatedData);

        return response()->json($ad, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ads $ads)
    {
        return response()->json($ads);
    }

    public function update(Request $request, Ads $ads)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
            'ad_page' => 'sometimes|required|in:home,predictions,match_details',
            'is_active' => 'boolean',
            'ad_duration' => 'numeric|min:0',
        ]);

        $ads->update($validatedData);

        return response()->json($ads);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ads $ads)
    {
        $ads->delete();
        return response()->json(null, 204);
    }
}
