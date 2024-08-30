<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Footer;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class BranchController extends Controller
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
            $data = Footer::where('category', 'branch')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("branch.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.branch.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.branch.create');
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

            // Create the Branch
            Footer::create($data);

            return redirect()->route('branch.index')->with('success', 'Created New Branch Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Branch creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the branch.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $branch)
    {
        return view('admin.branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $branch)
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
    
            // Update the Branch
            $branch->update($data);
    
            return redirect()->route('branch.index')->with('success', 'Updated Branch Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Branch update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the branch.');
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
                return response()->json(['status' => 'success', 'message' => 'Branch deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Branch not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Branch delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'Branch delete failed']);
        }
    }

}
