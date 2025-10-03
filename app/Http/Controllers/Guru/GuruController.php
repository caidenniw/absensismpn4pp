<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);
        $mataPelajaran = MataPelajaran::findOrFail($request->mata_pelajaran_id);
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();

        return view('guru.absensi', compact('kelas', 'mataPelajaran', 'siswa'));
    }

    public function storeAbsensi(Request $request)
    {
        $request->validate([
            'absensi' => 'required|array',
            'absensi.*' => 'in:hadir,sakit,izin',
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        ]);

        foreach ($request->absensi as $siswaId => $status) {
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => now()->toDateString(),
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                ],
                [
                    'user_id' => Auth::id(),
                    'status' => $status,
                ]
            );
        }

        return redirect()->route('guru.dashboard')->with('success', 'Absensi berhasil disimpan.');
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
            $filename = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
            $request->file('profile_picture')->move(public_path('profile_pictures'), $filename);
            $data['profile_picture'] = 'profile_pictures/' . $filename;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
