<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    //

    public function new_record(Request $request)
    {

        $student = Student::where('student_id', $request->student_id)->exists();

        if ($student) {
            return response()->json([
                'message' => "User has existing saved data"
            ]);
        } else {
            // $new = new Student();

            // $new->$request->all();

            $input = $request->all();
            $students = Student::create($input);

            return response()->json([
                'message' => "User Successfully added",
                'data' => $students
            ]);
        }
    }
}
