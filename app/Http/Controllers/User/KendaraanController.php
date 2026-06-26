<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('user.kendaraan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'merek' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor'],
            'jenis' => ['required', 'in:motor,mobil'],
        ], [
            'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
            'merek.required' => 'Merek kendaraan wajib diisi.',
            'model.required' => 'Model kendaraan wajib diisi.',
            'tahun.required' => 'Tahun kendaraan wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit.',
            'tahun.min' => 'Tahun tidak valid.',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun sekarang.',
            'plat_nomor.required' => 'Plat nomor wajib diisi.',
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar.',
            'jenis.required' => 'Jenis kendaraan wajib dipilih.',
        ]);

        $validated['user_id'] = Auth::id();

        Kendaraan::create($validated);

        return redirect()
            ->route('user.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        // Pastikan user hanya bisa edit kendaraan miliknya
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('user.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        // Pastikan user hanya bisa update kendaraan miliknya
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'merek' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'tahun' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor,' . $kendaraan->id],
            'jenis' => ['required', 'in:motor,mobil'],
        ], [
            'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
            'merek.required' => 'Merek kendaraan wajib diisi.',
            'model.required' => 'Model kendaraan wajib diisi.',
            'tahun.required' => 'Tahun kendaraan wajib diisi.',
            'tahun.digits' => 'Tahun harus 4 digit.',
            'tahun.min' => 'Tahun tidak valid.',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun sekarang.',
            'plat_nomor.required' => 'Plat nomor wajib diisi.',
            'plat_nomor.unique' => 'Plat nomor sudah terdaftar.',
            'jenis.required' => 'Jenis kendaraan wajib dipilih.',
        ]);

        $kendaraan->update($validated);

        return redirect()
            ->route('user.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        // Pastikan user hanya bisa hapus kendaraan miliknya
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $kendaraan->delete();

        return redirect()
            ->route('user.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}