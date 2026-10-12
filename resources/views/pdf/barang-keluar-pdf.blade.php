<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            size: A4 landscape;
            margin: 35px 40px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 27px;
            font-weight: bold;
            color: #a80016;
            line-height: 1.1;
        }

        .garis {
            border-bottom: 1px solid #777;
            margin-top: 20px;
            margin-bottom: 35px;
        }

        .tanggal-cetak {
            font-size: 12px;
            margin-bottom: 45px;
        }

        .judul {
            text-align: center;
            font-size: 17px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 5px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
        }

        th {
            background-color: #b4c7e7;
            font-size: 12px;
            font-weight: normal;
            height: 48px;
        }

        td {
            height: 30px;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <div class="header">
        ETTORE<br>
        GELATO
    </div>

    <div class="garis"></div>

    <div class="tanggal-cetak">
        Tanggal cetak: {{ now()->format('d-m-Y') }}
    </div>

    <div class="judul">
        Data Barang Keluar
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 11%;">Kd Barang Keluar</th>
                <th style="width: 10%;">Tanggal Keluar</th>
                <th style="width: 11%;">Kd Barang Masuk</th>
                <th style="width: 13%;">Nama Barang</th>
                <th style="width: 10%;">Jumlah Keluar</th>
                <th style="width: 12%;">Harga Satuan</th>
                <th style="width: 12%;">Subtotal</th>
                <th style="width: 9%;">Satuan</th>
                <th style="width: 12%;">User</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($barangKeluar as $header)

                @php
                    $details = $header->detail;
                    $jumlahDetail = $details->count();
                @endphp

                @forelse ($details as $detail)

                    @php
                        $barangMasuk = $detail->barang_masuk;
                        $barangMaster = $barangMasuk?->barang_master;

                        $jumlah = $detail->jumlah_yang_diambil ?? 0;
                        $harga = $barangMasuk->harga_satuan ?? 0;
                        $subtotal = $jumlah * $harga;
                    @endphp

                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ $jumlahDetail }}">
                                {{ $header->kd_barang_keluar }}
                            </td>

                            <td rowspan="{{ $jumlahDetail }}">
                                {{ \Carbon\Carbon::parse($header->tanggal_keluar)->format('d-m-Y') }}
                            </td>
                        @endif

                        <td>
                            {{ $barangMasuk->kd_barang_masuk ?? '-' }}
                        </td>

                        <td>
                            {{ $barangMaster->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ number_format($jumlah, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp{{ number_format($harga, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $barangMaster->satuan ?? '-' }}
                        </td>

                        @if ($loop->first)
                            <td rowspan="{{ $jumlahDetail }}">
                                {{ $header->users->name ?? '-' }}
                            </td>
                        @endif
                    </tr>

                @empty
                    <tr>
                        <td>{{ $header->kd_barang_keluar }}</td>
                        <td>{{ $header->tanggal_keluar }}</td>
                        <td colspan="6">Tidak ada detail barang</td>
                        <td>{{ $header->user->username ?? '-' }}</td>
                    </tr>
                @endforelse

            @empty
                <tr>
                    <td colspan="9">Data barang keluar tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>