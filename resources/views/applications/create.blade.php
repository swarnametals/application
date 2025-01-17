@extends('layouts.app')

@section('title', 'Submit Application')

@section('content')
<div class="container mt-5">

    <h2>Submit Application</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="justify-content-center col-md-6 ">
        <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" class="mb-10">
            @csrf

            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="nrc_number" class="form-label">NRC Number</label>
                <input type="text" class="form-control" id="nrc_number" name="nrc_number" value="{{ old('nrc_number') }}" required>
                @error('nrc_number') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="position_applied_for" class="form-label">Position Applied For</label>
                <select class="form-control" id="position_applied_for" name="position_applied_for" required>
                    <option value="">Select Position</option>
                    <option value="Crushing Section In-charge" {{ old('position_applied_for') == 'Crushing Section In-charge' ? 'selected' : '' }}>Crushing Section In-charge</option>
                    <option value="Milling and Concentrator Section In-charge" {{ old('position_applied_for') == 'Milling and Concentrator Section In-charge' ? 'selected' : '' }}>Milling and Concentrator Section In-charge</option>
                    <option value="Leaching and PLS Dam Section In-charge" {{ old('position_applied_for') == 'Leaching and PLS Dam Section In-charge' ? 'selected' : '' }}>Leaching and PLS Dam Section In-charge</option>
                    <option value="Solvent Extraction Section In-charge" {{ old('position_applied_for') == 'Solvent Extraction Section In-charge' ? 'selected' : '' }}>Solvent Extraction Section In-charge</option>
                    <option value="Electrowinning Section In-charge" {{ old('position_applied_for') == 'Electrowinning Section In-charge' ? 'selected' : '' }}>Electrowinning Section In-charge</option>
                    <option value="Electrical Maintenance In-charge" {{ old('position_applied_for') == 'Electrical Maintenance In-charge' ? 'selected' : '' }}>Electrical Maintenance In-charge</option>
                    <option value="Mechanical Maintenance In-charge" {{ old('position_applied_for') == 'Mechanical Maintenance In-charge' ? 'selected' : '' }}>Mechanical Maintenance In-charge</option>
                    <option value="Laboratory In-charge" {{ old('position_applied_for') == 'Laboratory In-charge' ? 'selected' : '' }}>Laboratory In-charge</option>
                    <option value="Garage In-charge" {{ old('position_applied_for') == 'Garage In-charge' ? 'selected' : '' }}>Garage In-charge</option>
                    <option value="HR Officer" {{ old('position_applied_for') == 'HR Officer' ? 'selected' : '' }}>HR Officer</option>
                    <option value="Safety Officer" {{ old('position_applied_for') == 'Safety Officer' ? 'selected' : '' }}>Safety Officer</option>
                    <option value="Stores Incharge" {{ old('position_applied_for') == 'Stores Incharge' ? 'selected' : '' }}>Stores Incharge</option>
                </select>
                @error('position_applied_for') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="years_of_experience" class="form-label">Years of Experience</label>
                <select class="form-control" id="years_of_experience" name="years_of_experience" required>
                    <option value="">Select Years of Experience</option>
                    <option value="1" {{ old('years_of_experience') == '1' ? 'selected' : '' }}>1 Year</option>
                    <option value="2" {{ old('years_of_experience') == '2' ? 'selected' : '' }}>2 Years</option>
                    <option value="3" {{ old('years_of_experience') == '3' ? 'selected' : '' }}>3 Years</option>
                    <option value="4" {{ old('years_of_experience') == '4' ? 'selected' : '' }}>4 Years</option>
                    <option value="5" {{ old('years_of_experience') == '5' ? 'selected' : '' }}>5 Years</option>
                    <option value="6" {{ old('years_of_experience') == '6' ? 'selected' : '' }}>6 Years</option>
                    <option value="7" {{ old('years_of_experience') == '7' ? 'selected' : '' }}>7 Years</option>
                    <option value="8" {{ old('years_of_experience') == '8' ? 'selected' : '' }}>8 Years</option>
                    <option value="9" {{ old('years_of_experience') == '9' ? 'selected' : '' }}>9 Years</option>
                    <option value="10" {{ old('years_of_experience') == '10' ? 'selected' : '' }}>10+ Years</option>
                </select>
                @error('years_of_experience') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="resume" class="form-label">Resume</label>
                <input type="file" class="form-control" id="resume" name="resume" required>
                <small class="form-text text-muted">
                    Allowed file types: PDF, DOC, DOCX. Maximum file size: 10MB.
                </small>
                @error('resume')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cover_letter" class="form-label">Cover Letter</label>
                <input type="file" class="form-control" id="cover_letter" name="cover_letter" required>
                <small class="form-text text-muted">
                    Allowed file types: PDF, DOC, DOCX. Maximum file size: 10MB.
                </small>
                @error('cover_letter')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="certificate_1" class="form-label">Upload Certified Copies of Academic and Professional Certificates</label>
                <input type="file" class="form-control" id="certificate_1" name="certificates[]">
                <small class="form-text text-muted">
                    Allowed file types: PDF, DOC, DOCX. Maximum file size: 10MB.
                </small>
                @error('certificates')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Application</button>
        </form>
    </div>
</div>
@endsection
