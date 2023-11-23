<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyRental;
use App\Models\Payment;
use App\Models\Tenant;

use App\Models\WalletTransaction;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenantID = "TNT1234123";
        $tenant = Tenant::find($tenantID);

        if (!$tenant) {
            // Handle tenant not found, redirect or show an error view
            abort(404, 'Tenant not found');
        }

        // Retrieve property rentals for the tenant with rentStatus 'paid'
        $propertyRentals = $tenant->propertyRentals()->where('rentStatus', 'paid')->get();

        return view('paymentHistoryIndex', compact('propertyRentals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }

        return view('paymentCreate', compact('propertyRental'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }

        $payment = new Payment();
        $payment->paymentID = $this->generateUniquePaymentID();
        $payment->paymentMethod = "Credit Card";
        $payment->paymentDate = now();
        $payment->paymentTime = now();
        $paymentAmount = $propertyRental->property->rentalAmount + $propertyRental->property->depositAmount;
        $payment->paymentAmount = $paymentAmount;
        $payment->save();

        $propertyRental->paymentID = $payment->paymentID;
        $propertyRental->rentStatus = "Paid";
        $propertyRental->save();

        $propertyRental = PropertyRental::find($id);
        return view('paymentReceipt', compact('propertyRental'));
    }

    public function release(string $id)
    {
        // Assuming you have relationships set up in your Property model
        $propertyRental = PropertyRental::find($id);

        if (!$propertyRental) {
            // Handle property not found, redirect or show an error view
            abort(404, 'Property Rental not found');
        }

        // // Retrieve agent's wallet
        $agentWallet = $propertyRental->property->agent->wallet;

        $agentWallet->balance += $propertyRental->payment->paymentAmount;
        $agentWallet->save();

        // Create a walletTransaction record
        $walletTransaction = new WalletTransaction;
        $walletTransaction->transactionID = $this->generateUniqueTransactionID(); // Implement this function
        $walletTransaction->transactionType = 'Fund Release';
        $walletTransaction->transactionDate = now()->toDateString();
        $walletTransaction->transactionTime = now()->toTimeString();
        $walletTransaction->transactionAmount = $propertyRental->payment->paymentAmount;
        $walletTransaction->walletID = $agentWallet->walletID;
        $walletTransaction->save();

        $propertyRental->rentStatus = "Completed";
        $propertyRental->save();
        return redirect()->route('properties.applicationIndex')->with('success', 'Fund released to agent successful.');
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

    public function generateUniquePaymentID()
    {
        $latestPayment = Payment::orderBy('paymentID', 'desc')->first();

        if ($latestPayment) {
            $lastID = ltrim(substr($latestPayment->paymentID, 3), '0'); // Remove the "PAY" prefix and leading zeros
            $nextID = 'PAY' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            $nextID = 'PAY0000001'; // Initial ID
        }

        return $nextID;
    }
    public function generateUniqueTransactionID()
    {
        $latestTransaction = WalletTransaction::orderBy('transactionID', 'desc')->first();

        if ($latestTransaction) {
            $lastID = ltrim(substr($latestTransaction->transactionID, 3), '0'); // Remove the "WTR" prefix and leading zeros
            $nextID = 'WTR' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            $nextID = 'WTR0000001'; // Initial ID
        }

        return $nextID;
    }
}
