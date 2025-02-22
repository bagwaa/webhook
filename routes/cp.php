<?php

declare(strict_types=1);

use Bagwaa\Webhook\Http\Controllers\CpController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'statamic.cp.authenticated'
    ],
    'namespace' => 'Bagwaa\Webhook\Http\Controllers'
], function () {
    Route::get('/bagwaa/webhook/', [CpController::class, 'index'])->name('bagwaa-webhook.index');
    Route::post('/bagwaa/webhook/', [CpController::class, 'update'])->name('bagwaa-webhook.save');
});
