<?php
namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Property;
use App\Models\PropertyFacility;
use App\Models\PropertyPhoto;
use App\Models\PropertyRental;
use App\Models\State;
use App\Models\Tenant;
use App\Models\Wallet;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the properties.
     */
    public function index()
    {
        $properties = Property::all();
        $propertyRentals = PropertyRental::all();
        return view('agent/propertyIndex', compact('properties', 'propertyRentals'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $states = State::all();
        $facilities = Facility::all();
        $walletBalance = Wallet::where('agentID', "AGT1234567")->value('balance');
     return view('agent/propertyCreate', compact('states','facilities','walletBalance'));
    }

    /**
     * Store a newly created property in the database.
     */
    public function store(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'propertyName' => 'required|string|max:40',
            'propertyDesc' => 'required|string|max:150',
            'propertyType' => 'required|string|max:20',
            'propertyAddress' => 'required|string|max:100',
            'bedroomNum' => 'required|integer',
            'bathroomNum' => 'required|integer',
            'furnishingType' => 'required|string|max:50',
            'rentalAmount' => 'required|numeric',
            'depositAmount' => 'nullable|numeric',
            'stateID' => 'required|exists:states,stateID',
            'facilities' => 'array',
            // Assuming facilities is an array of selected facility IDs
            'facilities.*' => 'exists:facilities,facilityID',
            // Validate each facility
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            // Assuming you're uploading images
        ]);

        // Create a new property instance
        $property = new Property();
        $property->propertyID = $this->generateUniquePropertyID();
        $property->propertyName = $request->input('propertyName');
        $property->propertyDesc = $request->input('propertyDesc');
        $property->propertyType = $request->input('propertyType');
        $property->propertyAddress = $request->input('propertyAddress');
        $property->propertyAvailability = $request->input('propertyAvailability');
        $property->bedroomNum = $request->input('bedroomNum');
        $property->bathroomNum = $request->input('bathroomNum');
        $property->buildYear = $request->input('buildYear');
        $property->squareFeet = $request->input('squareFeet');
        $property->furnishingType = $request->input('furnishingType');
        $property->rentalAmount = $request->input('rentalAmount');
        $property->depositAmount = $request->input('depositAmount');
        $property->stateID = $request->input('stateID');
        $property->agentID = 'AGT1234567';
        // Handle other property attributes

        // Save the property to the database
        $property->save();

        // Get the ID of the newly created property
        $propertyID = $property->propertyID;

        // Handle facilities
        if ($request->has('facilities')) {
            $selectedFacilities = $request->input('facilities');
            foreach ($selectedFacilities as $facilityID) {
                $propertyFacility = new PropertyFacility();
                $propertyFacility->propertyID = $propertyID;
                $propertyFacility->facilityID = $facilityID;
                $propertyFacility->save();
            }
        }

        // Handle property photos (assuming you have a photos input field)
        // Upload property photos
        if ($request->hasFile('propertyPhotos')) {
            foreach ($request->file('propertyPhotos') as $photo) {
                $path = $photo->store('property-photos', 'public');
                $propertyPhoto = new PropertyPhoto();
                $propertyPhoto->propertyID = $property->propertyID;
                $propertyPhoto->propertyPath = $path;
                $propertyPhoto->dateUpload = now();
                $propertyPhoto->save();
            }


        }
        return redirect()->route('properties')->with('success', 'Property Added Successfully');
   
    }

    /**
     * Display the specified property.
     */
    public function show($propertyID)
    {

        // Assuming you have relationships set up in your Property model
        $property = Property::with(['propertyPhotos', 'propertyFacilities'])->find($propertyID);

        if (!$property) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property not found');
        }

        // Assuming you have an agent relationship in your Property model
        $agent = $property->agent;

        return view('propertyDetail', compact('property', 'agent'));
    }

    public function showAgent($propertyID)
    {

        // Assuming you have relationships set up in your Property model
        $property = Property::with(['propertyPhotos', 'propertyFacilities'])->find($propertyID);

        if (!$property) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property not found');
        }

        // Assuming you have an agent relationship in your Property model
        $agent = $property->agent;

        return view('agent/propertyDetail', compact('property', 'agent'));
    }

    public function edit($propertyID)
    {
        $states = State::all();
        $facilities = Facility::all();
        // Assuming you have relationships set up in your Property model
        $property = Property::with(['propertyPhotos', 'propertyFacilities'])->find($propertyID);

        if (!$property) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property not found');
        }

        // Assuming you have an agent relationship in your Property model
        $agent = $property->agent;

        return view('agent/propertyUpdate', compact('property', 'agent', 'states', 'facilities'));
    }

    public function update(Request $request, $propertyID)
{
    // Validate the form inputs
    $request->validate([
        'propertyName' => 'required|string|max:40',
        'propertyDesc' => 'required|string|max:150',
        'propertyType' => 'required|string|max:20',
        'propertyAddress' => 'required|string|max:100',
        'bedroomNum' => 'required|integer',
        'bathroomNum' => 'required|integer',
        'furnishingType' => 'required|string|max:50',
        'rentalAmount' => 'required|numeric',
        'depositAmount' => 'nullable|numeric',
        'stateID' => 'required|exists:states,stateID',
        'facilities' => 'array',
        // Assuming facilities is an array of selected facility IDs
        'facilities.*' => 'exists:facilities,facilityID',
        // Validate each facility
        'propertyPhotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        // Assuming you're uploading images
    ]);

    // Find the property by ID
    $property = Property::findOrFail($propertyID);

    // Update property details
    $property->update([
        'propertyName' => $request->input('propertyName'),
        'propertyDesc' => $request->input('propertyDesc'),
        'propertyType' => $request->input('propertyType'),
        'propertyAddress' => $request->input('propertyAddress'),
        'bedroomNum' => $request->input('bedroomNum'),
        'bathroomNum' => $request->input('bathroomNum'),
        'buildYear' => $request->input('buildYear'),
        'squareFeet' => $request->input('squareFeet'),
        'furnishingType' => $request->input('furnishingType'),
        'rentalAmount' => $request->input('rentalAmount'),
        'depositAmount' => $request->input('depositAmount'),
        'propertyAvailability' => $request->input('propertyAvailability'),
        'stateID' => $request->input('stateID'),
    ]);

    // Sync facilities
    if ($request->has('facilities')) {
        $selectedFacilities = $request->input('facilities');
        $property->facilities()->sync($selectedFacilities);
    } else {
        // If no facilities are selected, detach all existing facilities
        $property->facilities()->detach();
    }
    

    // Handle property photos (assuming you have a photos input field)
    // Upload new property photos
    if ($request->hasFile('propertyPhotos')) {
        foreach ($request->file('propertyPhotos') as $photo) {
            $path = $photo->store('property-photos', 'public');
            $propertyPhoto = new PropertyPhoto();
            $propertyPhoto->propertyID = $property->propertyID;
            $propertyPhoto->propertyPath = $path;
            $propertyPhoto->dateUpload = now();
            $propertyPhoto->save();
        }
    }

    return redirect()->route('properties')->with('success', 'Property Updated Successfully');
}

    

    public function destroy(string $id)
    {
        // Find the property by ID
        $property = Property::find($id);

        // Check if the property exists
        if (!$property) {
            abort(404, 'Property not found');
        }
        $property->propertyAvailability = 0;
        $property->save();

        return redirect()->route('properties')->with('success', 'Property Deleted Successfully');
    }

    public function apply(string $id)
    {
        // Find the property by ID
        $property = Property::find($id);

        // Check if the property exists
        if (!$property) {
            abort(404, 'Property not found');
        }

        $tenantID = "TNT1231234";
        $tenant = Tenant::find($tenantID);
        return view('propertyApply', compact('tenant', 'property'));
    }

    public function submitApplication(string $id)
    {
        // Find the property by ID
        $property = Property::find($id);

        // Check if the property exists
        if (!$property) {
            abort(404, 'Property not found');
        }

        $propertyRental = new PropertyRental();
        $propertyRental->propertyRentalID = $this->generateUniquePropertyRentalID();
        $propertyRental->propertyID = $id;
        $propertyRental->tenantID = "TNT1231234";
        $propertyRental->date = now();
        // Save the propertyRental
        $propertyRental->save();
        return view('propertyApplyConfirmation');

    }


    public function approve($id)
    {
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }

        // Assuming you have an agent relationship in your Property model
        $propertyRental->rentStatus = "Approved";
        $propertyRental->save();
        return redirect()->route('properties')
            ->with('success', 'Tenant application approved successfully!');

    }

    public function reject($id)
    {
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }

        // Assuming you have an agent relationship in your Property model
        $propertyRental->rentStatus = "Rejected";
        $propertyRental->save();
        return redirect()->route('properties')
            ->with('success', 'Tenant application rejectedy!');
    }


    public function applicationindex()
    {
        $tenantID = "TNT1231234";
        $tenant = Tenant::find($tenantID);

        if (!$tenant) {
            // Handle tenant not found, redirect or show an error view
            abort(404, 'Tenant not found');
        }

        $propertyRentals = $tenant->propertyRentals()->get();
        return view('propertyRentApplication', compact('propertyRentals'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        // Perform the search query based on your criteria
        $properties = Property::where('propertyName', 'like', '%' . $searchTerm . '%')
            ->orWhere('propertyType', 'like', '%' . $searchTerm . '%')
            ->orWhere('propertyAddress', 'like', '%' . $searchTerm . '%')
            ->orWhere('rentalAmount', 'like', '%' . $searchTerm . '%')
            ->get();
        $propertyRentals = null;
        return view('agent/propertyIndex', compact('propertyRentals', 'properties'));
    }

    function generateUniquePropertyID()
    {
        // Get the latest property ID from the database
        $latestProperty = Property::orderBy('propertyID', 'desc')->first();

        // Extract the numeric part and increment it
        if ($latestProperty) {
            $lastID = ltrim(substr($latestProperty->propertyID, 3), '0'); // Remove the "R" prefix and leading zeros
            $nextID = 'PRO' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            // If no property rental exists yet, start with R0000001
            $nextID = 'PRO0000001'; // Initial ID
        }
        return $nextID;
    }

    function generateUniquePropertyRentalID()
    {
        // Get the latest property ID from the database
        $latestPropertyRental = PropertyRental::orderBy('propertyRentalID', 'desc')->first();

        // Extract the numeric part and increment it
        // Generate the new property ID with leading zeros
        if ($latestPropertyRental) {
            $lastID = ltrim(substr($latestPropertyRental->propertyRentalID, 1), '0'); // Remove the "R" prefix and leading zeros
            $nextID = 'R' . str_pad($lastID + 1, 9, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            // If no property rental exists yet, start with R0000001
            $nextID = 'R000000001'; // Initial ID
        }
        return $nextID;
    }
}