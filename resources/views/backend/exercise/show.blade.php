@extends('layouts.app')

@section('title')

@section('content')
<div class="mk-be-exercise-show container-fluid">
	<exercise-show :initial_exercise="{{ json_encode($exercise) }}"></exercise-show>
</div>
@endsection
