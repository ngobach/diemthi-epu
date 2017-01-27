@extends('layouts.bach')
@section('title', 'Điểm thi')
@section('content')
<div class="container">
	<div class="text-center">
		<h1>An awesome project</h1>
	</div>

	<div class="list-group">
		@foreach($students as $student)
		<a class="list-group-item" href="{{url($student->id)}}">
			{{$student->name}}
			<small class="text-muted">({{$student->id}})</small>
		</a>
		@endforeach
	</div>
</div>
@endsection