<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Student;
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
                'course_id' => ['required'],
                'student_id' => ['required']
            ]);

            $exists = Enrollment::where([
                'student_id' => $validated['student_id'],
                'course_id' => $validated['course_id']
            ])->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Student is already enrolled in this course'
                ], 409);
            }
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
                'course_id' => ['required'],
                'student_id' => ['required']
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

    public function getStudentEnrollment(string $student_id)
    {
        try {
            $courseIds = Enrollment::where('student_id', $student_id)->pluck('course_id');
            if ($courseIds->isEmpty()) {
                return response()->json([
                    'message' => 'No enrollments found for this student'
                ], 404);
            }

            $courses = Course::whereIn('id', $courseIds)->get();

            return response()->json([
                'items' => $courses
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Enrollments not found for the student'
            ], 404);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }

    public function getStudentsInCourse(string $course_id)
    {
        try {
            $studentIds = Enrollment::where('course_id', $course_id)->pluck('student_id');
            if ($studentIds->isEmpty()) {
                return response()->json([
                    'message' => 'No students found for this course'
                ], 404);
            }

            $students = Student::whereIn('id', $studentIds)->get();

            return response()->json([
                'items' => $students
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Enrollments not found for the course'
            ], 404);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Course not found'
            ], 404);
        }
    }

    public function getAvailableCourses(string $student_id) {
        try {
            $enrolledCourseIds = Enrollment::where('student_id', $student_id)->pluck('course_id');
            $availableCourses = Course::whereNotIn('id', $enrolledCourseIds)->get();

            return response()->json([
                'items' => $availableCourses
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }
    }
}
