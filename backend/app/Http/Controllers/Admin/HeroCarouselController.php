<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\HeroCarousels;


class HeroCarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'success' => true,
            'data'=> HeroCarousels::orderBy('order')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:2048',
            'title' => 'string|min:3',
            'order' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $path = $request->file('image')->store('hero', 'public');

        $hero = HeroCarousels::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $path,
            'button_text' => $request->button_text,
            'button_link' => $request->button_link,
            'order' => $request->order ?? 0,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hero created',
            'data' => $hero
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return response()->json([
            'success' => true,
            'data' => HeroCarousels::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $hero = HeroCarousels::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($hero->image) {
                Storage::disk('public')->delete($hero->image);
            }
            $hero->image = $request->file('image')->store('hero', 'public');
        }

        $hero->update($request->except('image'));

        return response()->json([
            'success' => true,
            'message' => 'Hero updated',
            'data' => $hero
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $hero = HeroCarousels::findOrFail($id);

        if ($hero->image) {
            Storage::disk('public')->delete($hero->image);
        }

        $hero->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hero deleted'
        ]);
    }

    public function toggle($id)
    {
        $hero = HeroCarousels::findOrFail($id);

        $hero->is_active = !$hero->is_active;
        $hero->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'data' => $hero
        ]);
    }
}
