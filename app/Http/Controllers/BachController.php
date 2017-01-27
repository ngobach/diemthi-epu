<?php

namespace App\Http\Controllers;

use DB;
use Artisan;
use Illuminate\Http\Request;

class BachController extends Controller
{
	function __contructor() {
		$this->middleware('auth');
	}

	function index(Request $req) {
		$students = DB::table('students')->orderBy('id')->get()->toArray();
		// dd($students);
		return view('index', [ 'students' => $students]);
	}

	function student(Request $req, $student) {
		$student = DB::table('students')->where('id', $student)->first();
		if ($student === null) abort(404);
		$marks = DB::table('marks')
			->where('student_id', $student->id)
			->join('subjects', 'marks.subject_id', '=', 'subjects.id')
			->get();
		return view('student', [ 'marks' => $marks, 'student' => $student ]);
	}

	function fetch(Request $req) {
		Artisan::call('bach:marks');
		return ['status' => 'OK'];
	}
}
