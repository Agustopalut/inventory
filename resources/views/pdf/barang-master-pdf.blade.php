<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 40px 60px;
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
            border-bottom: 1px solid #000;
            margin-bottom: 18px;
            margin-top:20px;
        }

        .judul {
            text-align: center;
            font-size: 17px;
            margin-bottom: 14px;
        }

        table {
            width: 85%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 3px 6px;
        }

        th {
            background-color: #b4c7e7;
            text-align: center;
            font-weight: bold;
        }

        td {
            text-align: center;
        }

        td.nama {
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- Nama perusahaan --}}
    <div class="header">
        ETTORE<br>
        GELATO
    </div>

    {{-- Garis --}}
    <div class="garis"></div>

    {{-- Judul --}}
    <div class="judul">
        Data Barang Master
    </div>

    {{-- Tabel --}}
    <table>
        <thead>
            <tr>
                <th width="10%">No</th>
                <th width="40%">Nama Barang</th>
                <th width="25%">Stok</th>
                <th width="25%">Satuan</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($barang as $item)

                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td class="nama">
                        {{ $item->nama_barang }}
                    </td>

                    <td>
                        {{ $item->stok }}
                    </td>

                    <td>
                        {{ $item->satuan }}
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

</body>
</html>