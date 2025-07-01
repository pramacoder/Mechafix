<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentSuccess extends Notification
{
    use Queueable;

    public $pembayaran;

    public function __construct($pembayaran)
    {
        $this->pembayaran = $pembayaran;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Pembayaran servis kendaraan Anda telah berhasil. Terima kasih!',
            'pembayaran_id' => $this->pembayaran->id_pembayaran,
            'total' => $this->pembayaran->total_pembayaran,
        ];
    }
}