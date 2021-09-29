@extends('layouts.app')

@section('title')

@section('content')
<div class="mk-be-routine-show container-fluid">
	<routine-show :initial_routine="{{ json_encode($routine) }}"></routine-show>
</div>
@endsection
