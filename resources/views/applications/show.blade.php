@extends('layouts.app')

@section('title', 'Applicant Details')

@section('content')
<div class="container mt-5">
    <h2>Applicant Details</h2>

    <!-- Applicant Information -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $application->first_name }} {{ $application->last_name }}</h5>
            <p><strong>Email:</strong> {{ $application->email }}</p>
            <p><strong>Phone:</strong> {{ $application->phone }}</p>
            <p><strong>Position Applied For:</strong> {{ $application->position_applied_for }}</p>
            <p><strong>Years of Experience:</strong> {{ $application->years_of_experience }}</p>

            <!-- Resume -->
            <p><strong>Resume:</strong>
                @if ($application->resume_path)
                    <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank">View Resume</a>
                @else
                    Not provided
                @endif
            </p>

            <!-- Cover Letter -->
            <p><strong>Cover Letter:</strong>
                @if ($application->cover_letter_path)
                    <a href="{{ asset('storage/' . $application->cover_letter_path) }}" target="_blank">View Cover Letter</a>
                @else
                    Not provided
                @endif
            </p>

            <!-- Certificates -->
            <p><strong>Certificates:</strong></p>
            @forelse ($application->certificates as $certificate)
                <p>
                    <a href="{{ asset('storage/' . $certificate->file_path) }}" target="_blank">View Certificate</a>
                </p>
            @empty
                <p>No certificates uploaded.</p>
            @endforelse
        </div>
    </div>

    <a href="{{ route('applications.index') }}" class="btn btn-primary mt-4">Back to Applications</a>
</div>
@endsection
