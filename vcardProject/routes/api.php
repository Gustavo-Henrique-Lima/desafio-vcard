<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\VCardController;

Route::prefix("contacts")->group(function () {
    Route::get("/getall", [VCardController::class, "getAllContacts"]);
});