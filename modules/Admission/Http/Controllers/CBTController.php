<?php

namespace Modules\Admission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\{
    Admission,
    AdmissionCBT,
    RegistrantCBT,
    Question,
    Answer
};
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use DB;

class CBTController extends Controller
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
     * Display a listing of the resource.
     * @return Response
     */
    public function index($cbt_id)
    {
        $registrant   = $this->repo->getCurrentUser();
        $cbt          = AdmissionCBT::findOrFail($cbt_id);
        $cbt_peserta  = RegistrantCBT::where('cbt_id', $cbt->id)
                        ->where('registrant_id', $registrant->id)
                        ->first();

        //jika pertama mengerjakan ubah statusnya menjadi 1
        if(!is_null($cbt_peserta) && $cbt_peserta->status == 0){
            RegistrantCBT::where('id', $cbt_peserta->id)->update(['status'=>1]);

        }elseif(!is_null($cbt_peserta) && $cbt_peserta->status == 2){
            return redirect()->route('admission.home');
        }
        
        if(is_null($cbt_peserta)){
            DB::transaction(function() use ($cbt, $cbt_peserta, $registrant) {
   
               $getIdpesertaUjian =  DB::table('t_registrant_cbt')->insertGetId([
                   'cbt_id' => $cbt->id,
                   'registrant_id' => $registrant->id,
                   'waktu_mulai' => now(),
                   'waktu_selesai' => null,
                   'total_skor' => 0,
                   'sisa_waktu' => $cbt->durasi,
                   'status' => 1,
               ]);

               $list_soal = Question::where('cbt_id', $cbt->id)->inRandomOrder()->get();
               foreach($list_soal as $soal) {
                    $soal_peserta [] = array(
                        'cbt_id' => $cbt->id,
                        'registrant_id' => $registrant->id,
                        'registrant_cbt_id' => $getIdpesertaUjian,
                        'question_id' => $soal->id,
                        'jawaban_benar' => $soal->jawaban_benar,
                        'jawaban_peserta' => null,
                        'status' => 0,
                        'skor' => 0,
                        'created_at'=> now(),
                        'updated_at'=> now()
                    );
               }
               
               Answer::insert($soal_peserta);
           });
      
            $cbt_peserta  = RegistrantCBT::where('cbt_id', $cbt->id)
            ->where('registrant_id', $registrant->id)
            ->first();

   
        }elseif($cbt_peserta->status == 2){
           return "sudah mengikuti ujian";
       }
   
       $q_soal = Question::
       join('t_answers','t_answers.question_id','=','ref_questions.id')
       ->where('t_answers.registrant_cbt_id', $cbt_peserta->id)
       ->select('ref_questions.*','t_answers.*','ref_questions.id as id_soal','t_answers.id as id_jawaban_peserta', 't_answers.status as status_jawaban')
       ->orderBy('t_answers.id');
   
       $dt_soal = $q_soal->get();

        return view('admission::cbt.index', compact('dt_soal', 'cbt_peserta', 'cbt'));
    }

    public function submit_form(Request $request){
        
        $total_skor    = 0;
        $jawaban_benar = Answer::where('registrant_cbt_id', $request->cbt_peserta_id)
                        ->whereColumn('jawaban_benar', 'jawaban_peserta')->count();   
        $cbt_peserta   = RegistrantCBT::where('id', $request->cbt_peserta_id)
                        ->update([
                            'status' => 2,
                            'total_skor' => $total_skor,
                            'jumlah_jawaban_benar' => $jawaban_benar,
                            'waktu_selesai' => now()
                        ]);      

        return redirect()->route('admission.home');
    }

    function soal_terjawab(Request $request){
        $jml_soal_sudah_dijawab = Answer::where('registrant_cbt_id', $request->id)->whereIn('status', [1,2])->count();
        $jml_soal_seluruhnya = Answer::where('registrant_cbt_id', $request->id)->count();

        return response()->json([
            'jml_soal_sudah_dijawab' => $jml_soal_sudah_dijawab,
            'jml_soal_seluruhnya' => $jml_soal_seluruhnya,
        ]);
    }

    public function kirimjawaban(Request $request)
    {
        $soal = Answer::where('id', $request->id_jawaban_peserta)->first();

        if (isset($soal)) {
            $soal->update([
                'jawaban_peserta' => $request->jawaban_peserta,
                'status' => 1
            ]);
        }

        return response()->json([   'data' => $request->all()   ]);
    }

    function update_waktu(Request $request){
        $cbt_peserta = RegistrantCBT::where('id', $request->id)
                        ->update(['sisa_waktu' => $request->waktu]);

        return response()->json(['status'=> 'Updated']);
    }

    function sisa_waktu(Request $request){
        $data = RegistrantCBT::where('id', $request->id)
                        ->pluck('sisa_waktu')->first();
        return response()->json($data);
    }
}
