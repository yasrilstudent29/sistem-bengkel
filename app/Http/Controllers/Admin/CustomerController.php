<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->latest()->paginate(10);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        // Hanya tampilkan user yang belum punya data customer
        $users = User::where('role', 'user')
            ->whereDoesntHave('customer')
            ->orderBy('name')
            ->get();
        return view('admin.customers.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'      => ['required', 'exists:users,id', 'unique:customers,user_id'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_pendek'  => ['nullable', 'string', 'max:100'],
            'no_telepon'   => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
            'catatan'      => ['nullable', 'string'],
        ], [
            'user_id.required'      => 'User wajib dipilih.',
            'user_id.exists'        => 'User tidak valid.',
            'user_id.unique'        => 'User ini sudah memiliki data customer.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        Customer::create($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data customer berhasil ditambahkan.');
    }

    public function edit(Customer $customer)
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        return view('admin.customers.edit', compact('customer', 'users'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_pendek'  => ['nullable', 'string', 'max:100'],
            'no_telepon'   => ['nullable', 'string', 'max:20'],
            'alamat'       => ['nullable', 'string'],
            'catatan'      => ['nullable', 'string'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
        ]);

        $customer->update($validated);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Data customer berhasil dihapus.');
    }
}