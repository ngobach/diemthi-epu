@extends('layouts.bach')
@section('title', $student->name)
@section('content')
<div class="container">
	<div class="text-center">
		<h1>Sinh viên {{$student->name}}</h1>
	</div>
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr>
				<th>Môn học</th>
				<th>Điểm lần 1</th>
				<th>Điểm lần 2</th>
			</tr>
			@foreach ($marks as $mark)
			<tr>
				<td>{{$mark->name}}</td>
				<td>{{$mark->mark1}}</td>
				<td>{{$mark->mark2}}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection