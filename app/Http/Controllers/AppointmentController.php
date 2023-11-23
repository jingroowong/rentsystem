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

    public function agentIndex()
    {
        $agentID = "AGT1234567";
        // Retrieve appointments for the agent along with related property information
        $appointments = Appointment::whereHas('property', function ($query) use ($agentID) {
            $query->where('agentID', $agentID);
        })->get();
        return view('agent/appointmentIndex', compact('appointments'));
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
    public function show($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            abort(404, 'Appointment not found');
        }
            
        // Pass the appointment data to the view
        return view('agent/appointmentDelete', compact( 'appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
          // Find the appointment by ID
          $appointment = Appointment::find($id);

          // Check if the appointment exists
          if (!$appointment) {
              abort(404, 'Appointment not found');
          }
  
                  // Retrieve the available timeslots
                  $availableTimeslots = Timeslot::where('agentID', $appointment->property->agentID)
                  ->orderBy('date', 'asc')
                  ->orderBy('startTime', 'asc')
                  ->get();
              // Extract distinct dates from timeslots
              $availableDates = $availableTimeslots->pluck('date')->unique()->values()->all();
  
              
          // Pass the appointment data to the view
          return view('agent/appointmentUpdate', compact('appointment','availableTimeslots', 'availableDates'));
   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
         // Find the appointment by ID
         $appointment = Appointment::find($request->appID);

         // Check if the appointment exists
         if (!$appointment) {
             abort(404, 'Appointment not found');
         }

        // Update appointment fields with the new values
        $appointment->timeslotID = $request->timeslotID;

        // Save the updated appointment
        $appointment->save();

        // Redirect back with a success message
        return redirect()->route('appointments')->with('success', 'Appointment updated successfully');
    }

    public function updateByAgent(Request $request)
    {
         // Find the appointment by ID
         $appointment = Appointment::find($request->appID);

         // Check if the appointment exists
         if (!$appointment) {
             abort(404, 'Appointment not found');
         }

        // Update appointment fields with the new values
        $appointment->timeslotID = $request->timeslotID;

        // Save the updated appointment
        $appointment->save();

        // Redirect back with a success message
        return redirect()->route('appointments.agentIndex')->with('success', 'Appointment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancel(string $id)
    {
          // Find the appointment by ID
          $appointment = Appointment::find($id);

          // Check if the appointment exists
          if (!$appointment) {
              abort(404, 'Appointment not found');
          }
 
         // Update appointment fields with the new values
         $appointment->status = "Cancelled";
 
         // Save the updated appointment
         $appointment->save();
 
         // Redirect back with a success message
         return redirect()->route('appointments')->with('success', 'Appointment cancel successfully');
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