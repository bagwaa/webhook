<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'statamic.cp.authenticated'
    ],
    'namespace' => 'Bagwaa\Webhook\Http\Controllers'
], function () {
    Route::get('/bagwaa/webhook/', 'CpController@index')->name('bagwaa-webhook.index');
    Route::post('/bagwaa/webhook/', 'CpController@update')->name('bagwaa-webhook.update');
});
