<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Agent;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\PropertyRental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * Display the agent's wallet page.
     */
    public function index()
    {
        //Retrieve the agent's wallet
        $agentWallet = Agent::find("AGT1234567")->wallet;

        $walletID = $agentWallet->walletID;
        $walletBalance = $agentWallet->balance;

        // Retrieve agent's financial transactions
        $agentTransactions = WalletTransaction::where('walletID', $walletID)
            ->orderBy('transactionDate', 'desc')
            ->get();

        return view('agent/walletIndex', compact('walletID', 'walletBalance', 'agentTransactions'));
    }

    public function walletPayment(Request $request)
    {
        // Retrieve agent's balance
        $walletBalance = Wallet::where('agentID', "AGT1234567")->value('balance');
        $activePropertyCount = 4;
        return view('agent/walletPayment', compact('walletBalance', 'activePropertyCount'));
    }

    /**
     * Handle the process of making a payment for a rental posting.
     */
    public function payment(Request $request)
    {
        //Retrieve the agent's wallet
        $agentWallet = Agent::find("AGT1234567")->wallet;
        // Deduct the posting fee from the agent's wallet balance

        $deductAmount = $request->input('amount');
        if ($agentWallet->balance < $deductAmount) {
            // Handle insufficient balance
            return redirect()->route('payment')->with('error', 'Insufficient balance.');
        } else {
            $agentWallet->balance -= $deductAmount;
            $agentWallet->save();
        }
        //TO:DOO
//Update the duration
//Create wallet transaction

        // Return the confirmation message
        return redirect()->route('agentWallet')
            ->with('success', 'Payment successful.');
    }

    public function walletTopUp(Request $request)
    {
        // Retrieve agent's balance
        $agentBalance = Wallet::where('agentID', "AGT1234567")->value('balance');
        return view('agent/walletTopUp', compact('agentBalance'));
    }

    /**
     * Handle the process of making a payment for a rental posting.
     */
    public function topUp(Request $request)
    {

        //Retrieve the agent's wallet
        $agentWallet = Agent::find("AGT1234567")->wallet;
        // Deduct the posting fee from the agent's wallet balance

        $topUpAmount = $request->input('topUpAmount');

        $agentWallet->balance += $topUpAmount;
        $agentWallet->save();


        return redirect()->route('agentWallet')
            ->with('success', 'Top Up RM ' . $topUpAmount . ' successful.');
    }

    public function walletWithdraw(Request $request)
    {
        // Retrieve agent's balance
        $agentBalance = Wallet::where('agentID', "AGT1234567")->value('balance');
        return view('agent/walletWithdraw', compact('agentBalance'));
    }

    /**
     * Handle the process of withdrawing money to a bank.
     */

    public function withdraw(Request $request)
    {
        $request->validate([
            'withdrawAmount' => 'required|numeric',
            'bank' => 'required',
            'accountNumber' => 'required',
        ]);


        $amount = $request->input('withdrawAmount');
        $bank = $request->input('bank');
        $accountNumber = $request->input('accountNumber');

        // // Assuming you have the user's ID (agentID) from the authenticated session
        // $agentID = auth()->user()->agentID;   
        $agentID = "AGT1234567";

        // // Retrieve agent's wallet
        $agentWallet = Agent::find($agentID)->wallet;

        // // Subtract the withdrawn amount from the wallet's balance
        // $agentWallet->balance -= $amount;
        // $agentWallet->save();


        // Specify the conditions to find the wallet
        $conditions = ['agentID' => $agentID];

        // Define the values to update
        $updates = ['balance' => DB::raw("balance - $amount")]; // Assuming you're subtracting the amount

        // Use updateOrInsert to update the wallet or insert if it doesn't exist
        Wallet::updateOrInsert($conditions, $updates);


        // Create a walletTransaction record
        $walletTransaction = new WalletTransaction;
        $walletTransaction->transactionID = $this->generateUniqueTransactionID(); // Implement this function
        $walletTransaction->transactionType = 'Withdrawal';
        $walletTransaction->transactionDate = now()->toDateString();
        $walletTransaction->transactionTime = now()->toTimeString();
        $walletTransaction->transactionAmount = $amount;
        $walletTransaction->walletID = $agentWallet->walletID;

        // Create the notification content
        $notificationContent = 'Withdraw RM ' . number_format($amount, 2) .
            ' to ' . $bank . ' (' . $accountNumber . ')';

        // Create a notification record
        $notification = new Notification();
        $notification->notificationID = $this->generateUniqueNotificationID();
        $notification->subject = 'Wallet';
        $notification->content = $notificationContent;
        $notification->timestamp = now();
        $notification->status = 'Unread';
        $notification->userID = $agentID;

        // Save both walletTransaction and notification
        $walletTransaction->save();
        $notification->save();

        // Redirect to a success page or handle the response as needed
        return redirect()->route('agentWallet')->with('success', 'Withdrawal successful.');
    }

    public function walletPending(Request $request)
    {
        //Retrieve the agent's wallet
        $agent = Agent::find("AGT1234567");

        // Retrieve all property rentals with rentStatus "Paid" associated with the agent
        $pendingRentals = PropertyRental::where('rentStatus', 'Paid')
            ->whereIn('propertyID', $agent->properties->pluck('propertyID')) // Assuming 'id' is the primary key in Property
            ->get();
        return view('agent/walletPending', compact('pendingRentals', 'agent'));
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

    public function generateUniqueNotificationID()
    {
        $latestNotification = Notification::orderBy('notificationID', 'desc')->first();

        if ($latestNotification) {
            $lastID = ltrim(substr($latestNotification->notificationID, 3), '0'); // Remove the "NOT" prefix and leading zeros
            $nextID = 'NOT' . str_pad($lastID + 1, 7, '0', STR_PAD_LEFT); // Increment and pad to 7 digits
        } else {
            $nextID = 'NOT0000001'; // Initial ID
        }

        return $nextID;
    }
}