<?php

Route::group([
    'prefix' => config('artLog.prefix'),
    'namespace' => 'ArtemiyKudin\log\Controllers',
    'middleware' => config('artLog.middleware')
], static function () {

    // Logs
    Route::group([
        'prefix' => 'logs'
    ], static function () {
        Route::get('/', [
            'uses' => 'LogApiController@index',
            'as' => 'logs.index'
        ]);

        Route::get('/filters', [
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
