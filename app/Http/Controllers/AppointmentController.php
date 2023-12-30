<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date|after:now|unique:appointments,date',
        ]);

        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->date = $request->date;
        $appointment->save();

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment created successfully.');
    }

    // Show the form for editing the specified appointment
    public function edit(Appointment $appointment)
    {
        return view('appointments.edit', compact('appointment'));
    }

    // Update the specified appointment
    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'date' => 'required|date|after:now|unique:appointments,date,' . $appointment->id,
        ]);

        $appointment->date = $request->date;
        $appointment->save();

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment updated successfully.');
    }

    // Remove the specified appointment
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
                         ->with('success', 'Appointment deleted successfully.');
    }
}

