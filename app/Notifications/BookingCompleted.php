<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingCompleted extends Notification
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
            'message' => 'Servis kendaraan Anda ('.$this->booking->platKendaraan->nomor_plat_kendaraan.') telah selesai. Silakan lakukan pembayaran.',
            'booking_id' => $this->booking->id_booking_service,
        ];
    }
}