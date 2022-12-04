<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public static function bank_transfer($total, $bank)
    {
        $client = new Client();
        if($bank == 'permata') {
            $response = $client->post('https://api.sandbox.midtrans.com/v2/charge',
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Basic '. base64_encode(env('MIDTRANS_SERVER_KEY')),
                        'Content-Type' => 'application/json'
                    ], 
                    'body' => json_encode([
                        'payment_type' => 'permata',
                        'transaction_details' => [
                            'order_id' => rand(),
                            'gross_amount' => $total
                        ],
                        'custom_expiry' => [
                            'order_time' => Carbon::now()->format('Y-m-d H:i:s')." +0700",
                            'expiry_duration' => 60,
                            'unit' => 'minute'
                        ]
                    ])
                ]
            );
        } else {
            $response = $client->post('https://api.sandbox.midtrans.com/v2/charge', 
                [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Basic '. base64_encode(env('MIDTRANS_SERVER_KEY')),
                        'Content-Type' => 'application/json'
                    ],
                    'body' => json_encode([
                        'payment_type' => 'bank_transfer',
                        'transaction_details' => [
                            'order_id' => rand(),
                            'gross_amount' => $total
                        ], 
                        'bank_transfer' => [
                            'bank' => $bank
                        ],
                        'custom_expiry' => [
                            'order_time' => Carbon::now()->format('Y-m-d H:i:s')." +0700",
                            'expiry_duration' => 60,
                            'unit' => 'minute'
                        ]
                    ])
                ]);
        }
        $data = json_decode($response->getBody());
        return $data;
    }
}
