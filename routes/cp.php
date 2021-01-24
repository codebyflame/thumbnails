<?php

Route::namespace('\CodeByFlame\Thumbnails\Http\Controllers\CP')
    ->prefix('thumbnails')
    ->name('thumbnails.')
    ->group(function () {
       Route::get('settings', 'ThumbnailsController@index')
           ->name('settings');
       Route::post('settings', 'ThumbnailsController@store');
    });
