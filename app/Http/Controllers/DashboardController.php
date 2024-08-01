<?php

namespace App\Http\Controllers;

use App\Models\AboutRN;
use App\Models\Pricelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $data = [
            'abouts' => AboutRN::count(),
            ];

        $pricelist = Pricelist::limit(5)->orderBy('created_at','desc')->get();
        return view('pages.dashboard', compact('data','pricelist'));
    }
}
