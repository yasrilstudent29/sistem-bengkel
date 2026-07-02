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

    $isCustomerVerified = Auth::user()->customer()->exists();

    return view('user.kendaraan.index', compact('kendaraans', 'isCustomerVerified'));
    }

    public function create()
    {
        return view('user.kendaraan.create');
    }

    public function store(Request $request)
    {
    $validated = $request->validate([
        'merek'      => ['required', 'string', 'max:255'],
        'model'      => ['required', 'string', 'max:255'],
        'tahun'      => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
        'odometer'   => ['nullable', 'integer', 'min:0'],
        'warna'      => ['nullable', 'string', 'max:50'],
        'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor'],
        'vin'        => ['nullable', 'string', 'max:30', 'unique:kendaraan,vin'],
        'jenis'      => ['required', 'in:motor,mobil'],
        'foto'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ], [
        'merek.required'      => 'Merek kendaraan wajib diisi.',
        'model.required'      => 'Model kendaraan wajib diisi.',
        'tahun.required'      => 'Tahun kendaraan wajib diisi.',
        'tahun.digits'        => 'Tahun harus 4 digit.',
        'tahun.max'           => 'Tahun tidak boleh melebihi tahun sekarang.',
        'plat_nomor.required' => 'Plat nomor wajib diisi.',
        'plat_nomor.unique'   => 'Plat nomor sudah terdaftar.',
        'vin.unique'          => 'VIN sudah terdaftar.',
        'jenis.required'      => 'Jenis kendaraan wajib dipilih.',
        'foto.image'          => 'File harus berupa gambar.',
        'foto.max'            => 'Ukuran foto maksimal 2MB.',
    ]);

    $validated['user_id'] = Auth::id();

    if ($request->hasFile('foto')) {
        $validated['foto'] = $request->file('foto')->store('kendaraan', 'public');
    }

    Kendaraan::create($validated);

    return redirect()
        ->route('user.kendaraan.index')
        ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function edit(Kendaraan $kendaraan)
    {
        if ($kendaraan->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('user.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
    if ($kendaraan->user_id !== Auth::id()) {
        abort(403, 'Akses ditolak.');
    }

    $validated = $request->validate([
        'merek'      => ['required', 'string', 'max:255'],
        'model'      => ['required', 'string', 'max:255'],
        'tahun'      => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
        'odometer'   => ['nullable', 'integer', 'min:0'],
        'warna'      => ['nullable', 'string', 'max:50'],
        'plat_nomor' => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor,' . $kendaraan->id],
        'vin'        => ['nullable', 'string', 'max:30', 'unique:kendaraan,vin,' . $kendaraan->id],
        'jenis'      => ['required', 'in:motor,mobil'],
        'foto'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ], [
        'merek.required'      => 'Merek kendaraan wajib diisi.',
        'model.required'      => 'Model kendaraan wajib diisi.',
        'tahun.required'      => 'Tahun kendaraan wajib diisi.',
        'tahun.digits'        => 'Tahun harus 4 digit.',
        'plat_nomor.required' => 'Plat nomor wajib diisi.',
        'plat_nomor.unique'   => 'Plat nomor sudah terdaftar.',
        'vin.unique'          => 'VIN sudah terdaftar.',
        'jenis.required'      => 'Jenis kendaraan wajib dipilih.',
        'foto.image'          => 'File harus berupa gambar.',
        'foto.max'            => 'Ukuran foto maksimal 2MB.',
    ]);

    if ($request->hasFile('foto')) {
        if ($kendaraan->foto) {
            \Storage::disk('public')->delete($kendaraan->foto);
        }
        $validated['foto'] = $request->file('foto')->store('kendaraan', 'public');
    }

    $kendaraan->update($validated);

    return redirect()
        ->route('user.kendaraan.index')
        ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
    if ($kendaraan->user_id !== Auth::id()) {
        abort(403, 'Akses ditolak.');
    }

    if ($kendaraan->foto) {
        \Storage::disk('public')->delete($kendaraan->foto);
    }

    $kendaraan->delete();

    return redirect()
        ->route('user.kendaraan.index')
        ->with('success', 'Kendaraan berhasil dihapus.');
    }
}