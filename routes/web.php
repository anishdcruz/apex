<?php

Route::get('/', 'AppController@index');

Route::post('login', 'AppController@login')
    ->middleware('guest');
Route::get('logout', 'AppController@logout')
    ->middleware('auth');

Route::get('images/{filename}', 'AppController@image')
    ->middleware('auth');

Route::group(['prefix' => 'api/', 'middleware' => ['auth', 'api']], function() {
    // Sales
    Route::resource('clients', 'ClientController');

    Route::put('quotations/{quotation}/status/{type}', 'QuotationController@markAs');
    Route::get('quotations/{quotation}/pdf', 'QuotationController@pdf');
    Route::resource('quotations', 'QuotationController');

    Route::put('sales_orders/{sales_order}/status/{type}', 'SalesOrderController@markAs');
    Route::get('sales_orders/{sales_order}/pdf', 'SalesOrderController@pdf');
    Route::resource('sales_orders', 'SalesOrderController');

    Route::put('invoices/{invoice}/status/{type}', 'InvoiceController@markAs');
    Route::get('invoices/{invoice}/pdf', 'InvoiceController@pdf');
    Route::resource('invoices', 'InvoiceController');

    Route::get('received_payments/client/{client}', 'ReceivedPaymentController@getInvoices');
    Route::get('received_payments/{received_payment}/pdf', 'ReceivedPaymentController@pdf');
    Route::resource('received_payments', 'ReceivedPaymentController');

    Route::put('deliveries/{delivery}/status/{type}', 'DeliveryController@markAs');
    Route::get('deliveries/{delivery}/pdf', 'DeliveryController@pdf');
    Route::resource('deliveries', 'DeliveryController');

    // Purchase
    Route::resource('vendors', 'VendorController');

    // Route::put('quotations/{quotation}/status/{type}', 'QuotationController@markAs');
    // Route::get('quotations/{quotation}/pdf', 'QuotationController@pdf');
    Route::resource('purchase_orders', 'PurchaseOrderController');
    Route::resource('expenses', 'ExpenseController');
    Route::resource('bills', 'BillController');

    // Inventory
    Route::get('products/search', 'ProductController@search');
    Route::resource('products', 'ProductController');

    // Accounts
    Route::get('statements/{statement}/pdf', 'StatementController@pdf');
    Route::resource('statements', 'StatementController');

    // Others
    Route::get('terms/search', 'TermController@search');
    Route::resource('terms', 'TermController');

    Route::post('settings/document', 'SettingsController@uploadDocument');
});