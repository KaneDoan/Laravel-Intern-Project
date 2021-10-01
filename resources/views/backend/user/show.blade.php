@extends('layouts.app')

@section('title')

@section('content')
<div class="mk-be-user-show container-fluid">
	<user-show :initial_user="{{ json_encode($user) }}"></user-show>
</div>
@endsection

