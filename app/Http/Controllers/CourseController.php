<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $courses = Course::all();
        return response()->json(['items' => $courses], 200);
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

            $course = Course::create($validated);
            return response()->json([
                'message' => 'Course created successfully',
                'item' => $course,
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
            $course = Course::findOrFail($id);

            return response()->json([
                'item' => $course,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Course not found'
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

            $course = Course::findOrFail($id);
            $course->update($validated);

            return response()->json([
                'message' => 'Course updated successfully.',
                'item' => $course,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], status: 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Course not found'
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
            $course = Course::findOrFail($id);
            $course->delete();

            return response()->json([
                'message' => 'Course deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }

    }
}
