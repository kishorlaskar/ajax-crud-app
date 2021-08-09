<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function index()
    {
        return view('search-student.search');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $students = DB::table('students')->where('student_id', 'LIKE', '%' . $request->search . "%")->get();
            if ($students) {
                foreach ($students as $key => $student) {
                    $output .= '<tr>' .
                        '<td>' . $student->student_id . '</td>' .
                        '<td>' . $student->name . '</td>' .
                        '<td>' . $student->email . '</td>' .
                        '<td>' . $student->phone . '</td>' .
                        '<td>' . $student->Section . '</td>' .
                        '<td>' . $student->Address . '</td>' .
                        '</tr>';
                }
                return Response($output);
            }

        }
    }
}
