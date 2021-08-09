<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacheraController extends Controller
{
    public  function addTeacher()
    {
        return view('teacher.index');
    }
    public function allTeacher()
    {
        $data = Teacher::orderBy('id','DESC')->get();
        return response()->json($data);
    }
    public function storeTeacher(Request $request)
    {
        $validateData = $request->validate([
            'teacher_name'=>'required',
            'designtation'=>'required',
            'institution'=>'required'
        ]);

        $data = Teacher::insert([
            'teacher_name'=>$request->teacher_name,
            'designtation'=>$request->designtation,
            'institution'=>$request->institution
        ]);
        return response()->json($data);
    }
    public function editTeacher($id)
    {
             $data = Teacher::findOrFail($id);
             return response()->json($data);
    }
    public function updateTeacher(Request $request,$id)
    {
        $validateData = $request->validate([
            'teacher_name'=>'required',
            'designtation'=>'required',
            'institution'=>'required'
        ]);

        $data = Teacher::findOrFail($id)->update([
            'teacher_name'=>$request->teacher_name,
            'designtation'=>$request->designtation,
            'institution'=>$request->institution
        ]);
        return response()->json($data);
    }
    public function deleteTeacher($id)
    {
       $data = Teacher::find($id)->delete();
        return response()->json($data);
    }

}
