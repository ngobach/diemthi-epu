@extends('layouts.bach')
@section('title', 'Điểm thi')
@section('content')
<div class="container">
	<div class="text-center">
		<h1>An awesome project</h1>
	</div>
	<div class="row">
		<div class="col-sm-6">
			<h3>DS sinh viên</h3>
			<div class="list-group">
				@foreach($students as $student)
				<a class="list-group-item" href="{{route('sinhvien', ['id' => $student->id])}}">
					{{$student->name}}
					<small class="text-muted">({{$student->id}})</small>
				</a>
				@endforeach
			</div>
		</div>
		<div class="col-sm-6">
			<h3>DS môn học</h3>
			<div class="list-group">
				@foreach($subjects as $subject)
				<a class="list-group-item" href="{{route('monhoc', ['id' => $subject->id])}}">
					{{$subject->name}}
				</a>
				@endforeach
			</div>
		</div>

	</div>
</div>
@endsection