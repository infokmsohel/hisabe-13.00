<?php

Route::get('/pricing', 'Modules\Superadmin\Http\Controllers\PricingController@index')->name('pricing');

Route::group(['middleware' => ['web', 'auth', 'language','FilterUser','SessionLock','AccountConfirmation'], 'prefix' => 'superadmin', 'namespace' => 'Modules\Superadmin\Http\Controllers'], function()
{
    Route::get('/install', 'InstallController@index');
    Route::get('/install/update', 'InstallController@update');

    Route::get('/', 'SuperadminController@index');
    Route::get('/stats', 'SuperadminController@stats');
    
    Route::get('/{business_id}/toggle-active/{is_active}', 'BusinessController@toggleActive');
    Route::resource('/business', 'BusinessController');
    Route::get('/business/{id}/destroy', 'BusinessController@destroy');

    Route::resource('/packages', 'PackagesController');
    Route::get('/packages/{id}/destroy', 'PackagesController@destroy');

    Route::get('/settings', 'SuperadminSettingsController@edit');
    Route::put('/settings', 'SuperadminSettingsController@update');
    Route::get('/edit-subscription/{id}', 'SuperadminSubscriptionsController@editSubscription');
    Route::post('/update-subscription', 'SuperadminSubscriptionsController@updateSubscription');
    Route::resource('/superadmin-subscription', 'SuperadminSubscriptionsController');
    Route::resource('/bank-list', 'BankListController');
    Route::resource('/business-type', 'BusinessTypeController');
    Route::resource('/business-sub-type', 'SubTypeController');
    Route::get('/bank-list/delete/{$id}', 'BankListController@deleteBank');
    Route::post('/bank-list/{$id}', 'BankListController@update');

    Route::get('/communicator', 'CommunicatorController@index');
    Route::post('/communicator/send', 'CommunicatorController@send');
    Route::get('/communicator/get-history', 'CommunicatorController@getHistory');
    
    /*
     * --------------------------------------------------------------------------------
     * SSLCOMMERZ Track Transectiopn 
     * -------------------------------------------------------------------------------- 
    */
    Route::get('trac/transaction','TrackTransectionController@TrackTransectionPageShow');
    Route::post('track-now','TrackTransectionController@ShowTrackData');
    
    
});



Route::group(['middleware' => ['web', 'SetSessionData', 'auth', 'language', 'timezone','SessionLock','AccountConfirmation'], 
    'namespace' => 'Modules\Superadmin\Http\Controllers'], function()
{
	//Routes related to paypal checkout
	Route::get('/subscription/{package_id}/paypal-express-checkout', 
		'SubscriptionController@paypalExpressCheckout');

    //Routes related to pesapal checkout
    Route::get('/subscription/{package_id}/pesapal-callback', ['as' => 'pesapalCallback', 'uses'=>'SubscriptionController@pesapalCallback']);

    Route::get('/subscription/{package_id}/pay', 'SubscriptionController@pay');
    Route::any('/subscription/{package_id}/confirm', 'SubscriptionController@confirm')->name('subscription-confirm');
    Route::get('/all-subscriptions', 'SubscriptionController@allSubscriptions');

    Route::get('/subscription/{package_id}/register-pay', 'SubscriptionController@registerPay')->name('register-pay');

    Route::resource('/subscription', 'SubscriptionController');  
    Route::get('show/subscriptionList','SubscriptionController@ShowSubscriptionList');


    /*
     * -------------------------------------------------------------------------------
     * SSLCOMMERZ Payment  Process
     * -------------------------------------------------------------------------------
    */
    
    Route::get('/payWith/{package_id}/SSl', 'PublicSslCommerzPaymentController@index');
    Route::POST('payWithSSl/success', 'PublicSslCommerzPaymentController@success');
    Route::POST('payWithSSl/fail', 'PublicSslCommerzPaymentController@fail');
    Route::POST('payWithSSl/cancel', 'PublicSslCommerzPaymentController@cancel');
    Route::POST('payWithSSl/ipn', 'PublicSslCommerzPaymentController@ipn');

    
    
});