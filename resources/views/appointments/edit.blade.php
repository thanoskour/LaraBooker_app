<!-- resources/views/appointments/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Appointment</h1>
    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="date">Appointment Date and Time:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" 
       value="{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d\TH:i') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Appointment</button>
    </form>
</div>
@endsection
