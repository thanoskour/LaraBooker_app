<!-- resources/views/appointments/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Appointments</h1>

    <a href="{{ route('appointments.create') }}" class="btn btn-primary">Create New Appointment</a>
    <br><br>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Appointment ID</th>
                <th scope="col">User Email</th> 
                <th scope="col">Date</th>
                <th scope="col">Options</th>
                <th scope="col">Document</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach($appointments as $appointment)
            <tr>
                <td>{{ $appointment->user_id }}</td>
                <td>{{ $appointment->user_email }}</td>
                <td>{{ $appointment->date }}</td>
                <td>
                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
                <td>
                @if($appointment->document_path)
                    <a href="{{ Storage::url($appointment->document_path) }}" target="_blank">View Document</a>
                @else
                    No Document
                @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
