<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\AlamatUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Models\Keranjang;

class CheckoutController extends Controller
{
    public function checkout($id)
    {
        $alamat = AlamatUser::where('id_user', auth()->user()->id_user)->get()->count();
        
        if ($alamat == 0) {
            return redirect()->route('user.alamat');
        } else {
            $alamat = AlamatUser::where('id_user', auth()->user()->id_user)
            ->where('utama', true)
            ->get();

            $berat = 0;
            $provinsi = RajaOngkirController::semua_provinsi();
            $hash = decrypt($id);
            $data = explode('|', $hash);
            $produk = Produk::where('uuid', $data[0])->first();
            $qty = $data[1];
            $berat = $produk->berat * $qty;

            if(count($alamat) > 0){
                $jne = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'jne', $berat);

                $pos = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'pos', $berat);

                $tiki = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'tiki', $berat);

                return view('pesan.pesan-sekarang', compact('produk', 'qty', 'alamat', 'provinsi', 'jne', 'pos', 'tiki'));
            } else {
                return redirect()->route('user.alamat')->with('status', 'kosong');
            }
        }
    }

    public function keranjang()
    {
        return 'ahi';
        $alamat = AlamatUser::where('id_user', auth()->user()->id_user)->get()->count();
        
        if ($alamat == 0) {
            return redirect()->route('user.alamat');
        } else {
            return 'ji';
            $alamat = AlamatUser::where('id_user', auth()->user()->id_user)
                    ->where('utama', true)
                    ->get();

            $berat = 0;
            $provinsi = RajaOngkirController::semua_provinsi();
            $keranjang = Keranjang::where('id_user', auth()->user()->id_user)
                        ->where('checkout', false)
                        ->get();
            foreach ($keranjang as $item) {
                $produk = Produk::find($item->id_produk)->first();
                $berat += $produk->berat * $item->jumlah;
            }

            return $berat;
            if(count($alamat) > 0){
                $jne = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'jne', $berat);

                $pos = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'pos', $berat);

                $tiki = RajaOngkirController::get_ongkir($alamat[0]->kode_kota, 'tiki', $berat);

                return view('pesan.pesan-sekarang', compact('produk', 'qty', 'alamat', 'provinsi', 'jne', 'pos', 'tiki'));
            } else {
                return redirect()->route('user.alamat')->with('status', 'kosong');
            }
        }
    }

    public function simpan(Request $request)
    {
        
    }
}
