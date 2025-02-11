<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 ถ้ายังไม่ล็อกอิน ให้ไปหน้า Login
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::middleware(['auth'])->group(function () {
    // ✅ ผู้ใช้ทั่วไป (User)
    Route::get('/my-card', [ContactController::class, 'showMyCard'])->name('contacts.mycard');
    Route::get('/contacts/{id}', [ContactController::class, 'showContactDetails'])->name('contacts.show');
    Route::get('/contacts/{id}/download', [ContactController::class, 'downloadVCF'])->name('contact.download');
    Route::get('/e-card', [ContactController::class, 'showECard'])->name('e-card');
    
    // ✅ Admin จัดการข้อมูลได้ทุกอย่าง
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/dashboard', [ContactController::class, 'showContacts'])->name('contacts.index');
        Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
        Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
        Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
        Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
        Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get('/contacts/{id}/popup', [ContactController::class, 'showContactPopup'])->name('contacts.popup');
        Route::get('/create', [ContactController::class, 'newcreate'])->name('create');
    });
});





