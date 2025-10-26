<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function index()
    {
        // Get only kelas and mata pelajaran that the logged-in guru handles
        $kelas = Auth::user()->kelas;
        $mataPelajaran = Auth::user()->mataPelajaran;
        return view('guru.dashboard', compact('kelas', 'mataPelajaran'));
    }

    public function showAbsensi(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jam_ke' => 'required|integer|min:1|max:9',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $mataPelajaran = MataPelajaran::findOrFail($request->mata_pelajaran_id);
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();

        // Get existing absensi data for today with specific lesson hour
        $existingAbsensi = Absensi::where('mata_pelajaran_id', $request->mata_pelajaran_id)
            ->where('tanggal', now()->toDateString())
            ->where('jam_ke', $request->jam_ke)
            ->whereIn('siswa_id', $siswa->pluck('id'))
            ->get()
            ->keyBy('siswa_id');

        return view('guru.absensi', compact('kelas', 'mataPelajaran', 'siswa', 'existingAbsensi', 'request'));
    }

    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'absensi' => 'required|array',
            'absensi.*' => 'in:hadir,sakit,izin,alpa,cabut',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'jam_ke' => 'required|integer|min:1|max:9',
        ]);

        $updatedCount = 0;
        $createdCount = 0;

        foreach ($request->absensi as $siswaId => $status) {
            $existing = Absensi::where('siswa_id', $siswaId)
                ->where('tanggal', now()->toDateString())
                ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
                ->where('jam_ke', $request->jam_ke)
                ->first();

            if ($existing) {
                if ($existing->status !== $status) {
                    $existing->update(['status' => $status]);
                    $updatedCount++;
                }
            } else {
                Absensi::create([
                    'siswa_id' => $siswaId,
                    'tanggal' => now()->toDateString(),
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'jam_ke' => $request->jam_ke,
                    'user_id' => Auth::id(),
                    'status' => $status,
                ]);
                $createdCount++;
            }
        }

        $message = 'Absensi berhasil disimpan.';
        if ($updatedCount > 0 && $createdCount > 0) {
            $message = "Absensi berhasil diperbarui ({$updatedCount} diubah, {$createdCount} baru).";
        } elseif ($updatedCount > 0) {
            $message = "Absensi berhasil diperbarui ({$updatedCount} data diubah).";
        } elseif ($createdCount > 0) {
            $message = "Absensi berhasil disimpan ({$createdCount} data baru).";
        }

        return redirect()->route('guru.dashboard')->with('success', $message);
    }

    public function showProfile()
    {
        return view('guru.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data = $request->only('name', 'email');

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
