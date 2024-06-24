<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
class StudentController extends Controller
{
    public function index(){
        try {
            $student = Student::all();
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th
            ), 400);
        }
        return $student;
    }

    public function store(Request $request){
        try {
            $student = new Student();
            $student->fill($request->all());
            $student->save();
            return $student;
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th,
            ), 400);
        }
    }

    public function show($id){
     
        try {
            $student = DB::select('select * from students where id = ' . $id);
            // dd($student);
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th
            ), 400);
        }
        if (count($student) > 0) {
            return response()->json($student[0], 200);
        } else {
            return response()->json(array(
                'message' => 'Students Not Found!'
            ), 400);
        }
    }

    public function getStudentByID($id){
        try {
            $student = DB::select('select * from students where id = ' . $id);
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th
            ), 400);
        }
        if (count($student) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update(Request $request, $id){
        if (!$this->getStudentByID($id)) {
            return response()->json(array(
                'message' => 'Students of Id = ' . $id . ' is Not Found',
            ), 400);
        }
        try {
            $timestamp = time();
            DB::update('UPDATE students
            SET first_name=\'' . $request->first_name . '\', 
            last_name=\'' . $request->last_name . '\', 
            date_of_birth=\'' . $request->date_of_birth . '\', 
            class=\'' . $request->class . '\', 
            created_at= NOW(),
            updated_at= NOW()
            WHERE id = ' . $id);
            return $this->getStudentByID($id);
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th
            ), 400);
        }
    }

    public function destroy($id){
        if (!$this->getStudentByID($id)) {
            return response()->json(array(
                'message' => 'Students of Id = ' . $id . ' is Not Found',
            ), 400);
        }
        try {
            DB::delete('delete from students where id='.$id);
            return response()->json(array(
                'message' => 'Students of Id = ' . $id . ' is Deleted',
            ), 200);
        } catch (\Throwable $th) {
            return response()->json(array(
                'message' => 'Bad Request',
                'detail' => $th
            ), 400);
        }
    }

}
