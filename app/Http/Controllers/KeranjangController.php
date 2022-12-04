<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where('id_user', auth()->user()->id_user)->get();
        return view('user.keranjang', compact('keranjang'));
    }

    public function tambah(Request $request)
    {
        // cek keranjang sudah ada item
        $produk = Produk::where('uuid', $request->uuid)->first();
        $item = Keranjang::where('id_user', auth()->user()->id_user)
                ->where('id_produk', $produk->id_produk)->first();
        if($item){
            $item->jumlah = $item->jumlah + $request->qty;
            $item->save();
        } else {
            $item = new Keranjang();
            $item->id_user = auth()->user()->id_user;
            $item->id_produk = $produk->id_produk;
            $item->jumlah = $request->qty;
            $item->save();
        }
        return redirect()->route('keranjang');
    }
}
