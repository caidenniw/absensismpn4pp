<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        // Group students by class
        $siswaPerKelas = [];
        foreach ($kelas as $k) {
            $siswaPerKelas[$k->nama_kelas] = Siswa::where('kelas_id', $k->id)->get();
        }
        return view('admin.dashboard', compact('kelas', 'mataPelajaran', 'siswaPerKelas'));
    }

    public function showSiswa()
    {
        $kelasList = Kelas::all();
        $selectedKelas = null;
        $siswa = collect(); // Empty collection
        return view('admin.siswa', compact('kelasList', 'selectedKelas', 'siswa'));
    }

    public function showSiswaByClass($id)
    {
        $selectedKelas = Kelas::findOrFail($id);
        $kelasList = Kelas::all();
        $siswa = Siswa::where('kelas_id', $id)->orderBy('nama_siswa')->get();
        return view('admin.siswa', compact('kelasList', 'selectedKelas', 'siswa'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate(['nama_kelas' => 'required|string|max:255']);
        Kelas::create($request->all());
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function storeMataPelajaran(Request $request)
    {
        $request->validate(['nama_pelajaran' => 'required|string|max:255']);
        MataPelajaran::create($request->all());
        return back()->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|integer',
            'nisn' => 'required|integer',
            'kelas_id' => 'required|exists:kelas,id',
        ]);
        Siswa::create([
            'nama_siswa' => $request->nama_siswa,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
        ]);
        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function createUser()
    {
        $kelasList = Kelas::all();
        $mataPelajaranList = MataPelajaran::all();
        return view('admin.users.create', compact('kelasList', 'mataPelajaranList'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kelas' => 'array|nullable',
            'kelas.*' => 'exists:kelas,id',
            'mata_pelajaran' => 'array|nullable',
            'mata_pelajaran.*' => 'exists:mata_pelajarans,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // Attach kelas to guru
        if ($request->has('kelas')) {
            $user->kelas()->attach($request->kelas);
        }

        // Attach mata pelajaran to guru
        if ($request->has('mata_pelajaran')) {
            $user->mataPelajaran()->attach($request->mata_pelajaran);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Guru baru berhasil ditambahkan.');
    }

    public function destroyKelas($id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $kelas->delete();
            return back()->with('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus kelas: ' . $e->getMessage());
        }
    }

    public function destroyMataPelajaran($id)
    {
        try {
            $mataPelajaran = MataPelajaran::findOrFail($id);
            $mataPelajaran->delete();
            return back()->with('success', 'Mata Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus mata pelajaran: ' . $e->getMessage());
        }
    }

    public function editSiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelasList = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    public function updateSiswa(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis' => 'required|integer|unique:siswas,nis,' . $siswa->id,
            'nisn' => 'required|integer|unique:siswas,nisn,' . $siswa->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $siswa->update([
            'nama_siswa' => $request->nama_siswa,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroySiswa($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->delete();
            return back()->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus siswa: ' . $e->getMessage());
        }
    }

    public function indexGuru()
    {
        $gurus = User::where('role', 'guru')->with('kelas', 'mataPelajaran')->get();
        return view('admin.guru.index', compact('gurus'));
    }

    public function editGuru($id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);
        $kelasList = Kelas::all();
        $mataPelajaranList = MataPelajaran::all();
        return view('admin.guru.edit', compact('guru', 'kelasList', 'mataPelajaranList'));
    }

    public function updateGuru(Request $request, $id)
    {
        $guru = User::where('role', 'guru')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $guru->id],
            'kelas' => 'array|nullable',
            'kelas.*' => 'exists:kelas,id',
            'mata_pelajaran' => 'array|nullable',
            'mata_pelajaran.*' => 'exists:mata_pelajarans,id',
        ]);

        $guru->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sync kelas
        $guru->kelas()->sync($request->kelas ?? []);

        // Sync mata pelajaran
        $guru->mataPelajaran()->sync($request->mata_pelajaran ?? []);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroyUser($id)
    {
        try {
            $user = User::findOrFail($id);
            // Prevent deleting the current admin user
            if ($user->id === Auth::id()) {
                return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }
            $user->delete();
            return back()->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus guru: ' . $e->getMessage());
        }
    }
}
