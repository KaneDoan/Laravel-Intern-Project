@extends('layouts.app')

@section('title')

@section('content')
<div class="mk-be-gym-show container-fluid">
	<gym-show :initial_gym="{{ json_encode($gym) }}"></gym-show>
</div>

@endsection

