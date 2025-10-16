<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi - {{ $kelas->nama_kelas }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .school-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .school-address {
            font-size: 11px;
            margin-bottom: 15px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 20px;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
        }

        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
        }

        .info-value {
            display: table-cell;
        }

        .stats-section {
            margin-bottom: 20px;
            background: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
        }

        .stats-grid {
            display: table;
            width: 100%;
        }

        .stats-item {
            display: table-cell;
            text-align: center;
            padding: 5px;
        }

        .stats-number {
            font-size: 14px;
            font-weight: bold;
            display: block;
        }

        .stats-label {
            font-size: 10px;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }

        th {
            background-color: #4CAF50;
            color: white;
            padding: 8px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #000;
        }

        td {
            padding: 6px 8px;
            border: 1px solid #000;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .status-hadir {
            background-color: #d4edda;
            color: #155724;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .status-sakit {
            background-color: #fff3cd;
            color: #856404;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .status-izin {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }

        .signature-box {
            display: table-cell;
            text-align: center;
            width: 50%;
            vertical-align: top;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 150px;
            margin: 40px auto 5px;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #666;
        }

        @page {
            margin: 1in;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <div class="school-name">SEKOLAH MENENGAH PERTAMA NEGERI 4 PADANG PANJANG</div>
        <div class="school-address">Jl. Pendidikan No. 123, Kota Pendidikan, Indonesia 12345</div>
        <div class="school-address">Telp: (021) 12345678 | Email: info@smpn4.sch.id</div>
        <div class="report-title">LAPORAN ABSENSI SISWA</div>
    </div>

    <!-- Info Section -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Kelas:</div>
            <div class="info-value">{{ $kelas->nama_kelas }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal:</div>
            <div class="info-value">{{ \Carbon\Carbon::parse($request->tanggal)->format('d F Y') }}</div>
        </div>
    </div>

    <!-- Statistics -->
    @php
    $totalSiswa = $siswa->count();
    $allAbsensi = $absensi->flatten(2);

    // Count unique students by status (latest status per student per day)
    $studentStats = [];
    foreach($allAbsensi->groupBy('siswa_id') as $siswaId => $records) {
        // Get the most recent record for this student
        $latestRecord = $records->sortByDesc('created_at')->first();
        $studentStats[$siswaId] = $latestRecord ? $latestRecord->status : null;
    }

    $hadir = collect($studentStats)->filter(function($status) {
        return $status === 'hadir';
    })->count();

    $sakit = collect($studentStats)->filter(function($status) {
        return $status === 'sakit';
    })->count();

    $izin = collect($studentStats)->filter(function($status) {
        return $status === 'izin';
    })->count();
    @endphp

    <div class="stats-section">
        <div class="stats-grid">
            <div class="stats-item">
                <span class="stats-number">{{ $totalSiswa }}</span>
                <span class="stats-label">Total Siswa</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $hadir }}</span>
                <span class="stats-label">Hadir</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $sakit }}</span>
                <span class="stats-label">Sakit</span>
            </div>
            <div class="stats-item">
                <span class="stats-number">{{ $izin }}</span>
                <span class="stats-label">Izin</span>
            </div>
        </div>
    </div>

    <!-- Daftar Kode Mata Pelajaran -->
    <div style="margin-bottom: 20px;">
        <h5 style="margin-bottom: 10px; font-size: 14px;">Daftar Kode Mata Pelajaran:</h5>
        <table style="width: 100%; border-collapse: collapse; font-size: 10px;">
            <thead>
                <tr style="background-color: #f0f0f0;">
                    <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 15%;">Kode</th>
                    <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 35%;">Mata Pelajaran</th>
                    <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 15%;">Kode</th>
                    <th style="border: 1px solid #000; padding: 4px; text-align: center; width: 35%;">Mata Pelajaran</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $mataPelajaranChunks = $mataPelajaran->chunk(2);
                @endphp
                @foreach($mataPelajaranChunks as $chunk)
                <tr>
                    @foreach($chunk as $mp)
                    <td style="border: 1px solid #000; padding: 4px; text-align: center; font-weight: bold;">{{ $mp->kode }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">{{ $mp->nama_pelajaran }}</td>
                    @endforeach
                    @if($chunk->count() == 1)
                    <td style="border: 1px solid #000; padding: 4px;"></td>
                    <td style="border: 1px solid #000; padding: 4px;"></td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Data Table -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Siswa</th>
                <th style="width: 10%;">Jam 1</th>
                <th style="width: 10%;">Jam 2</th>
                <th style="width: 10%;">Jam 3</th>
                <th style="width: 10%;">Jam 4</th>
                <th style="width: 10%;">Jam 5</th>
                <th style="width: 10%;">Jam 6</th>
                <th style="width: 10%;">Jam 7</th>
                <th style="width: 10%;">Jam 8</th>
                <th style="width: 10%;">Jam 9</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $s->nama_siswa }}</td>
                @for($jam = 1; $jam <= 9; $jam++)
                <td class="text-center">
                    @php
                        $studentAbsensi = $absensi->get($s->id, collect());
                        $jamAbsensi = $studentAbsensi->get($jam, collect())->first();
                    @endphp
                    @if($jamAbsensi)
                        <div style="font-size: 8px; margin-bottom: 2px; font-weight: bold;">
                            {{ strtoupper($jamAbsensi->mataPelajaran->kode) }}
                        </div>
                        <div style="font-size: 8px; padding: 1px 3px; border-radius: 2px; display: inline-block;
                            @if($jamAbsensi->status == 'hadir')
                                background-color: #d4edda; color: #155724;
                            @elseif($jamAbsensi->status == 'sakit')
                                background-color: #fff3cd; color: #856404;
                            @elseif($jamAbsensi->status == 'izin')
                                background-color: #d1ecf1; color: #0c5460;
                            @endif">
                            {{ ucfirst($jamAbsensi->status) }}
                        </div>
                    @else
                        -
                    @endif
                </td>
                @endfor
            </tr>
            @empty
            <tr>
                <td colspan="11" class="no-data">
                    Tidak ada siswa di kelas ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Absensi Digital SMPN 4 Padang Panjang</p>
        <!-- <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}</p>s -->
        <p>Dicetak pada: {{ now()->tz('Asia/Jakarta')->locale('id')->translatedFormat('d F Y H:i:s') }} WIB</p>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Guru Pengampu</div>
            <div style="margin-top: 40px;">
                @php
                    $firstAbsensi = $absensi->flatten(2)->first();
                    echo $firstAbsensi ? $firstAbsensi->user->name : 'N/A';
                @endphp
            </div>
        </div>
        <div class="signature-box">
            <div class="signature-line"></div>
            <div>Kepala Sekolah</div>
            <div style="margin-top: 40px;">[Nama Kepala Sekolah]</div>
        </div>
    </div>
</body>

</html>