<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
class ContactController extends Controller
{
    //
    
    protected $logger;

    public function __construct(LoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
        if ($request->ajax()) {
            $data = Footer::where('category', 'contact')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("contact.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->editColumn('desc', function($row) {
                    return $row->desc;
                })
                ->rawColumns(['action','desc'])
                ->make(true);
        }
        return view('admin.contact.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'category' => 'required|string'
            ]);


            // Prepare data for creation
            $data = $request->only([
                'title', 
                'desc',
                'category',
            ]);
            $data['created_by'] = Auth::user()->name;

            // Create the Contact
            Footer::create($data);

            return redirect()->route('contact.index')->with('success', 'Created New Contact Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('contact creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the Contact.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $contact)
    {
        return view('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $contact)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'category' => 'required|string',
            ]);
    
            // Prepare data for update
            $data = [
                'title' => $validatedData['title'],
                'desc' => $validatedData['desc'],
                'category' => $validatedData['category'],
                'updated_by' => Auth::user()->name,
            ];
    
            // Update the Contact
            $contact->update($data);
    
            return redirect()->route('contact.index')->with('success', 'Updated Contact Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('contact update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the Contact.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->itemID;
            $record = Footer::find($id);

            if ($record) {
                $record->delete();
                return response()->json(['status' => 'success', 'message' => 'contact deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'contact not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('contact delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'contact delete failed']);
        }
    }
}
