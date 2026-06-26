<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servis;
use App\Models\Kendaraan;
use App\Models\Mekanik;
use App\Models\SparePart;
use Illuminate\Http\Request;

class ServisController extends Controller
{
    public function index()
    {
        $servis = Servis::with(['kendaraan.user', 'mekanik'])
            ->latest()
            ->paginate(10);

        return view('admin.servis.index', compact('servis'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::with('user')->get();
        $mekaniks = Mekanik::where('status', 'aktif')->get();
        $spareParts = SparePart::where('stok', '>', 0)->get();

        return view('admin.servis.create', compact('kendaraans', 'mekaniks', 'spareParts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => ['required', 'exists:kendaraan,id'],
            'mekanik_id' => ['required', 'exists:mekanik,id'],
            'tanggal_masuk' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_masuk'],
            'keluhan' => ['required', 'string'],
            'catatan_mekanik' => ['nullable', 'string'],
            'status' => ['required', 'in:menunggu,proses,selesai,diambil'],
            'total_biaya' => ['required', 'numeric', 'min:0'],
            'spare_parts' => ['nullable', 'array'],
            'spare_parts.*.id' => ['exists:spare_parts,id'],
            'spare_parts.*.jumlah' => ['integer', 'min:1'],
        ], [
            'kendaraan_id.required' => 'Kendaraan wajib dipilih.',
            'kendaraan_id.exists' => 'Kendaraan tidak valid.',
            'mekanik_id.required' => 'Mekanik wajib dipilih.',
            'mekanik_id.exists' => 'Mekanik tidak valid.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'keluhan.required' => 'Keluhan wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'total_biaya.required' => 'Total biaya wajib diisi.',
            'total_biaya.min' => 'Total biaya tidak boleh negatif.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal masuk.',
        ]);

        $servis = Servis::create($validated);

        // Attach spare parts
        if ($request->has('spare_parts')) {
            foreach ($request->spare_parts as $part) {
                if (!empty($part['id']) && !empty($part['jumlah'])) {
                    $sparePart = SparePart::find($part['id']);
                    if ($sparePart) {
                        $servis->spareParts()->attach($part['id'], [
                            'jumlah' => $part['jumlah'],
                            'harga_satuan' => $sparePart->harga,
                        ]);

                        // Kurangi stok
                        $sparePart->decrement('stok', $part['jumlah']);
                    }
                }
            }
        }

        return redirect()
            ->route('admin.servis.index')
            ->with('success', 'Data servis berhasil ditambahkan.');
    }

    public function show(Servis $servis)
    {
        $servis->load(['kendaraan.user', 'mekanik', 'spareParts']);
        return view('admin.servis.show', compact('servis'));
    }

    public function edit(Servis $servis)
    {
        $kendaraans = Kendaraan::with('user')->get();
        $mekaniks = Mekanik::where('status', 'aktif')->get();
        $spareParts = SparePart::all();

        return view('admin.servis.edit', compact('servis', 'kendaraans', 'mekaniks', 'spareParts'));
    }

    public function update(Request $request, Servis $servis)
    {
        $validated = $request->validate([
            'kendaraan_id' => ['required', 'exists:kendaraan,id'],
            'mekanik_id' => ['required', 'exists:mekanik,id'],
            'tanggal_masuk' => ['required', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_masuk'],
            'keluhan' => ['required', 'string'],
            'catatan_mekanik' => ['nullable', 'string'],
            'status' => ['required', 'in:menunggu,proses,selesai,diambil'],
            'total_biaya' => ['required', 'numeric', 'min:0'],
        ], [
            'kendaraan_id.required' => 'Kendaraan wajib dipilih.',
            'mekanik_id.required' => 'Mekanik wajib dipilih.',
            'tanggal_masuk.required' => 'Tanggal masuk wajib diisi.',
            'keluhan.required' => 'Keluhan wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
            'total_biaya.required' => 'Total biaya wajib diisi.',
            'total_biaya.min' => 'Total biaya tidak boleh negatif.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal masuk.',
        ]);

        $servis->update($validated);

        return redirect()
            ->route('admin.servis.index')
            ->with('success', 'Data servis berhasil diperbarui.');
    }

    public function destroy(Servis $servis)
    {
        // Kembalikan stok spare parts
        foreach ($servis->spareParts as $part) {
            $part->increment('stok', $part->pivot->jumlah);
        }

        $servis->spareParts()->detach();
        $servis->delete();

        return redirect()
            ->route('admin.servis.index')
            ->with('success', 'Data servis berhasil dihapus.');
    }
}