@forelse ($barangmaster as $barang)
    <tr>
        <th class="text-center" scope="row">{{ $loop->iteration }}</th>
        <td class="text-center">{{ $barang->nama_barang }}</td>
        <td class="text-center">{{ $barang->satuan }}</td>

        <td class="text-center">
            @if (strtolower($barang->satuan) == 'kg')
                {{ rtrim(rtrim(number_format($barang->stok, 2, '.', ''), '0'), '.') }}
            @else
                {{ number_format($barang->stok, 0, ',', '.') }}
            @endif
        </td>
        <td class="text-center">
            @can('update-barang-master')
                <a href="/update/barang-master/{{ $barang->id_barang }}" class="btn btn-sm btn-primary">Ubah</a>
            @endcan

            <a href="/details-barang-master/{{ $barang->id_barang }}" class="btn btn-sm btn-success">Lihat</a>
            @can('delete-barang-master')
                <form action="/delete/barang-master/{{ $barang->id_barang }}" method="post" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                </form>
            @endcan
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center">
            Data barang master tidak ditemukan.
        </td>
    </tr>
@endforelse
