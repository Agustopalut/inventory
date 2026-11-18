@forelse ($barangmasuk as $item)
    <tr>
        <th class="text-center" scope="row">{{ $item->kd_barang_masuk }}</th>
        <td class="text-center" scope="row">
            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') }}</td>
        <td class="text-center">{{ $item->barang_master->nama_barang }}</td>
        <td class="text-center">{{ $item->jumlah }}</td>
        <td class="text-center">
            @if (strtolower($item->barang_master->satuan) == 'kg')
                {{ rtrim(rtrim(number_format($item->sisa, 2, '.', ''), '0'), '.') }}
            @else
                {{ number_format($item->sisa, 0, ',', '.') }}
            @endif
        </td>
        <td class="text-center">Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
        <td class="text-center">Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}</td>
        <td class="text-center">
            <a href="/details/barang-masuk/{{ $item->kd_barang_masuk }}" class="btn btn-primary btn-sm">Lihat</a>
            @can('update-barang-masuk')
                <a href="/update/barang-masuk/{{ $item->kd_barang_masuk }}" class="btn btn-success btn-sm">Ubah</a>
            @endcan

            @can('delete-barang-masuk')
                <form action="/delete/barang-masuk/{{ $item->kd_barang_masuk }}" class="d-inline" method="GET">
                    @csrf
                    <button type="" class="btn btn-delete btn-danger btn-sm">Hapus</button>
                </form>
            @endcan

        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">
            Data barang masuk tidak ditemukan.
        </td>
    </tr>
@endforelse
