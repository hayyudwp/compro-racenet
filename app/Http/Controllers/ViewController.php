<?php

namespace App\Http\Controllers;
use App\Models\PriceList;
use App\Models\AboutRN;
use App\Models\Help;
use App\Models\Coverage;
use App\Models\Content;
use App\Models\Sosmed;
use App\Models\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
   
    public function home()
    {
        $pricelists = PriceList::orderBy(DB::raw('CAST(price as UNSIGNED)'), 'asc')->get();
        $home_content = General::where('params','home')->get();
        return view('pages.home', compact('pricelists','home_content'));
    }

    public function about()
    {
        $abouts = AboutRN::all();
        $content = Content::first();

        return view('pages.about', compact('abouts','content'));
    }

    public function coverage()
    {
        $coverages = Coverage::all();
        $defaultLocation = Coverage::first();
        return view('pages.coverage', compact('coverages','defaultLocation'));
    }


    public function contact()
    {
        
        return view('pages.contact');
    }

   
    public function help()
    {
        $panduan = Help::where('category', 'panduan')->get();
        $faq = Help::where('category', 'faq')->get();
        $pembayaran = Help::where('category', 'pembayaran')->get();
        $troubleshoot = Help::where('category', 'troubleshoot')->get();
        return view('pages.help', compact('panduan','faq','pembayaran','troubleshoot'));
    }

    public function sosmed()
    {
        $sosmed = Sosmed::all();
        return view('layouts.footer', compact('sosmed'));
    }
}
