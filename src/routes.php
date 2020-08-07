<?php

Route::group([
    'prefix' => config('artLog.prefix'),
    'namespace' => 'ArtemiyKudin\log\Controllers',
    'middleware' => config('artLog.middleware')
], static function () {

    // Logs
    Route::group([
        'prefix' => config('artLog.routes.prefix'),
    ], static function () {
        Route::get(config('artLog.routes.url.index'), [
            'uses' => 'LogApiController@index',
            'as' => 'logs.index'
        ]);

        Route::get(config('artLog.routes.url.filters'), [
            'uses' => 'LogApiController@filters',
            'as' => 'logs.filters'
        ]);

    //    Route::get('/delete/{logID}', [
    //        'uses' => 'Logs\LogApiController@delete',
    //        'as' => 'logs.delete'
    //    ]);
    //
    //    Route::get('/delete-all', [
    //        'uses' => 'Logs\LogApiController@deleteAll',
    //        'as' => 'logs.delete.all'
    //    ]);
    });
});
