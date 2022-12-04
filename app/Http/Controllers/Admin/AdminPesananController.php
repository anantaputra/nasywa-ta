<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    public function index()
    {
        $pesanan = Transaksi::where('status', 'settlement')->get();
        return $pesanan;
        return view('admin.pesanan.index', compact('pesanan'));
    }
}
