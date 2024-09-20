<?php

namespace App\Http\Repository;

use GuzzleHttp\Client;

class NotificationRepository
{
    public function whatsappMessage($to, $message): mixed
    {
        $client = new Client();

        $response = $client->request('POST', 'https://app.wapanels.com/api/create-message', [
            'form_params' => [
                'appkey'    => 'a3614629-a1f9-4225-bec7-cd8b8e937628',
                'authkey'   => 'QSSBVPUexJmzvwKPELzIjNYQcOGLduu3skWtdPBF45ia0cRmeg',
                'to'        => $to,
                'message'   => $message,
                'sandbox'   => 'false'
            ]
        ]);

        $body = $response->getBody();
        $content = $body->getContents();
        return json_decode($content, true);
    }
}
