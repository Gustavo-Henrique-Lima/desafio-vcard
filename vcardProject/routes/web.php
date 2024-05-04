<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\VCardController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix("contacts")->group(function () {
    Route::get("/", [VCardController::class, "view_create"]);
    Route::post('/store', [VCardController::class, 'store'])->name('vcards.store');
    Route::get('/view', [VCardController::class, 'view_contacts']);
});