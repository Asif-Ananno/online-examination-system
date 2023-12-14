@extends('layout/layout-common')

@section('space-work')

<div class="container">
    <div class="text-center">
        <h2>Thanks for submitting your Exam , {{Auth::user()->name }}</h2>
        <p>We Will review your Exam and update you soon</p>
        <a href="/dashboard" class="btn btn-info">Go back</a>
    </div>
</div>

@endsection