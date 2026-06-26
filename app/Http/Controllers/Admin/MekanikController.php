<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mekanik;
use Illuminate\Http\Request;

class MekanikController extends Controller
{
    public function index()
    {
        $mekaniks = Mekanik::latest()->paginate(10);
        return view('admin.mekanik.index', compact('mekaniks'));
    }

    public function create()
    {
        return view('admin.mekanik.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'spesialisasi' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'nama.required' => 'Nama mekanik wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        Mekanik::create($validated);

        return redirect()
            ->route('admin.mekanik.index')
            ->with('success', 'Mekanik berhasil ditambahkan.');
    }

    public function edit(Mekanik $mekanik)
    {
        return view('admin.mekanik.edit', compact('mekanik'));
    }

    public function update(Request $request, Mekanik $mekanik)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'spesialisasi' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ], [
            'nama.required' => 'Nama mekanik wajib diisi.',
            'no_telepon.required' => 'Nomor telepon wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ]);

        $mekanik->update($validated);

        return redirect()
            ->route('admin.mekanik.index')
            ->with('success', 'Data mekanik berhasil diperbarui.');
    }

    public function destroy(Mekanik $mekanik)
    {
        $mekanik->delete();

        return redirect()
            ->route('admin.mekanik.index')
            ->with('success', 'Mekanik berhasil dihapus.');
    }
}