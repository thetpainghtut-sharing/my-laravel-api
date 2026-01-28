<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Resources\AssetResource;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with('category')->get();
        return AssetResource::collection($assets);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:100|min:3",
            "photo" => "image|mimes:jpeg,png,jpg,gif|max:2048",
            "category" => "required|exists:categories,id"
        ]);

        if ($request->hasFile('photo')) {
            // 'store' method saves the file to storage/app/public/assets
            // It returns the path (e.g., "assets/xyz123.jpg")
            $path = $request->file('photo')->store('assets', 'public');
        }

        $asset = new Asset;
        $asset->serial_no = uniqid(); // companyname_categoryname_00001 format -> please try
        $asset->name = $request->name;
        $asset->image = $path;
        $asset->category_id = $request->category;
        $asset->save();

        return new AssetResource($asset);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
