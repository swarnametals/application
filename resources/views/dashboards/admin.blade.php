@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container mt-5">

    <h2>Swarna Metals Admin Dashboard</h2>
    <a href="{{ route('applications.index') }}" class="btn btn-primary px-4 py-2">Applications</a>
    <br>
    <a href="{{ route('employees.index') }}" class="btn btn-info px-4 py-2 mt-2">Employees</a>


</div>
@endsection
