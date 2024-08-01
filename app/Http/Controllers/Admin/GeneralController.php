<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeneralController extends Controller
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
            $data = General::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("homecontent.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->addColumn('value_file', function ($row) {
                    // Assuming 'value_file' is the field containing the image path or URL
                    $imagePath = $row->value_file;
                    $imgTag = '<img src="' . asset('storage/home/' . $imagePath) . '" alt="Header Image" width="100%" height="auto">';
                    return $imgTag;
                })
                ->rawColumns(['action', 'value_file'])
                ->make(true);
        }
        return view('admin.homecontent.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.homecontent.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'params' => 'required|string',
                'value' => 'required|string|max:255',
                'value_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Initialize imageName variable
            $imageName = null;

            // Handle image upload
            if ($request->hasFile('value_file')) {
                $image = $request->file('value_file');
                $imageName = time() . '-' . Str::slug($request->params, '-') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/home', $imageName);
            }

            // Prepare data for creation
            $data = $request->only(['params', 'value']);
            $data['created_by'] = Auth::user()->name;
            $data['value_file'] = $imageName;

            // Create the header
            General::create($data);

            return redirect()->route('homecontent.index')->with('success', 'Created New Home Content Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Home Content creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the homecontent.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(General $homecontent)
    {
        return view('admin.homecontent.edit', compact('homecontent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, General $homecontent)
    {
        try {
            // Validate the request data
            $request->validate([
                'params' => 'required|string',
                'value' => 'required|string|max:255',
                'value_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Making image nullable for updates
            ]);

            // Handle image upload
            if ($request->hasFile('value_file')) {
                $image = $request->file('value_file');
                $imageName = time() . '-' . Str::slug($request->params, '-') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/home', $imageName);

                // Debugging: Log the image name and path
                Log::info('Image Name: ' . $imageName);
                Log::info('Storage Path: ' . storage_path('app/public/home'));

                // Delete the old image if it exists
                if ($homecontent->value_file && Storage::exists('public/home/' . $homecontent->value_file)) {
                    Storage::delete('public/home/' . $homecontent->value_file);
                }

                // Update the image path in the Home Content
                $homecontent->value_file = $imageName;
            }

            // Prepare data for update
            $data = $request->except('value_file');
            $data['updated_by'] = Auth::user()->name;

            // Update the Home Content
            $homecontent->update($data);

            return redirect()->route('homecontent.index')->with('success', 'Updated Home Content Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Home Content update error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the homecontent.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->itemID;
            $record = General::find($id);

            if ($record) {
                if ($record->value_file && Storage::exists('public/home/' . $record->value_file)) {
                    Storage::delete('public/home/' . $record->value_file);
                }

                $record->delete();
                return response()->json(['status' => 'success', 'message' => 'Home Content deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Home Content not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Home Content delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'Home Content delete failed']);
        }
    }
}
