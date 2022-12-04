@extends('layouts.app')

@section('content')

<div class="w-full flex justify-center py-8">
    <div class="w-1/2 px-12 py-10 bg-white border rounded-xl space-y-4">
        <div class="flex justify-center text-2xl text-rose-600 font-semibold">
            Tagihan Pembayaran
        </div>
        <div class="flex justify-center text-4xl font-semibold" id="timer">

        </div>
        <div class="flex justify-between text-lg border-t pt-4 pb-2">
            <span>Total Tagihan:</span>
            <span class="text-rose-600 font-semibold">Rp. {{ number_format($transaksi->total, 0, '', '.') }}</span>
        </div>
        <div class="flex justify-between text-lg">
            <span>Metode Pembayaran:</span>
            <span class="text-rose-600 font-semibold">{{ ($transaksi->metode != 'alfamart' || 'indomaret') ? 'bank '.$transaksi->metode : $transaksi->metode }}</span>
        </div>
        <div class="flex justify-center">
            <span>No. Virtual Account</span>
        </div>
        <div class="flex justify-center text-4xl font-bold">
            <span>{{ $transaksi->kode_bayar }}</span>
        </div>
        <div class="flex justify-between text-lg pb-16 pt-4">
            <span>Status Pembayaran:</span>
            @if ($transaksi->status == 'pending')
            <span class="text-rose-600 font-semibold">Menunggu Pembayaran</span>
            @elseif($transaksi->status == 'settlement')
            <span class="text-rose-600 font-semibold">Pembayaran Berhasil</span>
            @else
            <span class="text-rose-600 font-semibold">Pembayaran Gagal</span>
            @endif
        </div>
    </div>
</div>

<script>
    var countDown = new Date("")
</script>

@endsection