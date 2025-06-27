<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MekanikJobAssigned extends Notification
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
            'message' => 'Kamu mendapat job baru untuk booking #' . $this->booking->id_booking_service,
            'booking_id' => $this->booking->id_booking_service,
            'plat' => $this->booking->platKendaraan->nomor_plat_kendaraan ?? '-',
        ];
    }
}