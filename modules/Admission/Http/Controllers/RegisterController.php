<?php

namespace Modules\Admission\Http\Controllers;

use App\Models\User;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Http\Requests\RegisterRequest;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;

use Modules\Admission\Http\Controllers\Controller;

class RegisterController extends Controller
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

        $this->middleware(function ($request, $next) {

            if (Admission::opened()->currentUser()->count()) {
                return redirect()->route('admission.home')
                                 ->with(['danger' => 'Maaf, Anda sebelumnya pernah mendaftar, silahkan lanjutkan pengisian data dibawah!']);
            }

            return $next($request);

        })->except('preparation');
    }

    /**
     * Display preparation.
     */
    public function preparation()
    {
    	return Admission::opened()->where('published', 1)->count()
                    ? view('admission::preparation')
                    : abort(404);
    }

    /**
     * Registration form.
     */
    public function register()
    {
        $admissions = Admission::with('period')->opened()->where('published', 1)->get();
        $user = auth()->user();

        if (count($admissions)) {
            return view('admission::register', compact('admissions', 'user'));
        }

        return abort(404);

    }

    /**
     * Registrate current user.
     */
    public function registrate(RegisterRequest $request)
    {
        if ($admission = Admission::opened()->where('published', 1)->find($request->input('admission_id'))) {
            $user = auth()->user();
            
            if(in_array($request->input('sex'), config('admission.closed'))) {
                return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Mohon maaf, pendaftaran untuk '.config('admission.sex-transform')[$request->input('sex')].' sementara kami tutup karena telah mencukupi kuota pendaftaran, silahkan dipantau kembali pada tanggal 15 Februari 2020 terkait pembukaan pendaftaran.']);
            }

            if ($this->repo->register($request->validated(), $user)) {
                return redirect()->route('admission.home')
                                 ->with(['success' => 'Selamat datang '.$user->profile->full_name.', silahkan lengkapi data dibawah ini untuk melanjutkan.']);
            }

            return redirect()->back()
                         ->withInput()
                         ->withErrors(['admission_id' => 'Maaf, terjadi kesalahan saat proses penyimpanan.']);

        }

        return redirect()->back()
                         ->withInput()
                         ->with(['danger' => 'Maaf, jalur pendaftaran tidak dibuka.']);
    }
}
