<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServisController;
use App\Http\Controllers\Admin\MekanikController;
use App\Http\Controllers\Admin\SparePartController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\KendaraanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KendaraanController as AdminKendaraanController;
use App\Http\Controllers\Admin\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard redirect berdasarkan role
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================================
// ADMIN ROUTES
// ================================
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', function () {
            $totalServis = \App\Models\Servis::count();
            $servisProses = \App\Models\Servis::where('status', 'proses')->count();
            $servisSelesai = \App\Models\Servis::where('status', 'selesai')->count();
            $totalMekanik = \App\Models\Mekanik::where('status', 'aktif')->count();
            $totalKendaraan = \App\Models\Kendaraan::count();
            $totalUser = \App\Models\User::where('role', 'user')->count();
            $servisTerbaru = \App\Models\Servis::with(['kendaraan.user', 'mekanik'])
                ->latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'totalServis',
                'servisProses',
                'servisSelesai',
                'totalMekanik',
                'totalKendaraan',
                'totalUser',
                'servisTerbaru'
            ));
        })->name('dashboard');

        // Manajemen Servis
        Route::resource('servis', ServisController::class)->parameters(['servis' => 'servis']);

        // Struk PDF
        Route::get('/servis/{servis}/struk', [ServisController::class, 'struk'])->name('servis.struk');

        // Update status cepat
        Route::patch('/servis/{servis}/update-status', [ServisController::class, 'updateStatus'])->name('servis.update-status');

        // Manajemen Mekanik
        Route::resource('mekanik', MekanikController::class);

        // Manajemen Spare Parts
        Route::resource('spare-parts', SparePartController::class);

        // Manajemen User & Role
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

       // Manajemen Kendaraan (Admin)
        Route::resource('kendaraan', AdminKendaraanController::class);

        // Manajemen Customer
        Route::resource('customers', CustomerController::class);
    });

// ================================
// USER ROUTES
// ================================
Route::middleware(['auth', 'verified'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        // Dashboard User
        Route::get('/dashboard', function () {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            $kendaraans = \App\Models\Kendaraan::where('user_id', auth()->id())->get();
            $servisAktif = \App\Models\Servis::whereHas('kendaraan', function ($q) {
                $q->where('user_id', auth()->id());
            })->whereIn('status', ['menunggu', 'proses'])->count();

            $riwayatServis = \App\Models\Servis::whereHas('kendaraan', function ($q) {
                $q->where('user_id', auth()->id());
            })->with(['kendaraan', 'mekanik'])->latest()->take(5)->get();

            return view('user.dashboard', compact(
                'kendaraans',
                'servisAktif',
                'riwayatServis'
            ));
        })->name('dashboard');

        // Manajemen Kendaraan
        Route::resource('kendaraan', KendaraanController::class)->except(['show']);

        // Riwayat Servis User
        Route::get('/servis', function () {
            $servis = \App\Models\Servis::whereHas('kendaraan', function ($q) {
                $q->where('user_id', auth()->id());
            })->with(['kendaraan', 'mekanik'])->latest()->paginate(10);

            return view('user.servis.index', compact('servis'));
        })->name('servis.index');

        Route::get('/servis/{servis}', function (\App\Models\Servis $servis) {
            if ($servis->kendaraan->user_id !== auth()->id()) {
                abort(403);
            }
            $servis->load(['kendaraan', 'mekanik', 'spareParts']);
            return view('user.servis.show', compact('servis'));
        })->name('servis.show');
    });

require __DIR__.'/auth.php';