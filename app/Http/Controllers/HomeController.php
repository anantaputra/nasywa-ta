<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $terbaru = Produk::latest()->limit(3)->get();
        
        return view('home', compact('terbaru'));
    }

    public function detail($id)
    {
        $produk = Produk::where('uuid', $id)->first();

        return view('detail', compact('produk'));
    }
}
