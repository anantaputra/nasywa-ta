<?php

namespace App\Http\Controllers\User;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagihanUserController extends Controller
{
    public function tagihan($id)
    {
        $id = decrypt($id);
        $transaksi = Transaksi::find($id);
        return view('pesan.tagihan', compact('transaksi'));
    }

    public static function jmlTagihan()
    {
        $tagihan = Transaksi::with(['pesanannya' => function($q){
            $q->where('id_user', auth()->user()->id_user);
        }])->where('status', 'pending')->get();

        return count($tagihan);
    }
}
