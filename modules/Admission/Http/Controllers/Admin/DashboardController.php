<?php

namespace Modules\Admission\Http\Controllers\Admin;

use App\Models\UserProfile;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionCommitteeMember;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Controllers\Controller;

class DashboardController extends Controller
{
	/**
     * Instance the main property.
     */    
    protected $repo;

    private $colors = [
        '#e74c3c',
        '#e67e22',
        '#f1c40f',
        '#34495e',
        '#9b59b6',
        '#3498db',
        '#2ecc71',
        '#1abc9c'
    ];

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display home.
     */
    public function index()
    {
    	$this->authorize('committee', Admission::class);

        $statistics = $this->getStatistics();
        $registeredPerDay = $this->getRegisteredPerDay();
        $registrantPerSex = $this->getRegistrantPerSex();
        $testDay = $this->getTestDay();
        // $quota = $this->getQuota();
        $detailQuota = $this->getDetailQuota();
        $majors = AdmissionRegistrant::groupBy('major1')->select('major1', \DB::raw('count(*) AS total'))->get();
        $second_majors = AdmissionRegistrant::groupBy('major2')->select('major2', \DB::raw('count(*) AS total'))->get();

        // $r = AdmissionRegistrant::whereNotNull('verified_at')->whereNotNull('tested_at')->doesntHave('transactions')->whereNull('paid_off_at')->get()->toArray();
        // dd($r);

    	return view('admission::admin.dashboard', compact('statistics', 'registeredPerDay', 'registrantPerSex', 'detailQuota', 'testDay', 'majors', 'second_majors'));
    }

    /**
     * Get statistics.
     */
    public function getStatistics()
    {
        return [
            'customers.index' => [
                'title' => 'JUMLAH PENDAFTAR SELURUHNYA',
                'icon' => 'account-badge-horizontal-outline',
                'color' => 'primary',
                'data' => AdmissionRegistrant::whereHas('admission', function($admissin) { return $admissin->opened(); })->count(),
            ],
            'consumers.index' => [
                'title' => 'JUMLAH PENDAFTAR HARI INI',
                'icon' => 'ticket-outline',
                'color' => 'success',
                'data' => AdmissionRegistrant::whereHas('admission', function($admissin) { return $admissin->opened(); })->whereDate('created_at', date('Y-m-d'))->count()
            ],
            // 'items' => [
            //     'title' => 'JUMLAH PANITIA',
            //     'icon' => 'bag-personal-outline',
            //     'color' => 'danger',
            //     'data' => AdmissionCommitteeMember::whereHas('committee.admission', function($admissin) { return $admissin->opened(); })->count()
            // ],
        ];
    }

    /**
     * getQuota.
     */
    // public function getQuota()
    // {
    //     $data = [];

    //     foreach(AdmissionRoom::all()->groupBy('sex') as $idsex => $rooms) {
    //         $quota = $rooms->where('sex', $idsex)->sum('quota');
    //         $filled = AdmissionRegistrant::whereNotNull('room_id')->whereNotNull('bed')->whereHas('user.profile', function($profile) use ($idsex) { return $profile->where('sex', $idsex) ; })->count();
    //         $data[] = [
    //             'name' => config('admission.sex-transform')[$idsex],
    //             'quota' => $quota,
    //             'filled' => $filled,
    //             'rest' => $quota - $filled,
    //         ];
    //     }

    //     return $data;
    // }

    /**
     * getDetailQuota.
     */
    public function getDetailQuota()
    {
        $admissions = Admission::opened()->get();
        $data = [];

        foreach (array_keys(UserProfile::$sex) as $sex => $sexName) {
            foreach ($admissions as $a) {
                $data['Total pendaftar'][$sex] = $a->registrants()->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Terverifikasi'][$sex] = $a->registrants()->whereNotNull('verified_at')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Belum lulus tes/mengulang tes'][$sex] = $a->registrants()->whereNotNull('test_at')->whereNull('tested_at')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Lulus tes/diterima'][$sex] = $a->registrants()->whereNotNull('verified_at')->whereNotNull('tested_at')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Sudah bayar'][$sex] = $a->registrants()->whereNotNull('verified_at')->whereNotNull('tested_at')->has('transactions')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Belum lunas'][$sex] = $a->registrants()->whereNotNull('verified_at')->whereNotNull('tested_at')->has('transactions')->whereNull('paid_off_at')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
                $data['Lunas'][$sex] = $a->registrants()->whereNotNull('verified_at')->whereNotNull('tested_at')->has('transactions')->whereNotNull('paid_off_at')->whereHas('user.profile', function($profile) use ($sex) { return $profile->where('sex', $sex) ; })->count();
            }            
        }

        return $data;
    }

    /**
     * getRegistrantPerSex.
     */
    public function getRegistrantPerSex()
    {
        $admissions = Admission::with('registrants.user.profile')->opened()->get();
        $data = [];

        if(count($admissions)) {
            $sexes = UserProfile::$sex;

            foreach($admissions as $admission) {
                $count = $admission->registrants->countBy(function($registrant) {
                    return $registrant->user->profile->sex;
                });

                $sets = [];
                $color = [];
                foreach ($sexes as $k => $v) {
                    $sets[$k] = $count[$k] ?? 0;
                    $color[] = $this->colors[$k];
                }

                $data[] = [
                    'id' => $admission->id,
                    'name' => $admission->full_name,
                    'bool' => count(array_filter(array_values($sets))),
                    'value' => json_encode([
                        'labels' => array_values($sexes),
                        'datasets' => [
                            [
                                'data' => $sets,
                                'backgroundColor' => $color
                            ]
                        ]
                    ])
                ];
            }

            return $data;
        }

        return false;
    }

    /**
     * getRegisteredPerDay.
     */
    public function getRegisteredPerDay()
    {
        $admissions = Admission::with('registrants:admission_id,created_at')->opened()->get();

        if(count($admissions)) {

            $dates = [];
            for ($i = 6; $i >= 0; $i--) { 
                $dates[date('Y-m-d', strtotime('-'.$i.' days'))] = 0;
            }

            $datasets = [];
            foreach ($admissions as $i => $admission) {
                $data = $admission->registrants->countBy(function($registrant) {
                            return $registrant->created_at->format('Y-m-d');
                        });

                $data = collect($dates)->merge($data)->toArray();

                $datasets[] = [
                    'label' => $admission->full_name,
                    'fill' => false,
                    'borderColor' => $this->colors[$i],
                    'lineTension' => 0,
                    'data' => array_values($data)
                ];
            }

            return collect([
                'labels' => array_keys($dates),
                'datasets' => $datasets
            ]);
        }

        return false;
    }

    /**
     * getTestDay.
     */
    public function getTestDay()
    {
        $admissions = Admission::with(['registrants' => function($test) {
                            return $test->where('test_at', '>=', date('Y-m-d', strtotime('-1 day')))->orderBy('test_at');
                        }])->opened()->get();

        $data = [];

        foreach ($admissions as $admission) {
            $participants = $admission->registrants->where('test_at', '!=', null)->countBy(function($registrant) {
                return date('Y-m-d', strtotime($registrant->test_at));
            })->take(7);

            array_push($data, [
                'id' => $admission->id,
                'name' => $admission->full_name,
                'admission' => $admission,
                'data' => $participants
            ]);

        }

        return $data;
    }
}
