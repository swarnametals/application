@extends('layouts.app')

@section('title', 'Track Application')

@section('content')
<div class="container mt-5">
    <h2>Track Your Application</h2>

    <form action="{{ route('applications.track-post') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nrc_number">NRC Number:</label>
            <input type="text" id="nrc_number" name="nrc_number" class="form-control" required>
            @error('nrc_number')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-5">Track Application</button>
    </form>
</div>
@endsection
