<?php

use Modules\Admission\Http\Middleware\IsAdmissionCommittee;
use Modules\Admission\Http\Middleware\AdmissionIsOpen;
use Modules\Admission\Http\Middleware\Registered;

$domain = env('APP_DOMAIN');

Route::name('admission.')->group(function() {
	Route::get('/', 'Controller@home')->name('index');
	
	Route::get('/xxx', function(){
	    $registrants = \Modules\Admission\Models\AdmissionRegistrant::with(['user' => function($user) { return $user->with('studies', 'father', 'mother', 'foster', 'address', 'organizations', 'achievements'); }])->whereIn('kd', ['2007-10134124', '2006-13182022', '2007-04043434', '2004-03115738', '2002-17223326', '2006-15092242', '2006-02214159', '2004-28101659', '2006-04182443', '2005-08090708', '2006-08062206', '2002-06224412', '2006-05110920', '2006-26090001', '2007-06204502', '2008-12220410', '2007-10083143', '2006-22142920', '2008-04104639', '2005-31065738', '2003-17071242', '2009-15134046', '2009-22130231', '2003-10180049', '2008-10143915', '2006-02100128', '2008-31112857', '2006-05104943', '2008-13085642', '2002-05111139', '2006-04182217', '2007-16214059', '2003-26145735', '2006-15171451', '2008-01213410', '2007-11114738', '2007-19091622', '2008-15074017', '2008-18180323', '2008-18113431', '2008-15183443', '2008-19003839', '2008-27081520', '2008-30173025', '2007-12161104', '2009-24162311', '2009-22155457', '2009-24162403', '2007-17112839', '2006-08142218', '2007-09232541', '2009-15134458', '2004-29054758', '2002-23125038', '2006-27081831', '2005-26082402', '2004-13092614', '2003-06203525', '2008-04130036', '2005-01084451', '2004-30165253', '2008-02220713', '2006-24131529', '2008-11083045', '2007-09153235', '2003-22075617', '2009-01163745', '2009-17151128', '2008-28224227', '2008-31093225', '2008-13144532', '2006-23204209', '2003-30090121', '2002-06142841', '2007-07175523', '2008-10135411', '2007-01103315', '2006-05152706', '2007-05161557', '2004-21193332', '2005-07172252', '2008-28191257', '2008-25115639', '2009-10125627', '2006-04135033', '2006-04135319', '2006-04182146', '2006-05145638', '2006-16145528', '2004-05162732', '2006-04135528', '2006-29080423', '2006-05155208', '2007-14233933', '2007-13153124', '2007-29114600', '2003-10130947', '2007-13232619', '2007-13112817', '2007-14175445', '2002-13223318', '2007-16083222', '2007-16084450', '2007-13113709', '2008-21085342', '2008-29174609', '2008-20050244', '2008-24212417', '2008-29222338', '2009-01143836', '2008-24211128', '2009-03111224', '2006-01095336', '2006-16172536', '2006-04103906', '2007-10183731', '2005-31104416', '2007-13093513', '2008-24151036', '2009-22205543', '2006-03093706', '2006-05160608', '2007-20192416', '2006-09201407', '2007-13111256', '2005-10103201', '2007-13193342', '2007-15094813', '2005-07215417', '2006-17205702', '2007-13210855', '2007-12230124', '2006-04135500', '2006-04135415', '2007-14111736', '2007-24162829', '2006-19114740', '2006-25215940', '2007-13075936', '2006-06163139', '2006-04182249', '2007-09164402', '2006-04135209', '2006-18223324', '2007-22083734', '2007-13210754', '2006-16214235', '2008-10220612', '2009-03111224', '2006-05150202', '2006-03141706', '2006-13112732', '2009-11112749', '2004-08135910', '2008-07222631', '2006-04135249'])->get();
	    return view('admission::xxx', compact('registrants'));
	});

	/*
    ** Admission homepage
    */
	Route::middleware('guest')->group(function() {

	    Route::get('/preparation', 'RegisterController@preparation')->name('preparation');

	});

	/*
    ** Dashboard homepage
    */
	Route::middleware('auth')->group(function() {

		// Preparation, Registration
		Route::get('/register', 'RegisterController@register')->name('register');
		Route::post('/register', 'RegisterController@registrate')->name('register');

		Route::group(['middleware' => Registered::class], function() {
			// Home
			Route::get('/home', 'HomeController@index')->name('home');

			// CBT
			// CBT Home
			Route::get('/cbt/{cbt_id}', 'CBTController@index')->name('cbt');
			// Selesai CBT
			Route::post('/submit_form', 'CBTController@submit_form')->name('cbt.submit_form');
			// Kirim Jawaban Soal
			Route::get('/kirimjawaban_cbt', 'CBTController@kirimjawaban')->name('cbt.kirimjawaban');
			// Update Waktu
			Route::get('/set_waktu', 'CBTController@update_waktu')->name('cbt.set_waktu');
			// Jumlah Soal Terjawab
			Route::get('/soal_terjawab', 'CBTController@soal_terjawab')->name('cbt.soal_terjawab');
			
			// Admission form
			Route::group(['prefix' => 'form'], function() {
				// Personal
				Route::get('/profile', 'Form\ProfileController@index')->name('form.profile');
				Route::put('/profile', 'Form\ProfileController@update')->name('form.profile');
				// Address
				Route::get('/email', 'Form\EmailController@index')->name('form.email');
				Route::put('/email', 'Form\EmailController@update')->name('form.email');
				// Address
				Route::get('/tanggal_kedatangan', 'Form\TanggalKedatanganController@index')->name('form.tanggal_kedatangan');
				Route::put('/tanggal_kedatangan', 'Form\TanggalKedatanganController@update')->name('form.tanggal_kedatangan');
				// Address
				Route::get('/phone', 'Form\PhoneController@index')->name('form.phone');
				Route::put('/phone', 'Form\PhoneController@update')->name('form.phone');
				// Address
				Route::get('/address', 'Form\AddressController@index')->name('form.address');
				Route::put('/address', 'Form\AddressController@update')->name('form.address');
				// Parent
				Route::get('/parent/{type}', 'Form\ParentController@index')->name('form.parent');
				Route::put('/parent/{type}', 'Form\ParentController@update')->name('form.parent');
				// User studies
				Route::resource('/studies', 'Form\StudyController', ['as' => 'form']);
				// User organizations
				Route::resource('/organizations', 'Form\OrganizationController', ['as' => 'form']);
				// User achievements
				Route::resource('/achievements', 'Form\AchievementController', ['as' => 'form']);
				// Admission file
				Route::get('/file', 'Form\FileController@index')->name('form.file');
                Route::post('/file', 'Form\FileController@upload')->name('form.file');
				// Test selection
				Route::get('/test', 'Form\TestController@index')->name('form.test');
                Route::put('/test', 'Form\TestController@update')->name('form.test');
                // Select majors
				Route::get('/major', 'Form\MajorController@index')->name('form.major');
                Route::put('/major', 'Form\MajorController@update')->name('form.major');
			});
		});
		
		// Print the result form
		Route::get('/form/{registrant}', 'HomeController@form')->name('form');
		
        // Print the result test
        Route::get('/test/result/{registrant}', 'Admin\Registration\TestController@print')->name('test.result.print');

		/* 
		** --------------------------------------------------------------------------------
		** --------------------------------------------------------------------------------
		** --------------------------------------------------------------------------------
		*/ 

		/*
	    ** Administration
	    */
		Route::name('admin.')->prefix('admin')->namespace('Admin')->group(function () {
			Route::group(['middleware' => IsAdmissionCommittee::class], function() {
				Route::redirect('/', '/admin/dashboard')->name('admin');

				// Dashboard
				Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

				// CBT
				Route::get('/cbt/{cbt}/import', 'CBTController@import')->name('cbt.import');
				Route::post('/cbt/{cbt}/import', 'CBTController@import_store')->name('cbt.import_store');
				Route::resource('/cbt', 'CBTController');
				
				// tanggal_kedatangan
				Route::resource('/tanggal_kedatangan', 'TanggalKedatanganController');

				// Database
				Route::name('database.')->prefix('database')->namespace('Database')->group(function () {
					Route::name('manage.')->prefix('manage')->namespace('Manage')->middleware(AdmissionIsOpen::class)->group(function () {
						// Registrants
						Route::put('/registrants/{registrant}/restore', 'RegistrantController@restore')->name('registrants.restore');
						Route::put('/registrants/{registrant}/kill', 'RegistrantController@kill')->name('registrants.kill');
						Route::put('/registrants/{registrant}/repass', 'RegistrantController@repass')->name('registrants.repass');
						Route::put('/registrants/{registrant}/specialize', 'RegistrantController@specialize')->name('registrants.specialize');
						Route::resource('/registrants', 'RegistrantController');
						// Rooms
						Route::resource('/rooms', 'RoomController');

						// Pilih Periode
						Route::resource('/periode', 'PeriodeController');

					});
				});

				// Administration
				Route::prefix('registration')->namespace('Registration')->middleware(AdmissionIsOpen::class)->group(function () {
					// Verification
					Route::prefix('verification')->group(function () {
						Route::get('/', 'VerificationController@index')->name('registration.verification.index');
						Route::put('/{registrant}', 'VerificationController@verify')->name('registration.verification.verify');
					});
					// Verification
					Route::prefix('saman')->group(function () {
						Route::get('/', 'SamanController@index')->name('registration.saman.index');
						Route::put('/{registrant}', 'SamanController@verify')->name('registration.saman.verify');
						Route::get('/{registrant}/jadwal_wawancara', 'SamanController@jadwal_wawancara')->name('registration.saman.jadwal_wawancara');
						Route::put('/{registrant}/set_jadwal_wawancara', 'SamanController@set_jadwal_wawancara')->name('registration.saman.set_jadwal_wawancara');
						Route::put('/{registrant}/status_wawancara', 'SamanController@status_wawancara')->name('registration.saman.status_wawancara');

					});
					// Test
					Route::prefix('test')->group(function () {
						Route::get('/', 'TestController@index')->name('registration.test.index');
						Route::get('/{registrant}', 'TestController@show')->name('registration.test.show');
						Route::put('/{registrant}/update', 'TestController@update')->name('registration.test.update');
						Route::put('/{registrant}/pass', 'TestController@pass')->name('registration.test.pass');
						Route::put('/{registrant}/assign', 'TestController@assign')->name('registration.test.assign');
						Route::get('/{registrant}/print', 'TestController@print')->name('registration.test.print');
						Route::get('/{registrant}/print2', 'TestController@print2')->name('registration.test.print2');
						Route::get('/{registrant}/print-questions', 'TestController@printQuestions')->name('registration.test.print-questions');
					});
					// Validation
					Route::prefix('validation')->group(function () {
						Route::get('/', 'ValidationController@index')->name('registration.validation.index');
						Route::put('/{registrant}', 'ValidationController@validateRegistrant')->name('registration.validation.validate');
					});
					// Agreement
					Route::prefix('agreement')->group(function () {
						Route::get('/', 'AgreementController@index')->name('registration.agreement.index');
						Route::get('/{registrant}', 'AgreementController@printAgreement')->name('registration.agreement.print');
						Route::get('/{registrant}/alumni', 'AgreementController@printAgreementAlumni')->name('registration.agreement.print-alumni');
					});
					// Payment
					Route::prefix('payment')->group(function () {
						Route::get('/', 'PaymentController@index')->name('registration.payment.index');
						Route::get('/{registrant}', 'PaymentController@show')->name('registration.payment.show');
						Route::get('/{registrant}/create', 'PaymentController@create')->name('registration.payment.create');
						Route::post('/{registrant}', 'PaymentController@store')->name('registration.payment.store');
						Route::put('/{registrant}/paid', 'PaymentController@paid')->name('registration.payment.paid');
						Route::put('/{registrant}/set', 'PaymentController@set')->name('registration.payment.set');
						Route::get('/receipt/{transaction}', 'PaymentController@receipt')->name('registration.payment.receipt');
					});
					// Enrollment
					Route::prefix('room')->group(function () {
						Route::get('/', 'RoomController@index')->name('registration.room.index');
						Route::get('/{room}', 'RoomController@show')->name('registration.room.show');
						Route::put('/{room}', 'RoomController@assign')->name('registration.room.assign');
						Route::put('/unassign/{registrant}', 'RoomController@unassign')->name('registration.room.unassign');
						Route::get('/{registrant}/print-room', 'RoomController@printRoom')->name('registration.room.print-room');
						Route::get('/{registrant}/print-card', 'RoomController@printCard')->name('registration.room.print-card');
					});
					// CBT
					Route::prefix('cbt')->group(function () {
						Route::get('/', 'CBTController@index')->name('registration.cbt.index');
						Route::get('/{registrant}', 'CBTController@show')->name('registration.cbt.show');
					});
				});

				// Administration
				Route::prefix('report')->name('report.')->namespace('Report')->middleware(AdmissionIsOpen::class)->group(function () {
					// Payments
					Route::prefix('registrants')->group(function () {
						Route::get('/', 'RegistrantController@index')->name('registrants.index');
						Route::post('/registrant', 'RegistrantController@registrants')->name('registrants.registrants');
					});
					// Payments
					Route::prefix('quotas')->group(function () {
						Route::get('/', 'QuotaController@quotas')->name('quotas.quotas');
					});
					// Payments
					Route::prefix('payments')->group(function () {
						Route::get('/', 'PaymentController@index')->name('payments.index');
						Route::post('/receipt', 'PaymentController@receipt')->name('payments.receipt');
						Route::post('/not-paid-off', 'PaymentController@notPaidOff')->name('payments.not-paid-off');
						Route::post('/per-item', 'PaymentController@perItem')->name('payments.per-item');
						Route::post('/payments', 'PaymentController@payments')->name('payments.payments');
					});
				});

				// Pengeluaran
				Route::prefix('spendings')->name('spendings.')->middleware(AdmissionIsOpen::class)->group(function () {
					Route::get('/', 'SpendingController@index')->name('index');
					Route::get('/create', 'SpendingController@create')->name('create');
					Route::post('/', 'SpendingController@store')->name('store');
					Route::get('/report', 'SpendingController@report')->name('report');
					Route::get('/{spending}/edit', 'SpendingController@edit')->name('edit');
					Route::put('/{spending}', 'SpendingController@update')->name('update');
					Route::delete('/{spending}', 'SpendingController@destroy')->name('destroy');
				});
			});
		});
    	
    });
    
    // Route::get('/zzz', function () {
    //     return dd(\App\Models\User::doesntHave('registrant')->get()->pluck('username', 'id')->toArray());
    // })->name('index');
});
    