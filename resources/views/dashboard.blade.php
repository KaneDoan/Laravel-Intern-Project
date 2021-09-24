@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-4">
            @include('backend.includes.sidebar')
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Welcome {{Auth::user()->full_name}}</h1>
                </div>

                <div class="card-body">
                    <h2>Welcome to the Dashboard</h2>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
