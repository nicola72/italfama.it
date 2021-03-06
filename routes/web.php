<?php

//ROUTES DEL WEBSITE
Route::get('/','Website\PageController@index')->name('website.home');

Route::group(['prefix' => '{locale}','where' => ['locale' => '[a-zA-Z]{2}'],'middleware' => 'setlocale'],function(){

    Route::get('/home', 'Website\PageController@index');
    Route::get('/azienda', 'Website\PageController@azienda');
    Route::get('/dove_siamo', 'Website\PageController@dove_siamo');
    Route::get('/contatti', 'Website\PageController@contatti');
    Route::get('/cataloghi', 'Website\PageController@cataloghi');
    Route::get('/categoria/{id}', 'Website\PageController@categoryPage');
    Route::get('/macrocategoria/{id}', 'Website\PageController@macrocategoryPage');
    Route::get('/prodotto/{id}', 'Website\PageController@productPage');
    Route::get('/pairing/{id}', 'Website\PageController@pairingPage');
    Route::get('/tutti_prodotti', 'Website\PageController@tutti_prodotti');
    Route::post('/ricerca','Website\PageController@ricerca');

    //per L'autorizzazione
    Route::get('/login', 'Website\Auth\LoginController@showLoginAndRegisterForm')->name('website.login');
    Route::post('/login','Website\Auth\LoginController@login')->name('website.login');
    Route::get('/logout', 'Website\Auth\LoginController@logout')->name('website.logout');
    Route::post('/register','Website\Auth\RegisterController@register');

    Route::get('/cart','Website\CartController@index');
    Route::get('/cart/addproduct/{id}','Website\CartController@addproduct');
    Route::get('/cart/addpairing/{id}','Website\CartController@addpairing');
    Route::get('/cart/update','Website\CartController@update');
    Route::get('/cart/destroy/{id}','Website\CartController@destroy');
    Route::get('/cart/checkout','Website\CartController@checkout');
    Route::get('/cart/risposta_checkout/{id}','Website\CartController@risposta_checkout')->name('website.risposta_checkout');

    Route::get('/order','Website\OrderController@index');
    Route::get('/order/print/{id}','Website\OrderController@print');

    Route::post('/invia_formcontatti','Website\PageController@invia_formcontatti')->name('invia_formcontatti');
    Route::post('/invia_forminformazioni','Website\PageController@invia_forminformazioni')->name('invia_forminformazioni');

});






