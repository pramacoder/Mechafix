<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MekanikAssignedToBooking extends Notification
{
    use Queueable;

    public $booking;
    public $message;

    public function __construct($booking, $message)
    {
        $this->booking = $booking;
        $this->message = $message;
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
