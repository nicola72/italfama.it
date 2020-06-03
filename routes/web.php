<?php

//ROUTES DEL WEBSITE
Route::get('/','Website\PageController@index')->name('website.home');

Route::group(['prefix' => '{locale}','where' => ['locale' => '[a-zA-Z]{2}'],'middleware' => 'setlocale'],function(){


    //per L'autorizzazione
    Route::get('/login', 'Website\Auth\LoginController@showLoginAndRegisterForm')->name('website.login');
    Route::post('/login','Website\Auth\LoginController@login')->name('website.login');
    Route::get('/logout', 'Website\Auth\LoginController@logout')->name('website.logout');
    Route::get('/register','Website\Auth\RegisterController@showRegistrationForm')->name('website.register');
    Route::post('/register','Website\Auth\RegisterController@register');
    Route::get('/password/reset','Website\Auth\ForgotPasswordController@showLinkRequestForm')->name('website.password.request');

    Route::get('/cart','Website\CartController@index');
    Route::get('/cart/addproduct/{id}','Website\CartController@addproduct');
    Route::get('/cart/update','Website\CartController@update');
    Route::get('/cart/destroy/{id}','Website\CartController@destroy');
    Route::post('/cart/resume','Website\CartController@resume')->name('riepilogo_ordine');
    Route::post('/cart/submit','Website\CartController@submit');

    Route::post('/invia_formcontatti','Website\PageController@invia_formcontatti')->name('invia_formcontatti');
    Route::get('/{slug}','Website\PageController@page');

});






