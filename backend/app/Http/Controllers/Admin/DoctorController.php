<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json([
            'success' => true,
            'data' => Doctors::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:3',
            'specialist' => 'required|min:3',
            'photo'=>'nullable|image|max:2048',
            'description' => 'required|min:3'
        ]);

        if ($validator->fails()) {
            # code...
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        $doctor = Doctors::create([
            'name' => $request->name,
            'specialist' => $request->specialist,
            'photo'=> $photoPath,
            'description' => $request->description
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Doctor created',
            'data' => $doctor
        ]);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $doctor = Doctors::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $doctor
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
        $doctor = Doctors::findOrFail($id);

        if ($request->hasFile('photo')) {
            if ($doctor->photo) {
                Storage::disk('public')->delete($doctor->photo);
            }

            $doctor->photo = $request->file('photo')->store('doctors', 'public');
        }

        $doctor->update($request->except('photo'));

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated',
            'data' => $doctor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $doctor = Doctors::findOrFail($id);

        if ($doctor->photo) {
            Storage::disk('public')->delete($doctor->photo);
        }

        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted'
        ]);
    }
}
