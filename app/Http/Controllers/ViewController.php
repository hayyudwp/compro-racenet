<?php

namespace App\Http\Controllers;
use App\Models\PriceList;
use App\Models\AboutRN;
use App\Models\Help;
use App\Models\Coverage;
use App\Models\Content;
use App\Models\Sosmed;
use App\Models\General;
use App\Models\Product;
use App\Models\ProductDetail;
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

    public function broadband()
    {
        $broadbands = Product::where('category', 'broadband')->get();

        return view('pages.broadband', compact('broadbands'));
    }

    public function dedicated()
    {
        $dedicateds = Product::where('category', 'dedicated')->get();
        $dedicated_details = ProductDetail::where('category', 'dedicated')->get();

        return view('pages.dedicated', compact('dedicated_details','dedicateds'));
    }

    public function hosting()
    {
        $hostings = Product::where('category', 'hosting')->get();
        $hosting_details = ProductDetail::where('category', 'hosting')->get();
        $colocations = Product::where('category', 'colocation')->get();
        $colocation_details = ProductDetail::where('category', 'colocation')->get();

        return view('pages.hosting-colocation', compact(
            'hosting_details',
            'hostings',
            'colocations',
            'colocation_details',
            
        ));
    }

    public function service()
    {
        $manage_services = Product::where('category', 'manage-service')->get();
        $manage_service_details = ProductDetail::where('category', 'manage-service')->get();

        return view('pages.manage-service', compact('manage_service_details','manage_services'));
    }

    public function solution()
    {
        $it_solutions = Product::where('category', 'it-solution')->get();
        $it_solution_details = ProductDetail::where('category', 'it-solution')->get();

        return view('pages.it-solution', compact('it_solution_details','it_solutions'));
    }
}
