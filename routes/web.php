<?php

Route::get('/', function () {
    return view('app');
});

Route::group(['prefix' => 'api/'], function() {
    // Sales
    Route::resource('clients', 'ClientController');
    Route::resource('quotations', 'QuotationController');

    // Inventory
    Route::resource('products', 'ProductController');
});