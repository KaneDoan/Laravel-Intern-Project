@extends('layouts.app')

<<<<<<< HEAD
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
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Hello {{Auth::user()->full_name}}
>>>>>>> master
                </div>

            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
@endsection
=======
Hellosdsdsdasda
>>>>>>> master
