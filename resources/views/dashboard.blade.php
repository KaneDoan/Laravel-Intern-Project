@extends('layouts.app')

@section('content')

<div class="container-fluid px-5">
    <div class="row">
        <div class="col-md-2">
           @include('backend.includes.sidebar')
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome to the Dashboard, ') }} {{  Auth::user()->full_name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

