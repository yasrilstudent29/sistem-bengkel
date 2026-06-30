<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Customer;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
    $kendaraans = Kendaraan::with('user')
        ->whereHas('user.customer')
        ->latest()
        ->paginate(10);
    return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        $customers = Customer::with('user')->orderBy('nama_lengkap')->get();
        return view('admin.kendaraan.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'merek'       => ['required', 'string', 'max:255'],
            'model'       => ['required', 'string', 'max:255'],
            'tahun'       => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'odometer'    => ['nullable', 'integer', 'min:0'],
            'warna'       => ['nullable', 'string', 'max:50'],
            'plat_nomor'  => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor'],
            'vin'         => ['nullable', 'string', 'max:30', 'unique:kendaraan,vin'],
            'jenis'       => ['required', 'in:motor,mobil'],
        ], [
            'customer_id.required' => 'Pemilik kendaraan wajib dipilih.',
            'customer_id.exists'   => 'Customer tidak valid.',
            'merek.required'       => 'Merek wajib diisi.',
            'model.required'       => 'Model wajib diisi.',
            'tahun.required'       => 'Tahun wajib diisi.',
            'tahun.digits'         => 'Tahun harus 4 digit.',
            'tahun.max'            => 'Tahun tidak boleh melebihi tahun sekarang.',
            'plat_nomor.required'  => 'Plat nomor wajib diisi.',
            'plat_nomor.unique'    => 'Plat nomor sudah terdaftar.',
            'vin.unique'           => 'VIN sudah terdaftar.',
            'jenis.required'       => 'Jenis kendaraan wajib dipilih.',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $validated['user_id'] = $customer->user_id;
        unset($validated['customer_id']);

        Kendaraan::create($validated);

        return redirect()
            ->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        $kendaraan->load('user.customer');

        $servisBerjalan = $kendaraan->servis()
            ->whereIn('status', ['menunggu', 'proses'])
            ->with('mekanik')
            ->latest()
            ->get();

        $riwayatServis = $kendaraan->servis()
            ->whereIn('status', ['selesai', 'diambil'])
            ->with('mekanik')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.kendaraan.show', compact('kendaraan', 'servisBerjalan', 'riwayatServis'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        $customers = Customer::with('user')->orderBy('nama_lengkap')->get();
        return view('admin.kendaraan.edit', compact('kendaraan', 'customers'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'merek'       => ['required', 'string', 'max:255'],
            'model'       => ['required', 'string', 'max:255'],
            'tahun'       => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'odometer'    => ['nullable', 'integer', 'min:0'],
            'warna'       => ['nullable', 'string', 'max:50'],
            'plat_nomor'  => ['required', 'string', 'max:20', 'unique:kendaraan,plat_nomor,' . $kendaraan->id],
            'vin'         => ['nullable', 'string', 'max:30', 'unique:kendaraan,vin,' . $kendaraan->id],
            'jenis'       => ['required', 'in:motor,mobil'],
        ], [
            'customer_id.required' => 'Pemilik kendaraan wajib dipilih.',
            'merek.required'       => 'Merek wajib diisi.',
            'model.required'       => 'Model wajib diisi.',
            'tahun.required'       => 'Tahun wajib diisi.',
            'tahun.digits'         => 'Tahun harus 4 digit.',
            'plat_nomor.required'  => 'Plat nomor wajib diisi.',
            'plat_nomor.unique'    => 'Plat nomor sudah terdaftar.',
            'vin.unique'           => 'VIN sudah terdaftar.',
            'jenis.required'       => 'Jenis kendaraan wajib dipilih.',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);
        $validated['user_id'] = $customer->user_id;
        unset($validated['customer_id']);

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