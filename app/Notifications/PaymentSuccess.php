<?php

namespace App\Notifications;

use App\Models\RiwayatPerbaikan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NextServiceReminder extends Notification
{
    use Queueable;

    public $riwayat;
    public $daysLeft;

    public function __construct(RiwayatPerbaikan $riwayat, $daysLeft)
    {
        $this->riwayat = $riwayat;
        $this->daysLeft = $daysLeft;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = $this->getNotificationMessage();

        return [
            'title' => 'Pengingat Service Kendaraan',
            'message' => $message,
            'type' => 'next_service_reminder',
            'riwayat_id' => $this->riwayat->id_riwayat_perbaikan,
            'plat_kendaraan' => $this->riwayat->platKendaraan->nomor_plat_kendaraan ?? '',
            'next_service_date' => $this->riwayat->next_service->format('Y-m-d'),
            'days_left' => $this->daysLeft,
        ];
    }

    private function getNotificationMessage()
    {
        switch ($this->daysLeft) {
            case 2:
                return "Kendaraan Anda perlu service dalam 2 hari lagi! Jangan lupa untuk book service.";
            case 1:
                return "Kendaraan Anda perlu service besok! Segera book service untuk menjaga performa kendaraan.";
            case 0:
                return "Kendaraan Anda perlu service hari ini! Pastikan kendaraan tetap dalam kondisi prima.";
            default:
                return "Kendaraan Anda akan segera perlu service.";
        }
    }
}
