<?php

Route::get('/', function () {
    return view('app');
});

Route::group(['prefix' => 'api/'], function() {
    // Sales
    Route::resource('clients', 'ClientController');

    Route::get('quotations/{quotation}/pdf', 'QuotationController@pdf');
    Route::resource('quotations', 'QuotationController');

    Route::get('sales_orders/{sales_order}/pdf', 'SalesOrderController@pdf');
    Route::resource('sales_orders', 'SalesOrderController');

    Route::get('invoices/{invoice}/pdf', 'InvoiceController@pdf');
    Route::resource('invoices', 'InvoiceController');

    Route::resource('received_payments', 'ReceivedPaymentController');

    // Inventory
    Route::get('products/search', 'ProductController@search');
    Route::resource('products', 'ProductController');

    // Others
    Route::get('terms/search', 'TermController@search');
    Route::resource('terms', 'TermController');

    Route::get('static/header', 'StaticController@header');
});