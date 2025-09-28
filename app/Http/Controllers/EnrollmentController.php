<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $enrollments = Enrollment::all();
        return response()->json(['items' => $enrollments], 200);
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
        try {
            $validated = $request->validate([
                'name' => ['required', 'unique'],
                'description' => 'required',

            ]);

            $enrollment = Enrollment::create($validated);
            return response()->json([
                'message' => 'Enrollment created successfully',
                'items' => $enrollment,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], status: 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            //code...
            $enrollment = Enrollment::findOrFail($id);

            return response()->json([
                'item' => $enrollment,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Enrollment not found'
            ], 404);
        }

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
        try {
            $validated = $request->validate([
                'name' => ['required', 'unique'],
                'description' => 'required',
            ]);

            $enrollment = Enrollment::findOrFail($id);
            $enrollment->update($validated);

            return response()->json([
                'message' => 'Enrollment updated successfully.',
                'item' => $enrollment,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], status: 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Enrollment not found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            //code...
            $enrollment = Enrollment::findOrFail($id);
            $enrollment->delete();

            return response()->json([
                'message' => 'Enrollment deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Enrollment not found'
            ], 404);
        }

    }
}
