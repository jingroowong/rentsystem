<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Agent;
use App\Models\Wallet;
use App\Models\WalletTransaction;
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
        return view('agent/walletPayment', compact('walletBalance','activePropertyCount'));
    }

    /**
     * Handle the process of making a payment for a rental posting.
     */
    public function payment(Request $request)
    {
//         // Your logic for making a payment
//   // Validate the payment details (e.g., duration)
//   $request->validate([
//     'duration' => 'required|in:7,14,30', // Validate the selected duration
// ]);

// // Deduct the posting fee from the agent's wallet balance
// $walletBalance = 800; // Replace with actual balance retrieval logic
// $postingFee = $request->input('duration') * 10; // Replace 10 with your posting fee rate

// if ($walletBalance < $postingFee) {
//     // Handle insufficient balance
//     return redirect()->route('payment')->with('error', 'Insufficient balance.');
// }

// // Deduct the posting fee from the wallet balance
// $newBalance = $walletBalance - $postingFee;

// // Update the wallet balance (this code will vary depending on your implementation)
// // Replace the following with your update logic:
// // Wallet::where('agentID', $agentID)->update(['balance' => $newBalance]);

// // Return the confirmation message
// return view('payment.paymentConfirmation', ['newDuration' => $request->input('duration')]);

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
        // Your logic for making a payment

        return redirect()->route('agentWallet')
            ->with('success', 'Top Up successful.');
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
       
        return view('agent/walletPending');
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