<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\User;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('user')->latest()->paginate(10);
        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.kendaraan.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => ['required', 'exists:users,id'],
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'merek'          => ['required', 'string', 'max:255'],
            'model'          => ['required', 'string', 'max:255'],
            'tahun'          => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'plat_nomor'     => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor'],
            'jenis'          => ['required', 'in:motor,mobil'],
        ], [
            'user_id.required'        => 'Pemilik kendaraan wajib dipilih.',
            'user_id.exists'          => 'User tidak valid.',
            'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
            'merek.required'          => 'Merek wajib diisi.',
            'model.required'          => 'Model wajib diisi.',
            'tahun.required'          => 'Tahun wajib diisi.',
            'tahun.digits'            => 'Tahun harus 4 digit.',
            'tahun.min'               => 'Tahun tidak valid.',
            'tahun.max'               => 'Tahun tidak boleh melebihi tahun sekarang.',
            'plat_nomor.required'     => 'Plat nomor wajib diisi.',
            'plat_nomor.unique'       => 'Plat nomor sudah terdaftar.',
            'jenis.required'          => 'Jenis kendaraan wajib dipilih.',
        ]);

        Kendaraan::create($validated);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.kendaraan.edit', compact('kendaraan', 'users'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'user_id'        => ['required', 'exists:users,id'],
            'nama_kendaraan' => ['required', 'string', 'max:255'],
            'merek'          => ['required', 'string', 'max:255'],
            'model'          => ['required', 'string', 'max:255'],
            'tahun'          => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'plat_nomor'     => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor,' . $kendaraan->id],
            'jenis'          => ['required', 'in:motor,mobil'],
        ], [
            'user_id.required'        => 'Pemilik kendaraan wajib dipilih.',
            'nama_kendaraan.required' => 'Nama kendaraan wajib diisi.',
            'merek.required'          => 'Merek wajib diisi.',
            'model.required'          => 'Model wajib diisi.',
            'tahun.required'          => 'Tahun wajib diisi.',
            'tahun.digits'            => 'Tahun harus 4 digit.',
            'plat_nomor.required'     => 'Plat nomor wajib diisi.',
            'plat_nomor.unique'       => 'Plat nomor sudah terdaftar.',
            'jenis.required'          => 'Jenis kendaraan wajib dipilih.',
        ]);

        $kendaraan->update($validated);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}