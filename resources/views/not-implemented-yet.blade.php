@extends('layouts.app')

@section('title', 'Not Yet Implemented')

@section('content')
<a href="{{ route('dashboards.admin') }}" class="btn btn-secondary m-3">
    Back
</a>
<div class="text-center mt-5">
    <div class="alert alert-info" role="alert">
        <i class="fas fa-tools fa-2x"></i>
        <h4 class="mt-3">This feature is still under development</h4>
        <p class="mb-0">We're working hard to bring this functionality to you soon. Stay tuned!</p>
    </div>
</div>
@endsection
