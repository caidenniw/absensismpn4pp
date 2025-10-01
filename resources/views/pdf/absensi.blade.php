<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1>Laporan Absensi</h1>
    <p>Kelas: {{ $kelas->nama_kelas }}</p>
    <p>Mata Pelajaran: {{ $mataPelajaran->nama_pelajaran }}</p>
    <p>Tanggal: {{ \Carbon\Carbon::parse($request->tanggal)->format('d F Y') }}</p>
    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Keterangan</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensi as $absen)
            <tr>
                <td>{{ $absen->siswa->nama_siswa }}</td>
                <td>{{ $absen->siswa->nis }}</td>
                <td>{{ $absen->siswa->nisn }}</td>
                <td>{{ $absen->status }}</td>
                <td>{{ $absen->user->name }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Tidak ada data absensi untuk tanggal ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>