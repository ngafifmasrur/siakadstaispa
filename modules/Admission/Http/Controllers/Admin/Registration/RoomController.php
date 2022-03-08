<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionRoom;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class RoomController extends Controller
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
        $this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);

        $admissions = Admission::opened()->get();
        $areas = AdmissionRoom::$sex;

        $rooms = AdmissionRoom::withCount('registrants')
                        ->where('sex', $request->get('area'))
                        ->get();;

        return view('admission::admin.registration.room.index', compact('areas', 'admissions', 'rooms'));
    }

    /**
     * Show.
     */
    public function show(AdmissionRoom $room, Request $request)
    {
        $this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);
        
        $room->load('registrants.user.profile');

        $registrants = AdmissionRegistrant::where(function($query) {
                                                $query->whereNotNull('verified_at');
                                                $query->whereNotNull('tested_at');
                                                // $query->whereNotNull('validated_at');
                                                $query->whereNotNull('accepted_at');
                                                $query->whereNull('room_id');
                                                $query->whereNull('bed');
                                            })
                                            ->whereHas('admission', function($admission) {
                                                return $admission->opened()->whereIn('id', auth()->user()->admissionCommittees->load('admission')->pluck('admission.id'));
                                            })
                                            ->get();

        return view('admission::admin.registration.room.show', compact('room', 'registrants'));
    }

    /**
     * Mark registrant as accepted.
     */
    public function assign(AdmissionRoom $room, Request $request)
    {
        $this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);
        
        $request->validate([
            'bed'      => 'required|numeric|max:'.$room->quota,
            'registrant' => 'required|exists:admission_registrants,id',
            'shirt' => 'required'
        ]);

        $registrant = AdmissionRegistrant::find($request->input('registrant'));

        $registrant->update([
            'room_id' => $room->id,
            'bed' => $request->input('bed'),
            'shirt' => $request->input('shirt'),
        ]);
        
        return redirect()->back()
                    ->with(['success' => 'Sukses, kamar calon mahasiswa atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil ditetapkan.']);
    }

    /**
     * Mark registrant unassign.
     */
    public function unassign(AdmissionRegistrant $registrant, Request $request)
    {
        $this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);
        
        $registrant->update([
            'room_id' => null,
            'bed' => null,
        ]);
        
        return redirect()->back()
                    ->with(['success' => 'Sukses, status huni calon mahasiswa atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil dihapus.']);
    }
    

	/**
	 * Printing test result letter.
	 */
	public function printRoom(AdmissionRegistrant $registrant)
	{
		$this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);

		$registrant = $registrant->load(['user', 'admission.period.instance']);
		$user = $registrant->user;

		$pdf = \PDF::loadView('admission::admin.registration.room.pdf.room', compact('user', 'registrant', 'admission'))
		->setPaper('a5', 'portrait');

		return $pdf->stream('KARTU-KAMAR-'.$registrant->kd.'.pdf');
	}
    

	/**
	 * Printing test result letter.
	 */
	public function printCard(AdmissionRegistrant $registrant)
	{
		$this->authorize('giveRoomRegistrant', AdmissionRegistrant::class);

		$registrant = $registrant->load(['user', 'admission.period.instance']);
		$user = $registrant->user;

		$pdf = \PDF::loadView('admission::admin.registration.room.pdf.card', compact('user', 'registrant', 'admission'))
		->setPaper([0, 0, 151.937007874, 242.362204724], 'landscape');

		return $pdf->stream('KTS-'.$registrant->kd.'.pdf');
	}
}
