<?php

namespace App\Http\Controllers;

use App\Http\Service\FlipService;
use Illuminate\Http\Request;

class FlipController extends Controller
{
    public function __construct(
        protected FlipService $flipService
    ) {}

    public function getBalance(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->flipService->getBalance();

            return response()->json([
                'status'    => true,
                'message'   => 'Get Balance successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => 'Get Balance Failed',
                'errors'    => $err->getMessage()
            ], 400);
        }
    }

    public function getAllPayment(): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->flipService->getAllPayment();

            return response()->json([
                'status'    => true,
                'message'   => 'Get all Payment successfully',
                'data'      => $result
            ], 200);
        } catch (\Exception $err) {
            return response()->json([
                'status'    => false,
                'message'   => $err->getMessage(),
                'errors'    => $err->getMessage()
            ], 400);
        }
    }














    public function getBalance2(): \Illuminate\Http\JsonResponse
    {
        $ch = curl_init();
        $secret_key = "JDJ5JDEzJElWVGJyQTNSbDVKSlJuZnZqbEJvZS56aVowaEVHa0JkYVIzOEY4MXl6dDYzM1lRWkt5aGIy";
        $encoded_auth = base64_encode($secret_key.":");

        curl_setopt($ch, CURLOPT_URL, "https://bigflip.id/big_sandbox_api/v2/pwf/bill");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_POST, TRUE);

        $payloads = [
            "title" => "Coffee Table",
            "amount" => 900000,
            "type" => "SINGLE",
            "expired_date" => "2024-09-14 21:10",
            "redirect_url" => "https://someurl.com",
            "is_address_required" => 0,
            "is_phone_number_required" => 0
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payloads));

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/x-www-form-urlencoded"
        ));

        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic ".$encoded_auth]);

        $response = curl_exec($ch);
        curl_close($ch);

        return response()->json($response, 200);
    }
}
