@extends('layouts.admin')

@section('content')

<div class="w-full py-8">
    <div class="flex justify-between">
        <span class="text-2xl">Daftar Pesanan Masuk</span>
    </div>
    <div class="w-full border border-gray-600 rounded mt-8">
        <table class="w-full text-sm divide-y divide-gray-600">
          <thead>
            <tr class="bg-gray-50">
              <th class="px-4 py-4 font-medium text-left text-gray-900">No</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Nama Produk</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Jumlah</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap">Nama Penerima</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900">Alamat Penerima</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900">Jasa Pengiriman</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900">Estimasi Pengiriman</th>
              <th class="px-4 py-4 font-medium text-left text-gray-900 whitespace-nowrap flex justify-center">Aksi</th>
            </tr>
          </thead>
      
          <tbody class="divide-y divide-gray-600 bg-white">
            @if (isset($pesanan))
                @php
                    $no = 1;
                @endphp
                @foreach($pesanan as $item)
                <tr>
                  <td class="px-4 py-5 font-medium text-gray-900">{{ $no++ }}</td>
                  <td class="px-4 py-5 text-gray-700 whitespace-nowrap">{{ $item->pesanan->produknya->nama_produk }}</td>
                  <td class="px-4 py-5 text-gray-700 whitespace-nowrap">{{ $item->pesanan->jumlah }}</td>
                  <td class="px-4 py-5 text-gray-700 whitespace-nowrap">{{ $item->pesanan->kirimnya->nama }}</td>
                  <td class="px-4 py-5 text-gray-700">{{ $item->pesanan->kirimnya->alamat.', '.$item->pesanan->kirimnya->kota.', '.$item->pesanan->kirimnya->provinsi }}</td>
                  @php
                      $pengiriman = $item->pesanan->pengiriman;
                      if($pengiriman != null){
                        $pengiriman = explode('|', $pengiriman);
                        $jasa = strtoupper($pengiriman[0]);
                        $estimasi = strtoupper($pengiriman[1]);
                        if(!str_contains($estimasi, strtoupper('hari'))){
                          $estimasi = $estimasi.' HARI';
                        } else {
                          $estimasi = $estimasi;
                        }
                      }
                  @endphp
                  <td class="px-4 py-5 text-gray-700">{{ $jasa }}</td>
                  <td class="px-4 py-5 text-gray-700">{{ $estimasi }}</td>
                  <td class="px-4 py-5 text-gray-700 whitespace-nowrap">
                    @if ($item->status == 'settlement')
                      <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 ">Kirim</button>
                    @endif
                  </td>
                </tr>
                @endforeach
            @endif
          </tbody>
        </table>
    </div>
</div>

@endsection