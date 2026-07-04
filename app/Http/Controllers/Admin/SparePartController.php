<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SparePart;
use Illuminate\Http\Request;

class SparePartController extends Controller
{
    public function index()
    {
        $spareParts = SparePart::latest()->paginate(10);

        $totalItem = SparePart::count();
        $stokMenipis = SparePart::where('stok', '>', 0)->where('stok', '<=', 5)->count();
        $stokHabis = SparePart::where('stok', 0)->count();
        $nilaiInventaris = SparePart::sum(\DB::raw('stok * harga'));

        return view('admin.spare-parts.index', compact(
        'spareParts',
        'totalItem',
        'stokMenipis',
        'stokHabis',
        'nilaiInventaris'
        ));
    }

    public function create()
    {
        return view('admin.spare-parts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:spare_parts,kode'],
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
        ], [
            'nama.required' => 'Nama spare part wajib diisi.',
            'kode.required' => 'Kode spare part wajib diisi.',
            'kode.unique' => 'Kode spare part sudah digunakan.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        SparePart::create($validated);

        return redirect()
            ->route('admin.spare-parts.index')
            ->with('success', 'Spare part berhasil ditambahkan.');
    }

    public function edit(SparePart $sparePart)
    {
        return view('admin.spare-parts.edit', compact('sparePart'));
    }

    public function update(Request $request, SparePart $sparePart)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kode' => ['required', 'string', 'max:50', 'unique:spare_parts,kode,' . $sparePart->id],
            'stok' => ['required', 'integer', 'min:0'],
            'harga' => ['required', 'numeric', 'min:0'],
        ], [
            'nama.required' => 'Nama spare part wajib diisi.',
            'kode.required' => 'Kode spare part wajib diisi.',
            'kode.unique' => 'Kode spare part sudah digunakan.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.min' => 'Stok tidak boleh negatif.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.min' => 'Harga tidak boleh negatif.',
        ]);

        $sparePart->update($validated);

        return redirect()
            ->route('admin.spare-parts.index')
            ->with('success', 'Spare part berhasil diperbarui.');
    }

    public function destroy(SparePart $sparePart)
    {
        $sparePart->delete();

        return redirect()
            ->route('admin.spare-parts.index')
            ->with('success', 'Spare part berhasil dihapus.');
    }
}