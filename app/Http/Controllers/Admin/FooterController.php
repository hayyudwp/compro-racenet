<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Footer;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FooterController extends Controller
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
            $data = Footer::where('category', 'footer_desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("footer-desc.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;';
                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    // Assuming 'image' is the field containing the image path or URL
                    $imagePath = $row->image;
                    $imgTag = '<img src="' . asset('storage/footer/logo/' . $imagePath) . '" alt="Broadband Internet Image" width="100%" height="auto">';
                    return $imgTag;
                })
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('admin.footer-desc.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.footer-desc.create');
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
                'category' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Initialize imageName variable
            $imageName = null;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . Str::slug($request->title, '-') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/footer/logo', $imageName);
            }

            // Prepare data for creation
            $data = $request->only([
                'title', 
                'desc',
                'category',
            ]);
            $data['created_by'] = Auth::user()->name;
            $data['image'] = $imageName;

            // Create the Footer Description
            Footer::create($data);

            return redirect()->route('footer-desc.index')->with('success', 'Created New Footer Description Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Footer Description creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the Footer Description.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footer $footer_desc)
    {
        return view('admin.footer-desc.edit', compact('footer_desc'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Footer $footer_desc)
    {
        try {
            // Validate the request data
            $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'category' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Making image nullable for updates
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '-' . Str::slug($request->title, '-') . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/footer/logo', $imageName);

                // Debugging: Log the image name and path
                Log::info('Image Name: ' . $imageName);
                Log::info('Storage Path: ' . storage_path('app/public/footer/logo'));

                // Delete the old image if it exists
                if ($footer_desc->image && Storage::exists('public/footer/logo/' . $footer_desc->image)) {
                    Storage::delete('public/footer/logo/' . $footer_desc->image);
                }

                // Update the image path in the Footer Description
                $footer_desc->image = $imageName;
            }

            // Prepare data for update
            $data = $request->except('image');
            $data['updated_by'] = Auth::user()->name;

            // Update the Footer Description
            $footer_desc->update($data);

            return redirect()->route('footer-desc.index')->with('success', 'Updated Footer Description Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Footer Description update error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the Footer Description.');
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
                return response()->json(['status' => 'success', 'message' => 'Footer Description deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Footer Description not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Footer Description delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'Footer Description delete failed']);
        }
    }

}
