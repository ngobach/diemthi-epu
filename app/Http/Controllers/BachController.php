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
		$subjects = DB::table('subjects')->orderBy('id')->get()->toArray();
		return view('index', [ 'students' => $students, 'subjects' => $subjects]);
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

	function subject(Request $req, $subject) {
		$subject = DB::table('subjects')->where('id', $subject)->first();
		if ($subject === null) abort(404);
		$marks = DB::table('marks')
			->where('subject_id', $subject->id)
			->join('students', 'marks.student_id', '=', 'students.id')
			->get();
		return view('subject', [ 'marks' => $marks, 'subject' => $subject ]);
	}

	function fetch(Request $req) {
		Artisan::call('bach:marks');
		return ['status' => 'OK'];
	}
}
