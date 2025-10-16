<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'tanggal' => 'required|date',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);

        // Get all students in the class
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->orderBy('nama_siswa')->get();

        // Get all subjects for legend
        $mataPelajaran = MataPelajaran::orderBy('kode')->get();

        // Get all attendance records for the class and date
        $absensi = Absensi::with(['siswa', 'user', 'mataPelajaran'])
            ->whereHas('siswa', function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->whereDate('tanggal', $request->tanggal)
            ->get()
            ->groupBy(['siswa_id', 'jam_ke']);

        $pdf = PDF::loadView('pdf.absensi', compact('absensi', 'kelas', 'siswa', 'mataPelajaran', 'request'));

        return $pdf->download('laporan-absensi-' . $kelas->nama_kelas . '.pdf');
    }
}
