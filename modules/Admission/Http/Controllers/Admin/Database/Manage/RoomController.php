<?php

namespace Modules\Admission\Http\Controllers\Admin\Database\Manage;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRoom;
use Modules\Admission\Http\Requests\Admin\Database\Manage\Room\StoreRequest;
use Modules\Admission\Http\Requests\Admin\Database\Manage\Room\UpdateRequest;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class RoomController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // $this->authorize('manageAdmissions', Admission::class);
    }

    /**
     * Display administration homepage.
     */
    public function index(Request $request)
    {
        $admissions = Admission::opened()->get();
        $areas = AdmissionRoom::$sex;

        $rooms = AdmissionRoom::where('sex', $request->get('area'))
                    ->withCount('registrants')
                    ->get();

        return view('admission::admin.database.manage.rooms.index', compact('admissions', 'areas', 'rooms'));
    }

    /**
     * Register a new room.
     */
    public function create(Request $request)
    {
        $areas = AdmissionRoom::$sex;

        return view('admission::admin.database.manage.rooms.create', compact('areas'));
    }

    /**
     * Do the admission.
     */
    public function store(Request $request)
    {
        $room = new AdmissionRoom([
            'sex' => $request->input('area'),
            'name' => $request->input('name'),
            'quota' => $request->input('quota')
        ]);
        $room->save();

        return redirect($request->get('next', route('admission.admin.database.manage.rooms.index')))
                    ->with(['success' => 'Sukses, data kamar berhasil ditambahkan']);
    }

    /**
     * Edit the specified resource from storage.
     */
    public function edit(AdmissionRoom $room, Request $request)
    {
        return view('admission::admin.database.manage.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource from storage.
     */
    public function update(AdmissionRoom $room, Request $request)
    {
        $room->update([
            'name' => $request->input('name'),
            'quota' => $request->input('quota')
        ]);

        return redirect($request->get('next', route('admission.admin.database.manage.rooms.index')))
                    ->with(['success' => 'Sukses, data kamar berhasil diubah']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdmissionRoom $room)
    {
        $tmp = $room->name;
        if($room->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, <strong>'.$tmp.'</strong> telah berhasil dihapus.']);
        }
    }
}
