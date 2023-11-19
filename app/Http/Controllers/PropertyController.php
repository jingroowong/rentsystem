<?php
namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Property;
use App\Models\PropertyFacility;
use App\Models\PropertyPhoto;
use App\Models\State;
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
        return view('agent/propertyIndex', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $states = State::all();
        $facilities = Facility::all();
        $walletBalance = Wallet::where('agentID', "AGT1234567")->value('balance');
        return view('agent/propertyCreate', compact('states', 'facilities', 'walletBalance'));
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


            $success = true; // Set $success to true if the upload is successful
        } else {
            $success = false; // Set $success to false if there's an error
        }
        return view('agent/propertyConfirmation', compact('success'));
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

        return view('agent/propertyUpdate', compact('property', 'agent','states', 'facilities'));
    }

    public function update(Request $request)
    {
    }


    function generateUniquePropertyID()
    {
        // Get the latest property ID from the database
        $latestProperty = Property::latest('propertyID')->first();

        if ($latestProperty) {
            // Extract the numeric part and increment it
            $numericPart = (int) substr($latestProperty->propertyID, 4);
            $numericPart++; // Increment by 1

            // Generate the new property ID with leading zeros
            $newPropertyID = 'PRO' . str_pad($numericPart, 7, '0', STR_PAD_LEFT);
        } else {
            // If no property exists yet, start with PROP0000001
            $newPropertyID = 'PRO0000001';
        }

        return $newPropertyID;
    }
}