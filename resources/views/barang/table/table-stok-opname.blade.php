@forelse ($stokopname as $item)
    <tr class="text-center">
        <td>{{ $item->kd_opname }}</td>
        <td>{{ \Carbon\Carbon::parse($item->tangga_opname)->translatedFormat('d F Y') }}</td>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->stok_opname_detail_count }}</td>
        <td>
            <a href="/detail/stok-opname/{{ $item->kd_opname }}" class="btn btn-primary">Lihat</a>

            @can('delete-stok-opname')
                <form action="/delete/stok-opname/{{ $item->kd_opname }}" class="d-inline" method="POST">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
                </form>
            @endcan

        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">
            Data stok opname tidak ditemukan.
        </td>
    </tr>
@endforelse
