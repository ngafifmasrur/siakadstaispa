<?php

namespace Modules\Admission\Http\Controllers\Form;

use Modules\Admission\Http\Requests\Form\File\UploadRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class FileController extends Controller
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
     * Display view.
     */
    public function index()
    {
        $this->authorize('registration', Admission::class);

        $registrant = $this->repo->getCurrentUser();

        $files = $registrant->admission->files->load([
            'registrants' => function($query) use ($registrant) { 
                $query->where('registrant_id', $registrant->id); 
            }
        ]);

        return view('admission::form.file.index', compact('registrant', 'files'));
    }

    /**
     * Update current data.
     */
    public function upload(UploadRequest $request)
    {
        $this->authorize('registration', Admission::class);
        
        $registrant = $this->repo->getCurrentUser();

        $file = $request->file('file');
        $path = $file->store('user_files/'.$registrant->user_id.'/admissions');
        $type = $request->get('type');

        if($file = $registrant->files->where('pivot.file_id', $type)->first()) {

            \Storage::delete($file->pivot->file);

        }
        
        $registrant->files()->syncWithoutDetaching([$type => ['file' => $path]]);
        return response()->json('Sukses, berkas berhasil diunggah!', 200);

        // return response()->json('Mohon maaf, terjadi kegagalan saat penggunggahan.', 422);
    }
}
