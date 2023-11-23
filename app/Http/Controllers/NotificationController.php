<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
        $agentID = "AGT1234567";
        $notifications = Notification::where('userID', $agentID)->get();
        $unreadCount = $notifications->where('status', 'Unread')->count();

        return view('agent/notificationIndex', compact('notifications','unreadCount'));
    }

    public function tenantIndex()
    {
        $tenantID = "TNT1231234";
        $notifications = Notification::where('userID', $tenantID)->get();
        $unreadCount = $notifications->where('status', 'Unread')->count();

        return view('notificationIndex', compact('notifications','unreadCount'));
    }

    public function search(Request $request)
    {
        $agentID = "AGT1234567";
        $readnotifications = Notification::where('userID', $agentID)->get();
        $unreadCount = $readnotifications->where('status', 'Unread')->count();

        $searchTerm = $request->input('search');

        // Perform the search query based on your criteria
        $notifications = Notification::where('subject', 'like', '%' . $searchTerm . '%')
            ->orWhere('content', 'like', '%' . $searchTerm . '%')
            ->orderBy('timestamp', 'desc')
            ->get();

     
        // Return the search results
        return view('agent/notificationIndex', compact('notifications','unreadCount'));
    }
    public function markAsRead(Request $request)
    {
        $notificationIDs = $request->input('notification');

        // Update the notification status to 'Read'
        Notification::whereIn('notificationID', $notificationIDs)->update(['status' => 'Read']);

        return redirect()->back()->with('success', 'Notifications marked as read.');
    }

    public function delete(Request $request)
    {
        $notificationIDs = $request->input('notification');

        // Delete the selected notifications
        Notification::whereIn('notificationID', $notificationIDs)->delete();

        return redirect()->back()->with('success', 'Notifications deleted.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
