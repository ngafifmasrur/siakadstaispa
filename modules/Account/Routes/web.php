<?php

// $domain = config('app.domain.account');

Route::prefix('akun')->group(function() {
	Route::name('account.')->group(function() {
		/*
	    ** Authentication
	    */
		Route::namespace('Auth')->group(function() {
			
			// Guest authentication
			Route::middleware('guest')->group(function() {
			    Route::get('/login', 'LoginController@showLoginForm')->name('login');
			    Route::post('/login', 'LoginController@login')->name('login');

			    Route::get('/register', 'RegisterController@showRegisterForm')->name('register');
			    Route::post('/register', 'RegisterController@register')->name('register');

			    Route::get('/forgot', 'ForgotController@index')->name('forgot');
			    Route::post('/forgot', 'ForgotController@send')->name('forgot');

			    Route::get('/broker', 'BrokerController@index')->name('broker');
			    Route::post('/broke', 'BrokerController@broke')->name('broke');
			});

			// Logout
			Route::middleware('auth')->group(function() {	    	
	    		Route::post('/logout', 'LoginController@logout')->name('logout');
	    	});
		});

		/*
	    ** Authenticated user
	    */
		Route::middleware('auth')->group(function() {	    	
	    	// Home
			Route::redirect('/', '/home');
	    	Route::get('/home', 'Controller@home')->name('home');
	    	
	    	Route::name('user.')->namespace('User')->group(function() {
		    	// Password
		    	Route::get('/password', 'PasswordController@index')->name('password');
		    	Route::put('/password', 'PasswordController@update')->name('password');

		    	// Email address
		    	Route::get('/email', 'EmailController@index')->name('email');
		    	Route::put('/email', 'EmailController@update')->name('email');
		    	Route::get('/email/reverify', 'EmailController@reverify')->name('email.reverify');

		    	// Phone
		    	Route::get('/phone', 'PhoneController@index')->name('phone');
		    	Route::put('/phone', 'PhoneController@update')->name('phone');
	    	});
	    });

	    // Verifying email, without 'auth'
	    Route::get('/user/email/verify', 'User\EmailController@verify')->name('user.email.verify');
    });
});
