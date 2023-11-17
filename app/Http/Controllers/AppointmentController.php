<?php

namespace App\Http\Controllers;

use App\Models\Timeslot;
use App\Models\Property;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenantID = "TNT1231234";
        $appointments = Appointment::where('tenantID', $tenantID)->get();
        // $appointments = Appointment::all();
        return view('appointmentIndex', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($propertyID)
    {
        // Retrieve the property details based on $propertyID

        $property = Property::with(['propertyPhotos'])->findOrFail($propertyID);

        // Retrieve the available timeslots
        $availableTimeslots = Timeslot::where('agentID', $property->agentID)
            ->orderBy('date', 'asc')
            ->orderBy('startTime', 'asc')
            ->get();
        // Extract distinct dates from timeslots
        $availableDates = $availableTimeslots->pluck('date')->unique()->values()->all();


        return view('appointmentCreate', compact('property', 'availableTimeslots', 'availableDates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'timeslot' => 'required', // Ensure the selected timeslot exists
            'name' => 'required|string',
            'email' => 'required|email',
            'contact_number' => 'required|string',
            'num_of_viewers' => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

     
        // Create a new appointment
        $appointment = new Appointment();
        $appointment->appID = $this->generateUniqueAppointmentID();
        $appointment->timeslotID = $request->timeslotID;
        $appointment->tenantID = "TNT1231234";
        $appointment->status = "Pending";
        $appointment->propertyID = $request->propertyID;
        $appointment->name = $request->name;
        $appointment->email = $request->email;
        $appointment->contactNo = $request->contact_number;
        $appointment->headcount = $request->num_of_viewers;
        $appointment->message = $request->message;

        $appointment->save();

        // You may want to send a confirmation email, etc.

        return redirect()->route('appointments')
        ->with('success', 'Appointment ' . $appointment->appID . ' booked successfully!');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function generateUniqueAppointmentID()
    {
        $latestAppointment = Appointment::orderBy('appID', 'desc')->first();

        if ($latestAppointment) {
            $lastID = ltrim(substr($latestAppointment->appID, 3), '0'); // Remove the "WTR" prefix and leading zeros
            $nextID = 'APP' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            $nextID = 'APP0000001'; // Initial ID
        }

        return $nextID;
    }
}