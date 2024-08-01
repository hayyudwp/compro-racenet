<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suggest;
use App\Services\LoggerService;
use Yajra\DataTables\Facades\DataTables;

class SuggestController extends Controller
{
    protected $logger;

    public function __construct(LoggerService $logger)
    {
        $this->logger = $logger;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Suggest::select('*');
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.suggest.index');
    }
    public function store(Request $request)
    {
        try {
           $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'message' => 'required',
            ]);

           $suggest = new Suggest();
           $suggest->name = $validatedData['name'];
           $suggest->email = $validatedData['email'];
           $suggest->message = $validatedData['message'];
           $suggest->save();
           
            return redirect()->route('pages.contact')->with('success', 'Created New Data Successfully.');
        } catch (\Exception $e) {
            //send to log provider
            $message = $e->getMessage();
            $this->logger->logMessage($message);

            return redirect()->back()->with('error', 'An error occurred while create the Data.');
        }
    }

}
