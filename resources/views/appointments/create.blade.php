<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>
    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf
        <div class="form-group">
            <label for="date">Appointment Date and Time:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection
