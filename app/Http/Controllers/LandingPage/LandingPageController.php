<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;
use App\Models\{
    m_berita,
    m_page
};
use Illuminate\Http\Request;

class LandingPageController extends Controller {

    /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index()
    {
        $nav = "home";
        $berita_terbaru = m_berita::latest('created_at')
                          ->where('publish',1)
                          ->limit(5)
                          ->get();
        return view('landing_page.index', compact('nav','berita_terbaru'));
    }

    public function berita(Request $request , $id = null)
    {
        $search = $request->search;
        $nav = "berita";
        $berita_terbaru = m_berita::latest('created_at')
                          ->where('publish',1)
                          ->limit(5)
                          ->get();
        
        if($id==null){
            $berita = m_berita::where('publish',1)
            ->when(!is_null($search), function($query) use($search){
                $query->where('judul','like',"%".$search."%");
            })
            ->paginate(5);
            return view('landing_page.berita' , compact('nav','berita_terbaru','berita'));
        }else{
            $berita = m_berita::where('publish',1)
                            ->where('id',$id)
                            ->first();
            $berita->hits = $berita->hits+1;
            $berita->update();
            return view('landing_page.detail_berita' , compact('nav','berita_terbaru','berita'));
        }
       
    }

    public function kontak()
    {
        $nav = "kontak";
        $berita_terbaru = m_berita::latest('created_at')
                          ->where('publish',1)
                          ->limit(5)
                          ->get();
        return view('landing_page.kontak' , compact('nav','berita_terbaru'));
    }

    public function page($slug)
    {
        $nav = $slug;
        $page = m_page::where('slug', $slug)->firstOrfail();
        $berita_terbaru = m_berita::latest('created_at')
        ->where('publish',1)
        ->limit(5)
        ->get();
        
        return view('landing_page.page' , compact('page', 'nav', 'berita_terbaru'));
    }


}

?>