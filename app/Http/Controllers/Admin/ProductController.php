<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    protected $logger;

    public function __construct(LoggerService $logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Display a listing of the resource.
     */

     public function broadband_index(Request $request)
     {
        if ($request->ajax()) {
            $data = Product::where('category', 'broadband')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<a class="btn btn-warning" href="' . route("broadband.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                    return $btn;
                })
                ->addColumn('image', function ($row) {
                    // Assuming 'image' is the field containing the image path or URL
                    $imagePath = $row->image;
                    $imgTag = '<img src="' . asset('storage/product/broadband/' . $imagePath) . '" alt="Broadband Internet Image" width="100%" height="auto">';
                    return $imgTag;
                })
                ->rawColumns(['action', 'image'])
                ->make(true);
        }
        return view('admin.broadband.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function broadband_create()
    {
        return view('admin.broadband.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function broadband_store(Request $request)
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
                $image->storeAs('public/product/broadband', $imageName);
            }

            // Prepare data for creation
            $data = $request->only([
                'title', 
                'desc',
                'category',
            ]);
            $data['created_by'] = Auth::user()->name;
            $data['image'] = $imageName;

            // Create the Broadband Internet
            Product::create($data);

            return redirect()->route('broadband.index')->with('success', 'Created New Broadband Internet Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Broadband Internet creation error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while creating the broadband.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function broadband_edit(Product $broadband)
    {
        return view('admin.broadband.edit', compact('broadband'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function broadband_update(Request $request, Product $broadband)
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
                $path = $image->storeAs('public/product/broadband', $imageName);

                // Debugging: Log the image name and path
                Log::info('Image Name: ' . $imageName);
                Log::info('Storage Path: ' . storage_path('app/public/product/broadband'));

                // Delete the old image if it exists
                if ($broadband->image && Storage::exists('public/product/broadband/' . $broadband->image)) {
                    Storage::delete('public/product/broadband/' . $broadband->image);
                }

                // Update the image path in the Broadband Internet
                $broadband->image = $imageName;
            }

            // Prepare data for update
            $data = $request->except('image');
            $data['updated_by'] = Auth::user()->name;

            // Update the Broadband Internet
            $broadband->update($data);

            return redirect()->route('broadband.index')->with('success', 'Updated Broadband Internet Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Broadband Internet update error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An error occurred while updating the broadband.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function broadband_delete(Request $request)
    {
        try {
            $id = $request->itemID;
            $record = Product::find($id);

            if ($record) {
                if ($record->image && Storage::exists('public/product/broadband/' . $record->image)) {
                    Storage::delete('public/product/broadband/' . $record->image);
                }

                $record->delete();
                return response()->json(['status' => 'success', 'message' => 'Broadband Internet deleted successfully']);
            } else {
                return response()->json(['status' => 'failed', 'message' => 'Broadband Internet not found']);
            }
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Broadband Internet delete error: ' . $e->getMessage());

            return response()->json(['status' => 'failed', 'message' => 'Broadband Internet delete failed']);
        }
    }


    /**
    * DEDICATED INTERNET
    */


    public function dedicated_index(Request $request)
    {
       if ($request->ajax()) {
           $data = Product::where('category', 'dedicated')->get();
           return DataTables::of($data)
               ->addIndexColumn()
               ->addColumn('action', function ($row) {
                   $id = $row->id;
                   $btn = '<a class="btn btn-warning" href="' . route("dedicated.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                   return $btn;
               })
               ->addColumn('image', function ($row) {
                   // Assuming 'image' is the field containing the image path or URL
                   $imagePath = $row->image;
                   $imgTag = '<img src="' . asset('storage/product/dedicated/' . $imagePath) . '" alt="Dedicated Internet Image" width="100%" height="auto">';
                   return $imgTag;
               })
               ->rawColumns(['action', 'image'])
               ->make(true);
       }
       return view('admin.dedicated.index');
   }





   
   public function dedicated_create()
   {
       return view('admin.dedicated.create');
   }

   /**
    * Store a newly created resource in storage.
    */
   public function dedicated_store(Request $request)
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
               $image->storeAs('public/product/dedicated', $imageName);
           }

           // Prepare data for creation
           $data = $request->only([
               'title', 
               'desc',
               'category',
           ]);
           $data['created_by'] = Auth::user()->name;
           $data['image'] = $imageName;

           // Create the Dedicated Internet
           Product::create($data);

           return redirect()->route('dedicated.index')->with('success', 'Created New Dedicated Internet Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Dedicated Internet creation error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while creating the dedicated.');
       }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function dedicated_edit(Product $dedicated)
   {
       return view('admin.dedicated.edit', compact('dedicated'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function dedicated_update(Request $request, Product $dedicated)
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
               $path = $image->storeAs('public/product/dedicated', $imageName);

               // Debugging: Log the image name and path
               Log::info('Image Name: ' . $imageName);
               Log::info('Storage Path: ' . storage_path('app/public/product/dedicated'));

               // Delete the old image if it exists
               if ($dedicated->image && Storage::exists('public/product/dedicated/' . $dedicated->image)) {
                   Storage::delete('public/product/dedicated/' . $dedicated->image);
               }

               // Update the image path in the Dedicated Internet
               $dedicated->image = $imageName;
           }

           // Prepare data for update
           $data = $request->except('image');
           $data['updated_by'] = Auth::user()->name;

           // Update the Dedicated Internet
           $dedicated->update($data);

           return redirect()->route('dedicated.index')->with('success', 'Updated Dedicated Internet Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Dedicated Internet update error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while updating the dedicated.');
       }
   }

   /**
    * Remove the specified resource from storage.
    */
   public function dedicated_delete(Request $request)
   {
       try {
           $id = $request->itemID;
           $record = Product::find($id);

           if ($record) {
               if ($record->image && Storage::exists('public/product/dedicated/' . $record->image)) {
                   Storage::delete('public/product/dedicated/' . $record->image);
               }

               $record->delete();
               return response()->json(['status' => 'success', 'message' => 'Dedicated Internet deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Dedicated Internet not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Dedicated Internet delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Dedicated Internet delete failed']);
       }
   }
}
