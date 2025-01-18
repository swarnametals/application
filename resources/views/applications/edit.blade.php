@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Application Status</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('applications.update', $application->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="status">Application Status</label>
            <select name="status" id="status" class="form-control">
                @foreach($statuses as $status)
                    <option value="{{ $status }}" {{ $application->status === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Update Status</button>
        </div>
    </form>
</div>
@endsection
