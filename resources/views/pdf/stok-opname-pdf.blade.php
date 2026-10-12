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
        Data Stok opname
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 11%;">Kd Barang Stok opname</th>
                <th style="width: 10%;">Tanggal Opname</th>
                <th style="width: 13%;">Nama Barang</th>
                <th style="width: 12%;">Stok sistem</th>
                <th style="width: 12%;">stok fisik</th>
                <th style="width: 12%;">Selisih</th>
                <th style="width: 9%;">Keterangan</th>
                <th style="width: 12%;">User</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($stokOpname as $header)

                @php
                    $details = $header->stok_opname_detail;
                    $jumlahDetail = $details->count();
                @endphp

                @forelse ($details as $detail)

                    @php
                        $barangMaster = $detail->barang_master;
                        
                    @endphp

                    <tr>
                        @if ($loop->first)
                            <td rowspan="{{ $jumlahDetail }}">
                                {{ $header->kd_opname }}
                            </td>

                            <td rowspan="{{ $jumlahDetail }}">
                                {{ \Carbon\Carbon::parse($header->tangga_opname)->format('d-m-Y') }}
                            </td>
                        @endif

                        <td>
                            {{ $barangMaster->nama_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->stok_sistem ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->stok_fisik ?? '-' }}
                        </td>

                        @if($detail->stok_fisik > $detail->stok_sistem)
                                <td>+
                            {{ $detail->stok_fisik ?? '-' }}
                        </td>
                        @else
                            <td>
                            {{ $detail->stok_fisik ?? '-' }}
                            </td>
                        @endif
                        <td>
                            Rp{{ $header->keterangan }}
                        </td>

                        @if ($loop->first)
                            <td rowspan="{{ $jumlahDetail }}">
                                {{ $header->user->name ?? '-' }}
                            </td>
                        @endif
                    </tr>

                @empty
                    <tr>
                        <td>{{ $header->kd_opname }}</td>
                        <td>{{ $header->tangga_opname }}</td>
                        <td colspan="6">Tidak ada detail barang</td>
                        <td>{{ $header->user->name ?? '-' }}</td>
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