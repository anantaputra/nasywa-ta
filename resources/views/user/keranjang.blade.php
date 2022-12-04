@extends('layouts.app')

@section('content')
<div class="container my-8">
    <div class="w-full bg-white py-3 px-8 border shadow-sm mb-4">
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-5">
                Produk
            </div>
            <div class="col-span-2">
                Harga Satuan
            </div>
            <div class="col-span-2">
                Kuantitas
            </div>
            <div class="col-span-2">
                Total Harga
            </div>
            <div>
                Aksi
            </div>
        </div>
    </div>
    @if (isset($keranjang))
    <div class="w-full bg-white shadow-sm mb-4">
        @foreach ($keranjang as $item)
        <div class="w-full px-8 py-4 border">
            <div class="grid grid-cols-12 gap-2">
                <div class="col-span-5">
                    <div class="flex items-center space-x-2">
                        <div>
                            @php
                                $gambar = json_decode($item->produk->gambar);
                            @endphp
                            <img src="{{ asset('upload/produk/'.$gambar[0]) }}" alt="" class="w-16 h-16">
                        </div>
                        <div>
                            {{ $item->produk->nama_produk }}
                        </div>
                    </div>
                </div>
                <div class="col-span-2 flex items-center">
                    <div>
                        Rp{{ number_format($item->produk->harga, 0, 0, '.') }}
                    </div>
                </div>
                <div class="col-span-2 flex items-center">
                    {{ $item->jumlah }}
                </div>
                <div class="col-span-2 flex items-center">
                    Rp{{ number_format(($item->produk->harga * $item->jumlah), 0, 0, '.') }}
                </div>
                <div class="flex items-center">
                    <a href="">Hapus</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <div class="w-full bg-white py-3 px-8 border shadow-sm mb-4">
        <div class="grid grid-cols-12 gap-2">
            <div class="col-span-5">
                Produk
            </div>
            <div class="col-span-2">
                Harga Satuan
            </div>
            <div class="col-span-2">
                Kuantitas
            </div>
            <div class="col-span-2">
                Total Harga
            </div>
            <div>
                Aksi
            </div>

            <div class="grid grid-cols-1 bg-white border-b border-dashed border-gray-300 py-8 px-8 space-y-4">
                <div class="flex justify-end text-sm text-gray-400 space-x-8">
                    <span>Subtotal Produk:</span>
                    <span>Rp{{ number_format($subtotal, 0, '', '.') }}</span>
                </div>
                <div class="flex justify-end text-sm text-gray-400 space-x-8">
                    <span>Biaya Pengiriman:</span>
                    <span id="biaya-expedisi-2" class="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rp0</span>
                </div>
                <div class="flex justify-end text-sm text-gray-400 space-x-8">
                    <span>Biaya Penanganan:</span>
                    <span>Rp3.000</span>
                </div>
                <div class="flex justify-end text-sm text-gray-400 space-x-8">
                    <span>Total Pembayaran:</span>
                    <span id="totalan-semua" class="text-2xl font-semibold text-rose-600">Rp{{ number_format(($subtotal+3000), 0, '', '.') }}</span>
                </div>
            </div>
            <div class="grid grid-cols-1 bg-white rounded-b py-8 px-6 space-y-4">
                <div class="flex justify-end">
                    <form action="{{ route('pesan.buat') }}" method="post">
                        @csrf
                        <input type="hidden" id="alamat-kirim" value="{{ $alamat[0]->id }}" name="alamat">
                        <input type="hidden" id="kirim-paket" name="paket">
                        <input type="hidden" value="{{ $produk->id_produk }}" name="produk">
                        @if (isset($varian))
                        <input type="hidden" value="{{ $varian }}" name="varian">
                        @endif
                        <input type="hidden" value="{{ $qty }}" name="qty">
                        <input type="hidden" id="metode_byr" name="metode_byr">
                        <input type="hidden" name="total">
                        <button type="submit" class="w-56 text-white bg-rose-600 hover:bg-rose-500 focus:border-rose-600 focus:ring-0 font-medium rounded text-sm px-5 py-2.5 mr-2 mb-2">Buat Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection