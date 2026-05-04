<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\DoctorSchedules;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($doctor_id)
    {
        //
        $data = DoctorSchedules::where('doctor_id', $doctor_id)->get();

        return response()->json([
            'success' => true,
            'data' => $data
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
         $validator = Validator::make($request->all(), [
            'doctor_id' => 'required',
            'day' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $schedule = DoctorSchedules::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Schedule created',
            'data' => $schedule
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
        $schedule = DoctorSchedules::findOrFail($id);

        $schedule->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated',
            'data' => $schedule
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
         DoctorSchedules::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted'
        ]);
    }
}
