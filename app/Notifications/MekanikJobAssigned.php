<?php
namespace App\Notifications;

use GuzzleHttp\Psr7\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MekanikJobAssigned extends Notification
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
            'message' => 'Kamu mendapat job baru untuk booking #' . $this->booking->id_booking_service,
            'booking_id' => $this->booking->id_booking_service,
            'plat' => $this->booking->platKendaraan->nomor_plat_kendaraan ?? '-',
        ];
    }
}
