@forelse ($barangkeluar as $item)
    <tr>
        <th class="text-center" scope="row">{{ $item->kd_barang_keluar }}</th>
        <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d F Y') }}
        </td>
        <td class="text-center">{{ $item->tujuan }}</td>
        <td class="text-center">{{ $item->users->name }}</td>
        <td class="text-center">
            <a href="/barang-keluar/{{ $item->kd_barang_keluar }}" class="btn btn-success">Lihat</a>
            @can('delete-barang-keluar')
                <form action="/delete/barang-keluar/{{ $item->kd_barang_keluar }}" class="d-inline" method="GET">
                    @csrf
                    <button type="" class="btn btn-delete btn-danger">Hapus</button>
                </form>
            @endcan
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">
            Data barang keluar tidak ditemukan.
        </td>
    </tr>
@endforelse
