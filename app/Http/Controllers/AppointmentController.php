<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Get the currently logged-in user's ID
        $appointments = Appointment::where('user_id', $userId)->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'date' => 'required|date|after:now|unique:appointments,date',
            'document' => 'nullable|file|max:2048',
        ]);

        $appointmentDate = Carbon::parse($request->date);
        $appointmentEnd = $appointmentDate->copy()->addHour();

        // Check for overlap
        $overlap = Appointment::where(function ($query) use ($appointmentDate, $appointmentEnd) {
            $query->whereBetween('date', [$appointmentDate, $appointmentEnd])
                ->orWhereBetween(DB::raw('DATE_ADD(date, INTERVAL 1 HOUR)'), [$appointmentDate, $appointmentEnd]);
        })->exists();

        if ($overlap) {
            return back()->withErrors(['time_slot_taken' => 'The selected time slot is already taken. Please choose a different time.'])->withInput();

        }

        $appointment = new Appointment();
        $appointment->user_id = Auth::id();
        $appointment->user_email = $request->user_email;
        $appointment->date = $request->date;

        if ($request->hasFile('document') && $request->file('document')->isValid()) {
            $filePath = $request->file('document')->store('documents', 'public');
            $appointment->document_path = $filePath;
        }

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
            'user_email' => 'sometimes|email|nullable',
            'date' => 'required|date|after:now|unique:appointments,date,' . $appointment->id,
        ]);

        $appointmentDate = Carbon::parse($request->date);
        $appointmentEnd = $appointmentDate->copy()->addHour();

        // Check for overlap, excluding the current appointment
        $overlap = Appointment::where('id', '!=', $appointment->id)
            ->where(function ($query) use ($appointmentDate, $appointmentEnd) {
                $query->whereBetween('date', [$appointmentDate, $appointmentEnd])
                    ->orWhereBetween(DB::raw('DATE_ADD(date, INTERVAL 1 HOUR)'), [$appointmentDate, $appointmentEnd]);
            })->exists();

        if ($overlap) {
            return back()->withErrors(['time_slot_taken' => 'The selected time slot is already taken. Please choose a different time.'])->withInput();

        }

        $appointment->user_email = $request->user_email;
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

    public function getAppointments()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
        $appointments = Appointment::whereBetween('date', [$startOfWeek,$endOfWeek])->get();
        return response()->json($appointments->map(function ($appointment) {
            return [
                'title' => 'Occupied', 
                'start' => $appointment->date,
            ];
        }));
    }
}

