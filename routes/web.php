<?php

Auth::routes();

// Route::get('/login', function () {
//     // return login screen
// });

Route::get('/logout-manual', function () {
    request()->session()->invalidate();
});

Route::get('/{any}', 'AppController@index')->where('any', '.*');
