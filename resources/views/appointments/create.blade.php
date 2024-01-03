<!-- resources/views/appointments/create.blade.php -->
@extends('layouts.app') <!-- inherits from layouts the app.blade.php -->

@section('content')




<div class="container">
    <h1>Create Appointment</h1>

    @if ($errors->has('time_slot_taken')) <!-- if the time slot is taken it puts an error that this time slot is taken -->
        <div class="alert alert-danger">
            {{ $errors->first('time_slot_taken') }}
        </div>
    @endif
    


    <form method="POST" action="{{ route('appointments.store') }}"  enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            
            <label for="date">Appointment Date and Time:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
            
            <label for="user_email">User Email:</label>
            <input type="email" class="form-control" id="user_email" name="user_email" 
            value="{{ old('user_email', $appointment->user_email ?? Auth::user()->email) }}">

            
            <label for="document">Upload Document:</label>
            <input type="file" class="form-control" id="document" name="document">
            


        </div>
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>

    <!-- Calendar Container -->
    
    <div id='calendar'></div>

</div>

    

    
    <!-- FullCalendar JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.min.js" integrity="sha512-xCMh+IX6X2jqIgak2DBvsP6DNPne/t52lMbAUJSjr3+trFn14zlaryZlBcXbHKw8SbrpS0n3zlqSVmZPITRDSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.js" integrity="sha512-bBl4oHIOeYj6jgOLtaYQO99mCTSIb1HD0ImeXHZKqxDNC7UPWTywN2OQRp+uGi0kLurzgaA3fm4PX6e2Lnz9jQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.js" integrity="sha512-zAadCzZHXo/f5A/3uhF50bZXahdYNqisNgKKniyoJJVpp27b2bR82N4hPLGj3/qBEh3tGZ9SYGmSA1jpdtNF5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.10/index.global.min.js" integrity="sha512-JCQkxdym6GmQ+AFVioDUq8dWaWN6tbKRhRyHvYZPupQ6DxpXzkW106FXS1ORgo/m3gxtt5lHRMqSdm2OfPajtg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js" integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js" integrity="sha512-4F1cxYdMiAW98oomSLaygEwmCnIP38pb4Kx70yQYqRwLVCs3DbRumfBq82T08g/4LJ/smbFGFpmeFlQgoDccgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>




<!-- Initialize FullCalendar -->

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek', // Display the week view
      events: '/api/appointments', // Endpoint to fetch appointments
    });
    calendar.render();
  });
</script>


@endsection
