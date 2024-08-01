<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Header;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HeaderController extends Controller
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
            $data = Header::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("header.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    // Assuming 'image' is the field containing the image path or URL
                    $imagePath = $row->image;
                    $imgTag = '<img src="' . asset('storage/header/' . $imagePath) . '" alt="Header Image" width="100%" height="auto">';
                    return $imgTag;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('admin.header.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.header.create');
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Initialize imageName variable
            $imageName = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . Str::slug($request->title, '-') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/header', $imageName);
            }

            // Prepare data for creation
            $data = $request->only(['title', 'desc']);
            $data['created_by'] = Auth::user()->name;
            $data['image'] = $imageName;

            // Create the header
            Header::create($data);

            return redirect()->route('header.index')->with('success', 'Created New Header Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Header creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the header.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Header $header)
    {
        return view('admin.header.edit', compact('header'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Header $header)
    {
        try {
            // Validate the request data
            $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Making image nullable for updates
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . Str::slug($request->title, '-') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/header', $imageName);

                // Debugging: Log the image name and path
                Log::info('Image Name: ' . $imageName);
                Log::info('Storage Path: ' . storage_path('app/public/header'));

                // Delete the old image if it exists
                if ($header->image && Storage::exists('public/header/' . $header->image)) {
                    Storage::delete('public/header/' . $header->image);
                }

                // Update the image path in the header
                $header->image = $imageName;
            }

            // Prepare data for update
            $data = $request->except('image');
            $data['updated_by'] = Auth::user()->name;

            // Update the header
            $header->update($data);

            return redirect()->route('header.index')->with('success', 'Updated Header Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Header update error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the header.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        try {
            $id = $request->itemID;
            $record = Header::find($id);

            if ($record) {
                if ($record->image && Storage::exists('public/header/' . $record->image)) {
                    Storage::delete('public/header/' . $record->image);
                }

                $record->delete();
                return response()->json(['status' => 'success', 'message' => 'Header deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Header not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Header delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'Header delete failed']);
        }
    }
}
