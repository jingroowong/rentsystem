<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PropertyRental;
use App\Models\Property;
use App\Models\Refund;
class ReportController extends Controller
{
    public function showReports()
    {
        // Logic to show the reports page
        return view('admin/reportIndex');
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:rental_transaction,agent_fees',
            'month' => 'required|date_format:Y-m',
        ]);

        [$year, $month] = explode('-', $request->input('month'));
        $startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();

        $reportType = $request->input('report_type');

        switch ($reportType) {
            case 'rental_transaction':
                $data = $this->generateRentalTransactionReport($startDate, $endDate);
                return view('admin/reportShowRental', compact('data','startDate','endDate'));
            case 'agent_fees':
                // Add logic for agent fees report if needed
                $data = $this->generateAgentFeesReport($startDate, $endDate);
                return view('admin/reportShowAgent', compact('data','startDate','endDate'));
            default:
                abort(404); // Handle invalid report type
            }
    }
    private function generateRentalTransactionReport($startDate, $endDate)
    {
        // // Fetch data from the database
        // $totalAgentFees = PropertyRental::whereBetween('date', [$startDate, $endDate])->sum('agentFee');
        // $numberOfTransactions = PropertyRental::whereBetween('date', [$startDate, $endDate])->count();
        // $totalAdvancedRental = PropertyRental::whereBetween('date', [$startDate, $endDate])->sum('advancedRental');
    
        // // Fetch data for refund cases
        // $numberOfRefundCases = Refund::whereBetween('created_at', [$startDate, $endDate])->count();
    
        // // Calculate occupancy rate
        // $totalOccupiedProperties = PropertyRental::whereBetween('date', [$startDate, $endDate])->where('rentStatus', 'Paid')->count();
        // $totalProperties = Property::count();
        // $occupancyRate = ($totalOccupiedProperties / $totalProperties) * 100;
    
        // // Fetch data for rental transaction types
        // $transactionTypes = PropertyRental::select('transactionType', \DB::raw('count(*) as count'))->whereBetween('date', [$startDate, $endDate])->groupBy('transactionType')->get();
    
        // // Transform the data for display
        // $reportData = [
        //     'totalAgentFees' => $totalAgentFees,
        //     'numberOfTransactions' => $numberOfTransactions,
        //     'totalAdvancedRental' => $totalAdvancedRental,
        //     'numberOfRefundCases' => $numberOfRefundCases,
        //     'occupancyRate' => $occupancyRate,
        //     'transactionTypes' => $transactionTypes,
        // ];
        // Transform the data for display
        $transactionTypes = [
            [
                'type' => 'Apartments',
                'numberOfTransactions' => 5,
                'amount' => 6000,
                'refund' => 1,
            ],
            [
                'type' => 'Condo',
                'numberOfTransactions' => 3,
                'amount' => 2000,
                'refund' => 0,
            ],
            [
                'type' => 'Houses',
                'numberOfTransactions' => 3,
                'amount' => 700,
                'refund' => 0,
            ],
            [
                'type' => 'Commercial',
                'numberOfTransactions' => 1,
                'amount' => 300,
                'refund' => 0,
            ],
           
        ];

            // Sort the array based on the 'amount' field
    usort($transactionTypes, function ($a, $b) {
        return $b['amount'] - $a['amount'];
    });
    
        $reportData = [
            'totalTransactionAmount' => 9000,
            'numberOfTransactions' => 11,
            'numberOfDays' => 25,
            'numberOfRefundCases' => 1,
            'occupancyRate' => 40,
            'numberOfProperties' => 25,
            'numberOfOccupancy' => 10,
            'transactionTypes' => $transactionTypes
        ];
        return $reportData;
    }
    
 

    private function generateAgentFeesReport($startDate, $endDate)
    {
        // Logic to generate agent fees report
        // Fetch data from the database, calculate totals, etc.
        // ...
        $topAgents = [
            [
                'agentID' => "AGT1468844",
                'agentName' => 'John Smith',
                'numberOfPostings' => 10,
                'amountPaid' => 5000,
            ],
            [
                'agentID' => "AGT1405144",
                'agentName' => 'Tom Danny',
                'numberOfPostings' => 8,
                'amountPaid' => 4500,
            ],
            [
                'agentID' => "AGT0003056",
                'agentName' => 'Bob Roger',
                'numberOfPostings' => 12,
                'amountPaid' => 6000,
            ],
            [
                'agentID' => "AGT0150607",
                'agentName' => 'Peter Pan',
                'numberOfPostings' => 5,
                'amountPaid' => 3000,
            ],
            [
                'agentID' => "AGT0525207",
                'agentName' => 'Jordan Jack',
                'numberOfPostings' => 15,
                'amountPaid' => 7000,
            ],
        ];
        
          // Transform the data for display
    $reportData = [
        'numberOfDays' => 25,
        'totalAgentFees' => 120000,
        'numberOfAgents' => 50,
        'numberOfListings' => 120,
        'collectionRate' => 92,
        'numberOfCollected'=> 110,
        'numberOfPending'=> 10,
        'topAgents' => $topAgents,
    ];

    return $reportData;
    }
}
