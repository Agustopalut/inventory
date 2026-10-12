<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Data Barang Masuk</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 40px 50px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
        }

        /* Nama perusahaan */
        .header {
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 27px;
            font-weight: bold;
            color: #a80016;
            line-height: 1.1;
        }

        /* Garis */
        .garis {
            border-bottom: 1px solid #000;
            margin-bottom: 50px;
            margin-top : 20px;
        }

        /* Judul laporan */
        .judul {
            text-align: center;
            font-size: 18px;
            margin-bottom: 25px;
        }

        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 5px;
        }

        th {
            background-color: #b4c7e7;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        td {
            text-align: center;
            vertical-align: middle;
        }

        /* Lebar kolom */
        .kode {
            width: 12%;
        }

        .tanggal {
            width: 12%;
        }

        .nama {
            width: 15%;
        }

        .jumlah {
            width: 10%;
        }

        .sisa {
            width: 10%;
        }

        .harga {
            width: 13%;
        }

        .subtotal {
            width: 13%;
        }

        .satuan {
            width: 10%;
        }
    </style>
</head>

<body>

    <div class="header">
        ETTORE<br>
        GELATO
    </div>

    <div class="garis"></div>

    <div class="judul">
        Data Barang masuk
    </div>

    <table>

        <thead>
            <tr>
                <th class="kode">
                    Kd<br>
                    barang<br>
                    masuk
                </th>

                <th class="tanggal">
                    Tanggal<br>
                    masuk
                </th>

                <th class="nama">
                    Nama<br>
                    barang
                </th>

                <th class="jumlah">
                    Jumlah
                </th>

                <th class="sisa">
                    Sisa
                </th>

                <th class="harga">
                    Harga<br>
                    satuan
                </th>

                <th class="subtotal">
                    Subtotal
                </th>

                <th class="satuan">
                    Satuan
                </th>
            </tr>
        </thead>

        <tbody>

            @foreach ($barangMasuk as $item)

                <tr>
                    <td>
                        {{ $item->kd_barang_masuk }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $item->barang_master->nama_barang }}
                    </td>

                    <td>
                        {{ $item->jumlah }}
                    </td>

                    <td>
                        {{ $item->sisa }}
                    </td>

                    <td>
                        Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}
                    </td>

                    <td>
                        Rp{{ number_format($item->harga_satuan * $item->jumlah, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $item->barang_master->satuan }}
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</body>

</html>