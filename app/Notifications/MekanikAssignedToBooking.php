<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MekanikAssignedToBooking extends Notification
{
    use Queueable;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Booking Anda akan dikerjakan oleh ' . ($this->booking->mekanik->user->name ?? '-'),
            'booking_id' => $this->booking->id_booking_service,
            'mekanik' => $this->booking->mekanik->user->name ?? '-',
        ];
    }
}