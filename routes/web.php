<?php

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Show the list of students
Route::get('/students', function () {
    $students = Student::all();

    return view('student.list', [
        'students' => $students,
    ]);
})->name('students.index');

// 2. Show the empty Create form
Route::get('/students/create', function () {
    return view('student.create');
})->name('students.create');

// 3. Receive the form, validate it, save it
Route::post('/students', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:students,email',
        'phone' => 'required|string|max:20',
        'address' => 'nullable|string|max:500',
        'date_of_birth' => 'nullable|date',
    ]);

    $student = Student::create($validated);

    return redirect()->route('students.index')
        ->with('success', "Student {$student->name} created successfully!");
})->name('students.store');