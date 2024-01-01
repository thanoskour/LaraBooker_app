<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>

    @if ($errors->has('time_slot_taken'))
        <div class="alert alert-danger">
            {{ $errors->first('time_slot_taken') }}
        </div>
    @endif
    


    <form method="POST" action="{{ route('appointments.store') }}">
        @csrf
        <div class="form-group">
            <label for="date">Appointment Date and Time:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
            <label for="user_email">User Email:</label>
            <input type="email" class="form-control" id="user_email" name="user_email" 
            value="{{ old('user_email', $appointment->user_email ?? Auth::user()->email) }}">
        </div>
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection
