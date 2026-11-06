<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\WakaController;
use App\Http\Controllers\JurnalMengajarController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\PengajuanIzinController;
use App\Http\Controllers\VerifikasiIzinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MonitoringPresensiController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\EmailVerifikasiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KesiswaanController;
use App\Http\Controllers\PeringatanJurnalController;


/*
|--------------------------------------------------------------------------
| Halaman Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.process');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| Lupa Password (OTP Email)
|--------------------------------------------------------------------------
*/

Route::get('/lupa-password', [PasswordResetController::class, 'showForgot'])
    ->name('password.forgot');

Route::post('/lupa-password', [PasswordResetController::class, 'sendOtp'])
    ->middleware('throttle:5,1')
    ->name('password.email');

Route::get('/lupa-password/otp', [PasswordResetController::class, 'showOtp'])
    ->name('password.otp');

Route::post('/lupa-password/otp', [PasswordResetController::class, 'verifyOtp'])
    ->middleware('throttle:10,1')
    ->name('password.otp.verify');

Route::post('/lupa-password/otp/kirim-ulang', [PasswordResetController::class, 'resendOtp'])
    ->middleware('throttle:5,1')
    ->name('password.otp.resend');

Route::get('/reset-password', [PasswordResetController::class, 'showReset'])
    ->name('password.reset');

Route::post('/reset-password', [PasswordResetController::class, 'reset'])
    ->name('password.update');


/*
|--------------------------------------------------------------------------
| Dashboard dan Halaman Pengguna
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Waka Kurikulum
    |--------------------------------------------------------------------------
    */

    Route::get('/waka/dashboard', [
        WakaController::class,
        'dashboard'
    ])
        ->middleware('role:1')
        ->name('waka.dashboard');

    Route::resource('/waka/master-data/kelas', KelasController::class)
        ->parameters([
            'kelas' => 'kelas'
        ])
        ->except(['show'])
        ->middleware('role:1')
        ->names('waka.master-data.kelas');

    Route::get('/waka/pengaturan', [
        WakaController::class,
        'pengaturan'
    ])
        ->middleware('role:1')
        ->name('waka.pengaturan');

    Route::put('/waka/pengaturan', [
        WakaController::class,
        'updatePengaturan'
    ])
        ->middleware('role:1')
        ->name('waka.pengaturan.update');

    Route::get('/waka/master-data', function () {
        return view('waka.master-data.index');
    })
        ->middleware('role:1')
        ->name('waka.master-data.index');

    Route::resource('/waka/master-data/ruangan', RuanganController::class)
        ->parameters([
            'ruangan' => 'ruangan'
        ])
        ->except(['show'])
        ->middleware('role:1')
        ->names('waka.master-data.ruangan');

    Route::resource('/waka/master-data/mata-pelajaran', MataPelajaranController::class)
        ->parameters([
            'mata-pelajaran' => 'mataPelajaran'
        ])
        ->except(['create', 'show'])
        ->middleware('role:1')
        ->names('waka.master-data.mata-pelajaran');

    Route::resource('/waka/master-data/akun', AkunController::class)
        ->parameters([
            'akun' => 'akun'
        ])
        ->except(['create', 'show'])
        ->middleware('role:1')
        ->names('waka.master-data.akun');

    Route::get('/waka/master-data/siswa', [SiswaController::class, 'index'])
    ->middleware('role:1')
    ->name('waka.master-data.siswa.index');

    Route::get('/waka/monitoring-jurnal', [
        \App\Http\Controllers\MonitoringJurnalController::class,
        'index'
    ])
        ->middleware('role:1')
        ->name('waka.monitoring-jurnal');

    Route::get('/waka/dashboard-alert', [
        \App\Http\Controllers\DashboardAlertController::class,
        'index'
    ])
        ->middleware('role:1')
        ->name('waka.dashboard-alert');

    Route::get('/waka/dashboard-alert/data', [
        \App\Http\Controllers\DashboardAlertController::class,
        'data'
    ])
        ->middleware('role:1')
        ->name('waka.dashboard-alert.data');


    /*
    |--------------------------------------------------------------------------
    | Profil Pengguna
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::put('/profil', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::post('/profil/email/kirim-otp', [
        EmailVerifikasiController::class,
        'kirim'
    ])
        ->middleware('throttle:5,1')
        ->name('profile.email.send');

    Route::post('/profil/email/verifikasi', [
        EmailVerifikasiController::class,
        'verifikasi'
    ])
        ->middleware('throttle:10,1')
        ->name('profile.email.verify');


    /*
    |--------------------------------------------------------------------------
    | Guru
    |--------------------------------------------------------------------------
    */

    Route::get('/guru/dashboard', [
        GuruController::class,
        'dashboard'
    ])
        ->middleware('role:2')
        ->name('guru.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Jurnal Mengajar Guru
    |--------------------------------------------------------------------------
    */

    // Potongan HTML peringatan jurnal (polling dashboard Guru & Wali Kelas)
    Route::get('/guru/peringatan-jurnal', [
        PeringatanJurnalController::class,
        'index'
    ])
        ->middleware('role:2')
        ->name('guru.peringatan-jurnal');

    Route::get('/guru/jurnal', [
        JurnalMengajarController::class,
        'index'
    ])
        ->middleware('role:2')
        ->name('guru.jurnal.index');

    Route::get('/guru/jurnal/{jadwal}/create', [
        JurnalMengajarController::class,
        'create'
    ])
        ->middleware('role:2')
        ->name('guru.jurnal.create');

    Route::post('/guru/jurnal/{jadwal}', [
        JurnalMengajarController::class,
        'store'
    ])
        ->middleware('role:2')
        ->name('guru.jurnal.store');

    
        Route::get('/guru/jurnal/{jadwal}/{jurnal}/edit', [
            JurnalMengajarController::class,
            'edit'
        ])
        ->middleware('role:2')
        ->name('guru.jurnal.edit');

        Route::put('/guru/jurnal/{jadwal}/{jurnal}', [
            JurnalMengajarController::class,
            'update'
        ])
        ->middleware('role:2')
        ->name('guru.jurnal.update');



    /*
    |--------------------------------------------------------------------------
    | Kesiswaan / Wali Kelas / Guru BK
    |--------------------------------------------------------------------------
    */

    Route::get('/kesiswaan/dashboard', [
        KesiswaanController::class,
        'dashboard'
    ])
        ->middleware('role:3,4')
        ->name('kesiswaan.dashboard');


   /*
|--------------------------------------------------------------------------
| Verifikasi Izin
|--------------------------------------------------------------------------
*/

Route::prefix('verifikasi')
    ->middleware(['auth', 'role:2,3,4'])
    ->controller(VerifikasiIzinController::class)
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('verifikasi.dashboard');
        })->name('verifikasi.dashboard');

        Route::get('/izin', 'index')
            ->name('verifikasi.izin');

        Route::post('/izin/{pengajuan}/proses', 'proses')
            ->name('verifikasi.izin.proses');

        Route::get('/riwayat', 'riwayat')
            ->name('verifikasi.riwayat');

        Route::get('/izin/{pengajuan}/dokumen', 'dokumen')
            ->name('verifikasi.izin.dokumen');
    });


    /*
    |--------------------------------------------------------------------------
    | Monitoring Presensi Guru BK
    |--------------------------------------------------------------------------
    */

    Route::get('/bk/monitoring-presensi', [
        MonitoringPresensiController::class,
        'index'
    ])
        ->middleware('role:4')
        ->name('bk.monitoring-presensi');


    /*
    |--------------------------------------------------------------------------
    | Portal Siswa
    |--------------------------------------------------------------------------
    */

    Route::get('/portal/dashboard', [
        PortalController::class,
        'dashboard'
    ])
        ->middleware('role:5')
        ->name('portal.dashboard');

    Route::get('/portal/perizinan', [
        PengajuanIzinController::class,
        'index'
    ])
        ->middleware('role:5')
        ->name('portal.perizinan.index');

    Route::get('/portal/perizinan/create', [
        PengajuanIzinController::class,
        'create'
    ])
        ->middleware('role:5')
        ->name('portal.perizinan.create');

    Route::post('/portal/perizinan', [
        PengajuanIzinController::class,
        'store'
    ])
        ->middleware('role:5')
        ->name('portal.perizinan.store');


    /*
    |--------------------------------------------------------------------------
    | Jadwal Mengajar Guru
    |--------------------------------------------------------------------------
    */

    Route::get('/guru/jadwal', [
        JadwalController::class,
        'index'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.index');

    Route::get('/guru/jadwal/create', [
        JadwalController::class,
        'create'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.create');

    Route::post('/guru/jadwal', [
        JadwalController::class,
        'store'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.store');

    Route::get('/guru/jadwal/{jadwal}/edit', [
        JadwalController::class,
        'edit'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.edit');

    Route::put('/guru/jadwal/{jadwal}', [
        JadwalController::class,
        'update'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.update');

    Route::delete('/guru/jadwal/{jadwal}', [
        JadwalController::class,
        'destroy'
    ])
        ->middleware('role:2')
        ->name('guru.jadwal.destroy');

});
