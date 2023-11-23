<?php

namespace App\Http\Controllers;

use App\Models\PropertyRental;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $refunds = Refund::all();
        return view('admin/refundIndex', compact('refunds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }
        return view('refundCreate', compact('propertyRental'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $propertyRentalID = $request->propertyRentalID;
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($propertyRentalID);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }


        $refund = new Refund();
        $refund->refundID = $this->generateUniqueRefundID();
        $refund->refundDate = now();
        $refund->refundReason = $request->reason;
        $refund->refundStatus = "Pending";
        $refund->propertyRentalID = $propertyRentalID;
        $refund->save();
        $propertyRental->rentStatus = "Refund requested";
        $propertyRental->save();
        return redirect()->route('properties.applicationIndex')->with('success', 'Refund request submitted to admin successful.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            // Handle Refund not found, redirect or show an error view
            abort(404, 'Refund not found');
        }

        return view('admin/refundProcess', compact('refund'));
    }

    public function approve(string $id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            // Handle Refund not found, redirect or show an error view
            abort(404, 'Refund not found');
        }

        $refund->refundStatus = 'Approved';
        $refund->approvalDate = now();
        $refund->save();

        $propertyRental = $refund->propertyRental;
        $propertyRental->rentStatus = "Refund approved";
        $propertyRental->save();
        return redirect()->route('refunds.index')->with('success', 'Refund approved.');

    }

    public function reject(Request $request)
    {
        $refund = Refund::find($request->refundID);

        if (!$refund) {
            // Handle Refund not found, redirect or show an error view
            abort(404, 'Refund not found');
        }

        $refund->refundStatus = 'Rejected';
        $refund->rejectReason = $request->rejectReason;
        $refund->save();

        $propertyRental = $refund->propertyRental;
        $propertyRental->rentStatus = "Refund rejected";
        $propertyRental->save();
        return redirect()->route('refunds.index')->with('success', 'Refund rejected.');

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

    public function generateUniqueRefundID()
    {
        $latestRefund = Refund::orderBy('refundID', 'desc')->first();

        if ($latestRefund) {
            $lastID = ltrim(substr($latestRefund->refundID, 3), '0'); // Remove the "RFD" prefix and leading zeros
            $nextID = 'RFD' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            $nextID = 'RFD0000001'; // Initial ID
        }

        return $nextID;
    }
}
