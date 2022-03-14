<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionCBT;
use Modules\Admission\Models\Question;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\Admin\CBT\CBTRequest;
use Modules\Admission\Http\Requests\Admin\CBT\QuestionRequest;

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
    public function index(Request $request)
    {
        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        $this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
            return $query->where('id', $request->get('aid'));
        });

        $data = AdmissionCBT::when($request->get('aid'), function($q) use ($request) {
            $q->where('admission_id', $request->get('aid'));
        })->get();

        return view('admission::admin.cbt.index', compact('data', 'admissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.cbt.create', compact('admission'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CBTRequest $request)
    {
        $validated = $request->all();
        $validated['durasi'] = $request->durasi*60;
        AdmissionCBT::create($validated);

        return redirect($request->get('next', route('admission.admin.cbt.index')))
                    ->with(['success' => 'Sukses, data cbt berhasil ditambahkan']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(AdmissionCBT $cbt)
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.cbt.edit', compact('cbt', 'admission'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CBTRequest $request, AdmissionCBT $cbt)
    {
        $cbt->update($request->all());

        return redirect($request->get('next', route('admission.admin.cbt.index')))
                    ->with(['success' => 'Sukses, data cbt berhasil diedit']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(AdmissionCBT $cbt)
    {

        if($room->delete()) {
            return redirect()->back()
                        ->with(['success' => 'Sukses, data cbt telah berhasil dihapus.']);
        }
    }

    /**
     * Import page the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function import(AdmissionCBT $cbt)
    {
        $admission = $this->repo->admission = Admission::with('period')->get();

        return view('admission::admin.cbt.soal', compact('cbt', 'admission'));
    }

    /**
     * Import Store the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function import_store(Request $request, AdmissionCBT $cbt)
    {
        $request->validate([
            'file' => 'required|mimes:doc,docx',
        ]);

        $cbt_id = $cbt->id;
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($request->file('file'));
        $content = '';
        $soal = '';
        $nomor = 0;
        $isQuestion = false;
        $isOptionA = false;
        //option
        $option_1 = '';$option_2 = '';$option_3 = '';$option_4 = '';$option_5 = '';
        $judul='';$mapel='';

        $test = [];

        foreach($phpWord->getSections() as $section) {
            $newLine = false;
            foreach($section->getElements() as $element) {
                if (method_exists($element, 'getElements')) {
                    $text = '';
                    foreach($element->getElements() as $key => $childElement) {
                        if (method_exists($childElement, 'getText')) {
                            $text = $text.$childElement->getText();
                        }
                        else if (method_exists($childElement, 'getContent')) {
                            $content .= $childElement->getContent() . ' ';
                        }
                    }

                    //BEGIN - read the doc
                    if($isQuestion && substr($text,0,2) != "A."){
                        if($newLine){
                            $soal = $soal.'<br>'.$text;
                        }else{
                            $soal = $soal.$text;
                        }
                        $newLine = true;
                    }
                    
                    if(substr($text,0,2) == "Q#"){
                        $soal = '';
                        $nomor = substr($text,2);
                        $isQuestion = true;
                        $newLine = false;
                    }
                    elseif(substr($text,0,2) == "A."){
                        $isQuestion = false;
                        $option_1 = substr($text,3);
                        $isOptionA = true;
                    }
                    elseif(substr($text,0,2) == "B."){
                        $isQuestion = false;
                        $option_2 = substr($text,3);
                    }
                    elseif(substr($text,0,2) == "C."){
                        $isQuestion = false;
                        $option_3 = substr($text,3);
                        
                    }
                    elseif(substr($text,0,2) == "D."){
                        $isQuestion = false;
                        $option_4 = substr($text,3);
                    }
                    elseif(substr($text,0,2) == "E."){
                        $isQuestion = false;
                        $option_5 = substr($text,3);
                    }
                    elseif(substr($text,0,3) == "KEY"){
                        $isQuestion = false;
                        $jawaban_benar = '';
                        $kunci = trim(substr($text,11));
                        
                        switch ($kunci) {
                            case 'A':
                                $jawaban_benar = 'A';
                                break;
                            case 'B':
                                $jawaban_benar = 'B';
                                break;
                            case 'C':
                                $jawaban_benar = 'C';
                                break;
                            case 'D':
                                $jawaban_benar = 'D';
                                break;
                            case 'E':
                                $jawaban_benar = 'E';
                                break;
                            
                            default:
                                # code...
                                break;
                        }

                        Question::create([
                            'cbt_id' => $cbt_id,
                            'soal' => $soal,
                            'jawaban_a' => $option_1,
                            'jawaban_b' => $option_2,
                            'jawaban_c' => $option_3,
                            'jawaban_d' => $option_4,
                            'jawaban_e' => $option_5 ?? null,
                            'jawaban_benar' => $jawaban_benar,

                        ]);
                    }
                    //END


                }
                else if (method_exists($element, 'getText')) {
                    $content .= $element->getText() . ' ';
                }
            }
        }

        return redirect()->back()->with(['success' => 'Sukses, data soal berhasil diimport']);
    }


}
