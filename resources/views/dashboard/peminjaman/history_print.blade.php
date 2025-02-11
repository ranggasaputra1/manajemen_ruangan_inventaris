<!DOCTYPE html>
<html>

<head>
    <title>Print Riwayat Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            word-wrap: break-word;
            font-size: 10px;
            vertical-align: middle;
        }

        .table th {
            background-color: #f2f2f2;
            font-size: 9px;
        }

        /* Mengatur lebar kolom */
        .table th:nth-child(1),
        .table td:nth-child(1) {
            width: 5%;
        }

        .table th:nth-child(2),
        .table td:nth-child(2),
        .table th:nth-child(3),
        .table td:nth-child(3) {
            width: 10%;
        }

        .table th:nth-child(4),
        .table td:nth-child(4) {
            width: 15%;
        }

        .table th:nth-child(5),
        .table td:nth-child(5),
        .table th:nth-child(6),
        .table td:nth-child(6) {
            width: 15%;
        }

        .table th:nth-child(7),
        .table td:nth-child(7) {
            width: 10%;
        }

        .table th:nth-child(8),
        .table td:nth-child(8) {
            width: 10%;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .table th,
            .table td {
                font-size: 9px;
                padding: 4px;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }
        }

        /* Styling daftar agar tetap rapi */
        .list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .list li {
            margin: 2px 0;
        }

        .logo {
            width: 130px;
            height: auto;
            margin-bottom: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <!-- Menyertakan logo -->
    <div class="header">
        <img class="logo"
            src="data:image/png;base64,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" />
        <div class="container">
            <h1>Riwayat Data Peminjaman</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Peminjaman</th>
                        <th>Tgl Pengembalian</th>
                        <th>Nama Peminjam</th>
                        <th>Kode Barang</th>
                        <th>Kode Ruangan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataHistories as $peminjaman)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->tgl_peminjaman ?: '' }}</td>
                            <td>{{ $peminjaman->tgl_pengembalian ?: '' }}</td>
                            <td>{{ $peminjaman->nama_peminjam ?: '' }}</td>

                            <!-- Kolom Barang -->
                            <td>
                                @php
                                    $barangList = $peminjaman->kode_barang ? json_decode($peminjaman->kode_barang) : [];
                                    $isMultipleBarang = count($barangList) > 1;
                                @endphp
                                @if (!empty($barangList))
                                    <ul class="list">
                                        @foreach ($barangList as $barangId)
                                            <li>{{ $isMultipleBarang ? '- ' : '' }}{{ \App\Models\DataBarang::find($barangId)->nama_barang ?? '' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>

                            <!-- Kolom Ruangan -->
                            <td>
                                @php
                                    $ruanganList = $peminjaman->kode_ruangan
                                        ? json_decode($peminjaman->kode_ruangan)
                                        : [];
                                    $isMultipleRuangan = count($ruanganList) > 1;
                                @endphp
                                @if (!empty($ruanganList))
                                    <ul class="list">
                                        @foreach ($ruanganList as $ruanganId)
                                            <li>{{ $isMultipleRuangan ? '- ' : '' }}{{ \App\Models\DataRuangan::find($ruanganId)->nama_ruangan ?? '' }}
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>

                            <td>{{ $peminjaman->jumlah ?: '' }}</td>
                            <td>{{ $peminjaman->status ?: '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>

</html>
