<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $sukses = Transaksi::with(['pesanan' => function($q){
            $q->where('id_user', auth()->user()->id_user);
        }])->where('status', 'settlement')->get();

        // return $sukses;
        return view('user.riwayat', compact('sukses'));
    }

    public function nota($id)
    {
        $transaksi = Transaksi::where('uuid', $id)->first();
    
        return view('pesan.nota', compact('transaksi'));
    }
}
