<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Suggest;
use App\Services\LoggerService;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use function Laravel\Prompts\suggest;


use App\Mail\SubscriptionConfirmationMail;

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
            $data = Suggest::select('name', 'email', 'message','created_at');
            return DataTables::of($data)
                ->make(true);
        }
        return view('admin.suggest.index');
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            // Simpan data ke tabel suggests
            Suggest::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'message' => $validatedData['message'],
            ]);

            // Kirim email konfirmasi
            Mail::to($validatedData['email'])->send(new SubscriptionConfirmationMail($validatedData));

            return redirect()->back()->with('success', 'Thank you for subscribing!');
        } catch (\Exception $e) {
            // Log error
            Log::error('Error sending email: ' . $e->getMessage());

            return redirect()->back()->with('error', 'There was an error processing your subscription.');
        }
    }
}
