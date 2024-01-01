<!-- resources/views/appointments/edit.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Appointment</h1>


    @if ($errors->has('time_slot_taken'))
        <div class="alert alert-danger">
            {{ $errors->first('time_slot_taken') }}
        </div>
    @endif

    <form method="POST" action="{{ route('appointments.update', $appointment->id) }}">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="date">Appointment Date and Time:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" 
       value="{{ \Carbon\Carbon::parse($appointment->date)->format('Y-m-d\TH:i') }}" required>
            <label for="user_email">User Email:</label>
            <input type="email" class="form-control" id="user_email" name="user_email" 
            value="{{ old('user_email', $appointment->user_email ?? Auth::user()->email) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Appointment</button>
    </form>
</div>
@endsection
