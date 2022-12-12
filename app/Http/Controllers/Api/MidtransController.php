<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Produk;
use GuzzleHttp\Client;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MidtransController extends Controller
{
    public static function bank_transfer($total, $bank)
    {
        $client = new Client();
        if($bank == 'permata') {
            $response = $client->post('https://api.midtrans.com/v2/charge',
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
            $response = $client->post('https://api.midtrans.com/v2/charge', 
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

    public function handler(Request $request)
    {
        $json = json_decode($request->getContent());
        $signature = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if($signature != $json->signature_key){
            return abort(404);
        }

        $transaksi = Transaksi::where('id_transaksi', $json->order_id)->first();
        $transaksi->status = $json->transaction_status;

        $keranjang = Keranjang::where('id_pesanan', $transaksi->id_pesanan)->get();
        foreach ($keranjang as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok = $produk->stok - $item->jumlah;
            $produk->save();
        }

        return $transaksi->save();
    }
}
