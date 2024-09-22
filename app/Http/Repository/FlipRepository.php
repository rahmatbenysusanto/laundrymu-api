<?php

namespace App\Http\Repository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class FlipRepository
{
    private function generateToken(): string
    {
        $secret_key = env('FLIP_SECRET_KEY');
        return base64_encode($secret_key.":");
    }

    public function getBalance()
    {
        $client = new Client();
        $response = $client->request('GET', env('FLIP_API_URL').'v2/general/balance', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->generateToken(),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
        ]);

        $body = $response->getBody();
        $content = $body->getContents();
        return json_decode($content, true);
    }

    public function getAllPayment()
    {
        $client = new Client();
        $response = $client->request('GET', env('FLIP_API_URL').'v2/pwf/payment', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->generateToken(),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
        ]);

        $body = $response->getBody();
        $content = $body->getContents();
        return json_decode($content, true);
    }

    public function createBill($title, $amount)
    {
        $client = new Client();
        $response = $client->request('POST', env('FLIP_API_URL').'v2/pwf/bill', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->generateToken(),
                'Content-Type'  => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                "title"                     => $title,
                "amount"                    => $amount,
                "type"                      => "SINGLE",
                "expired_date"              => date('Y-m-d H:i', strtotime("+1 day")),
                "redirect_url"              => "",
                "is_address_required"       => 0,
                "is_phone_number_required"  => 0
            ]
        ]);

        $body = $response->getBody();
        $body->getContents();
        $data = json_decode($body, true);

        return $data['link_url'] ?? 'Link URL tidak ditemukan';
    }
}
