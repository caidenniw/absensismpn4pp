<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'tanggal' => 'required|date',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $mataPelajaran = MataPelajaran::findOrFail($request->mata_pelajaran_id);
        $absensi = Absensi::with(['siswa', 'user'])
            ->whereHas('siswa', function ($query) use ($request) {
                $query->where('kelas_id', $request->kelas_id);
            })
            ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->whereDate('tanggal', $request->tanggal)
            ->get();

        $pdf = PDF::loadView('pdf.absensi', compact('absensi', 'kelas', 'mataPelajaran', 'request'));

        return $pdf->download('laporan-absensi.pdf');
    }
}
