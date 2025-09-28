<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\StudentController;


Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);
Route::apiResource('enrollment', EnrollmentController::class);


// get student's enrollments
Route::get('/enrollment/student/{student_id}', [EnrollmentController::class,'getStudentEnrollment']);
// get course's students
Route::get('/enrollment/course/{course_id}', [EnrollmentController::class,'getStudentsInCourse']);
// get available courses for a student
Route::get('/enrollment/available/{student_id}', [EnrollmentController::class,'getAvailableCourses']);