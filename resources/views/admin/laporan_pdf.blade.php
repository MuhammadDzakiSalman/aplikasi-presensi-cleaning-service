<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Presensi</h1>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Tanggal</th>
                <th>Waktu Masuk</th>
                <th>Waktu Keluar</th>
                <th>Status Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedPresensi as $userId => $userDates)
                @foreach ($userDates as $tanggal => $data)
                    <tr>
                        <td>{{ $data['user']->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $data['masuk'] ? \Carbon\Carbon::parse($data['masuk']->waktu_presensi)->format('H:i') : '-' }}</td>
                        <td>{{ $data['keluar'] ? \Carbon\Carbon::parse($data['keluar']->waktu_presensi)->format('H:i') : '-' }}</td>
                        <td>
                            {{ $data['masuk'] ? $data['masuk']->status_kehadiran : '-' }}
                        </td>                        
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html>
