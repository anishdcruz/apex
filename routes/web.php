<?php

Route::get('/', function () {
    return view('app');
});

Route::group(['prefix' => 'api/'], function() {
    // Sales
    Route::resource('clients', 'ClientController');
    Route::resource('quotations', 'QuotationController');

    // Inventory
    Route::get('products/search', 'ProductController@search');
    Route::resource('products', 'ProductController');

    // Others
    Route::get('terms/search', 'TermController@search');
    Route::resource('terms', 'TermController');
});