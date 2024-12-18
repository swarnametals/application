@extends('layouts.app')

@section('title', 'Track Application Status')

@section('content')
<div class="container mt-5">

    <h2>Your Application Status</h2>

    <div class="application-status">
        <p><strong>Hey {{ $application->first_name }} {{ $application->last_name }}</strong> </p>
        <p>Your Application Status is <strong> {{ $application->status}}</strong></p>
        <p><strong>Position Applied For:</strong> {{ $application->position_applied_for }}</p>
        <a href="{{ route('applications.track') }}" class="btn btn-primary">Search Another Application</a>
    </div>
</div>
@endsection
