<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated user
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->orderBy('created_at', 'desc')
            ->take(20) // Limit to 20 notifications
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $this->getNotificationTitle($notification),
                    'message' => $this->getNotificationMessage($notification),
                    'time' => $this->formatTime($notification->created_at),
                    'unread' => is_null($notification->read_at),
                    'type' => $notification->type,
                    'data' => $notification->data
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->unreadNotifications->count()
        ]);
    }

    /**
     * Mark a specific notification as read
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        return response()->json([
            'unread_count' => Auth::user()->unreadNotifications->count()
        ]);
    }

    /**
     * Get notification title based on type
     */
    private function getNotificationTitle($notification)
    {
        $data = json_decode($notification->data, true);
        
        switch ($notification->type) {
            case 'App\\Notifications\\ServiceCompleted':
                return 'Service Completed';
            case 'App\\Notifications\\ServiceScheduled':
                return 'Service Scheduled';
            case 'App\\Notifications\\PaymentReceived':
                return 'Payment Received';
            case 'App\\Notifications\\ServiceReminder':
                return 'Service Reminder';
            default:
                return $data['title'] ?? 'New Notification';
        }
    }

    /**
     * Get notification message based on type
     */
    private function getNotificationMessage($notification)
    {
        $data = json_decode($notification->data, true);
        
        switch ($notification->type) {
            case 'App\\Notifications\\ServiceCompleted':
                return $data['message'] ?? 'Your vehicle service has been completed';
            case 'App\\Notifications\\ServiceScheduled':
                return $data['message'] ?? 'Your service appointment has been scheduled';
            case 'App\\Notifications\\PaymentReceived':
                return $data['message'] ?? 'Payment has been received successfully';
            case 'App\\Notifications\\ServiceReminder':
                return $data['message'] ?? 'Service reminder for your vehicle';
            default:
                return $data['message'] ?? 'You have a new notification';
        }
    }

    /**
     * Format time for display
     */
    private function formatTime($timestamp)
    {
        $now = Carbon::now();
        $time = Carbon::parse($timestamp);
        
        if ($time->isToday()) {
            return $time->format('H:i');
        } elseif ($time->isYesterday()) {
            return 'Yesterday';
        } elseif ($time->diffInDays($now) <= 7) {
            return $time->format('l');
        } else {
            return $time->format('M d');
        }
    }
}