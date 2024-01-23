<?php

namespace App\Http\Services;

class NotificationService
{
    public function emailNotification($email, $message)
    {

    }

    public function whatsAppNotification($no_hp, $message): void
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env('WHATSAPP_URL').'send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'number'    => $no_hp,
                'message'   => $message
            ]),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        curl_exec($curl);
        curl_close($curl);
    }

    public function appNotification($toko_id, $message)
    {

    }

    public function ucapanSelamat()
    {
        $jam = date('H', time());

        if ($jam < 10) {
            return "Pagi";
        } elseif ($jam > 10 && $jam < 14) {
            return "Siang";
        } elseif ($jam > 14 && $jam < 16) {
            return "Sore";
        } elseif ($jam > 16) {
            return "Malam";
        }
    }
}
