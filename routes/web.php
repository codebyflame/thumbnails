<?php

use Statamic\Facades\Site;
use Statamic\Facades\URL;

Route::namespace('\CodeByFlame\Thumbnails\Http\Controllers\Web')
    ->name('thumbnails')
    ->group(function () {
        Route::get('thumbnails/{id}.png', 'ThumbnailsController@index');
        Route::get('thumbnails/demo', 'ThumbnailsController@demo');
        Route::get('thumbnails/demo/{text_color}/{background_color}', 'ThumbnailsController@demo');
    });
