@extends('layouts.layout')

@section('title', 'Home')

@section('content')
    <!-- Home -->
    <div class='content'>
        <h2>Home</h2>
        <p>Hello {{ Auth::user()->full_name }}</p>
        <p>Welcome to Health Care Management </p>
    </div>
@endsection