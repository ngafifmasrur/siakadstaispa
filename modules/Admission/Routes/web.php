<?php

use Illuminate\Support\Facades\Route;
use Modules\Admission\Http\Middleware\Registered;
use Modules\Admission\Http\Middleware\AdmissionIsOpen;
use Modules\Admission\Http\Middleware\IsAdmissionCommittee;

$domain = env('APP_DOMAIN');


Route::name('admission.')->group(function() {
	Route::get('storage/user_files/{user_id}/admissions/{file}', 'FileController@fileUser')->name('fileUser');

	Route::get('/', 'Controller@home')->name('index');

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
				Route::get('/tanggal_kedatangan', 'Form\TanggalKedatanganController@index')
                    ->name('form.tanggal_kedatangan');
				Route::put('/tanggal_kedatangan', 'Form\TanggalKedatanganController@update')
                    ->name('form.tanggal_kedatangan');
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

                // Brochure
				Route::resource('/brochure', 'BrochureController');

                // Footer Information
				Route::resource('/footer_information', 'FooterInformationController')
                    ->parameters([
                        'footer_information' => 'footerInformation',
                    ]);

				// Database
				Route::name('database.')->prefix('database')->namespace('Database')->group(function () {
					Route::name('manage.')->prefix('manage')->namespace('Manage')->middleware(AdmissionIsOpen::class)
                    ->group(function () {
						// Registrants
						Route::put('/registrants/{registrant}/restore', 'RegistrantController@restore')->name('registrants.restore');
						Route::put('/registrants/{registrant}/kill', 'RegistrantController@kill')->name('registrants.kill');
						Route::put('/registrants/{registrant}/repass', 'RegistrantController@repass')->name('registrants.repass');
						Route::put('/registrants/{registrant}/specialize', 'RegistrantController@specialize')
                            ->name('registrants.specialize');
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
						Route::put('/{registrant}', 'VerificationController@verify')
                            ->name('registration.verification.verify');
					});
					// Verification
					Route::prefix('saman')->group(function () {
						Route::get('/', 'SamanController@index')->name('registration.saman.index');
						Route::put('/{registrant}', 'SamanController@verify')->name('registration.saman.verify');
                        Route::put('/{registrant}/cancel', 'SamanController@cancel')->name('registration.saman.cancel');
						Route::get('/{registrant}/jadwal_wawancara', 'SamanController@jadwal_wawancara')
                            ->name('registration.saman.jadwal_wawancara');
						Route::put('/{registrant}/set_jadwal_wawancara', 'SamanController@set_jadwal_wawancara')
                            ->name('registration.saman.set_jadwal_wawancara');
						Route::put('/{registrant}/status_wawancara', 'SamanController@status_wawancara')
                            ->name('registration.saman.status_wawancara');

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
						Route::get('/{registrant}/print-questions', 'TestController@printQuestions')
                            ->name('registration.test.print-questions');
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
						Route::get('/{registrant}/alumni', 'AgreementController@printAgreementAlumni')
                            ->name('registration.agreement.print-alumni');
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

					Route::get('/tanggal_kedatangan/{registrant}', 'TanggalKedatanganController@index')
                        ->name('registration.tanggal_kedatangan');
					Route::put('/tanggal_kedatangan/{registrant}', 'TanggalKedatanganController@update')
                        ->name('registration.tanggal_kedatangan');
				});

				// Administration
				Route::prefix('report')->name('report.')->namespace('Report')->middleware(AdmissionIsOpen::class)
                ->group(function () {
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
});
