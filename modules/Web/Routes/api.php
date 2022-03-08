<?php

Route::group(['domain' => env('APP_DOMAIN'), 'prefix' => 'search'], function () {

	Route::get('/districts', function() {

		$districts = \App\Models\References\ProvinceRegencyDistrict::with('regency.province')
		                                        ->where('name', 'like', '%'.request('q', '').'%')
		                                        ->orWhere('id', 'like', '%'.request('q', '').'%')
		                                        ->limit(10)
		                                        ->get()
		                                        ->map(function ($district, $key) {
		                                            return [
		                                                'id' => $district->id,
		                                                'text' => $district->regional
		                                            ];
		                                        });

		return response(json_encode($districts));

	})->name('api.search.districts');
	
});

;