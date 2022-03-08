<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\Admin\Registration\Test\UpdateRequest;
use Modules\Admission\Http\Requests\Admin\Registration\Test\AssignRequest;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class TestController extends Controller
{
		/**
		 * Instance the main property.
		 */    
		protected $repo;

		/**
		 * Create a new controller instance.
		 */
		public function __construct(AdmissionRegistrantRepository $repo)
		{
			$this->repo = $repo;
		}

		/**
		 * Index.
		 */
		public function index(Request $request)
		{
			$this->authorize('testRegistrant', AdmissionRegistrant::class);

			$admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

			$this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
				return $query->where('id', $request->get('aid'));
			});

			$registrants = $this->repo->setWhere(function($query) {
								$query->whereNotNull('verified_at');
							})
							->setLimit(request('limit', $this->repo->limit))
							->onlyTrashed(request('trash', false))
							->search(request('search', ''));

			return view('admission::admin.registration.test.index', compact('admissions', 'registrants'));
		}

		/**
		 * Show the registrant payments.
		 */
		public function show(AdmissionRegistrant $registrant)
		{
			$this->authorize('testRegistrant', $registrant);

			$registrant = $registrant->load(['user', 'tests', 'admission.tests']);
			$tests = $registrant->admission->tests;

			return view('admission::admin.registration.test.show', compact('registrant', 'tests'));
		}

		/**
		 * Update registrants test.
		 */
		public function update(AdmissionRegistrant $registrant, UpdateRequest $request)
		{
			$this->authorize('testRegistrant', $registrant);

			foreach ($request->input('test') as $test_id => $v) {
				$registrant->tests()->updateExistingPivot($test_id, [
					'value'         => $v['value'],
					'description'   => $v['description'],
					'committee_id'  => auth()->user()->admissionCommittees->first()->pivot->id ?? null,
				]);
			}

			return redirect()->back()->with(['success' => 'Sukses, nilai pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil diperbarui.']);
		}

		/**
		 * Assign tests to registrant.
		 */
		public function assign(AdmissionRegistrant $registrant, AssignRequest $request)
		{
			$this->authorize('testRegistrant', $registrant);

			if ($request->has('tests')) {
				$registrant->tests()->attach($request->input('tests'));

				return redirect()->back()
				->with(['success' => 'Sukses, tes pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil ditetapkan.']);

			}

			return redirect()->back()->with(['danger' => 'Tidak ada jenis tes yang dipilih']);
		}

		/**
		 * Mark registrant's test as passed.
		 */
		public function pass(AdmissionRegistrant $registrant, Request $request)
		{
			$this->authorize('testRegistrant', $registrant);

			$request->validate([
				'pass'      => 'boolean'
			]);

			$this->repo->update([
				'tested_at' => $request->pass ? date('Y-m-d H:i:s') : null
			], $registrant);

			return redirect()->back()
			->with(['success' => 'Sukses, status pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil diperbarui.']);
		}

		/**
		 * Printing test result letter.
		 */
		public function print(AdmissionRegistrant $registrant)
		{
			$this->authorize('testRegistrant', $registrant);

            if($registrant->tested_at) {
                $registrant = $registrant->load(['user', 'tests', 'admission.period.instance']);
    			$user = $registrant->user;
    
    			$pdf = \PDF::loadView('admission::admin.registration.test.pdf.result', compact('user', 'registrant', 'admission'))
    			            ->setPaper('a4', 'portrait');
    
    			return $pdf->stream('HASIL-TES-'.$registrant->kd.'.pdf');
            } else {
                return abort(404);
            }
		}

		/**
		 * Printing test result letter.
		 */
		public function print2(AdmissionRegistrant $registrant)
		{
			$this->authorize('testRegistrant', $registrant);

			$registrant = $registrant->load(['user', 'tests', 'admission.period.instance']);
			$user = $registrant->user;

			$pdf = \PDF::loadView('admission::admin.registration.test.pdf.result2', compact('user', 'registrant', 'admission'))
			->setPaper('a4', 'portrait');

			return $pdf->stream('HASIL-TES-'.$registrant->kd.'.pdf');
		}

		/**
		 * Printing test result letter.
		 */
		public function printQuestions(AdmissionRegistrant $registrant)
		{
			$this->authorize('testRegistrant', $registrant);

			$registrant = $registrant->load(['user', 'admission.period.instance']);
			$user = $registrant->user;

			$pdf = \PDF::loadView('admission::admin.registration.test.pdf.questions', compact('user', 'registrant', 'admission'))
			->setPaper('a4', 'portrait');

			return $pdf->stream('SOAL-TES-TULIS-'.$registrant->kd.'.pdf');
		}
	}
