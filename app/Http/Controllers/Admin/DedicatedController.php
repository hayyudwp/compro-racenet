<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DedicatedController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->input('table'); // Mendeteksi tabel yang diminta
    
            if ($table == 'dedicated') {
                $data = Product::where('category', 'dedicated')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("dedicated.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;';
                        return $btn;
                    })
                    ->addColumn('image', function ($row) {
                        $imagePath = asset('storage/product/dedicated/' . $row->image);
                        return '<img src="' . $imagePath . '" alt="Dedicated Internet Image" width="100" height="auto">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
            } elseif ($table == 'dedicated-detail') {
                $data = ProductDetail::where('category', 'dedicated')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("dedicated-detail.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;<button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                        return $btn;
                    })
                    ->editColumn('link', function($item) {
                        $link = $item->link;
                        $class = '<div class="icon-data-table">'.$link.'</div>';
                        return $class; // Pastikan HTML tidak di-escape
                    })
                    ->rawColumns(['action', 'link']) // Tambahkan 'link' di sini
                    ->make(true);
            }
        }
    
       return view('admin.dedicated.index');
   }

   
   public function create()
   {
       return view('admin.dedicated.create-detail');
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
   public function edit(Product $dedicated)
   {
       return view('admin.dedicated.edit', compact('dedicated'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, Product $dedicated)
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
   public function delete(Request $request)
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
    /**
     * 
     
    * DEDICATED INTERNET DETAIL


    */
   public function store_detail(Request $request)
   {
    try {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'link' => 'required|string',
            'category' => 'required|string',
        ]);

   
        // Prepare data for creation
        $data = $request->only([
            'title', 
            'desc',
            'link',
            'category',
        ]);
        $data['created_by'] = Auth::user()->name;

        // Create the Dedicated Internet Detail record
        ProductDetail::create($data);

        // Redirect with success message
        return redirect()->route('dedicated.index')->with('success', 'Created New Dedicated Internet Detail Successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error('Dedicated Internet Detail creation error: ' . $e->getMessage());

        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while creating the dedicated detail.');
    }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit_detail(ProductDetail $dedicated_detail)
   {
       return view('admin.dedicated.edit-detail', compact('dedicated_detail'));
   }

   /**
    * Update the specified resource in storage.
    */
    public function update_detail(Request $request, ProductDetail $dedicated_detail)
    {
        try {
            // Validate the request data
            $request->validate([
                'title' => 'required|string|max:255',
                'desc' => 'required|string',
                'link' => 'required|string',
                'category' => 'required|string',
            ]);
    
            // Prepare data for update
            $data = $request->only([
                'title', 
                'desc',
                'link',
                'category',
            ]);
            $data['updated_by'] = Auth::user()->name;
    
            // Update the Dedicated Internet Detail
            $dedicated_detail->update($data);
    
            return redirect()->route('dedicated.index')->with('success', 'Updated Dedicated Internet Detail Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Dedicated Internet Detail update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the dedicated.');
        }
    }
   /**
    * Remove the specified resource from storage.
    */
   public function delete_detail(Request $request)
   {
       try {
           $id = $request->itemID;
           $record = ProductDetail::find($id);

           if ($record) {
               $record->delete();
               return response()->json(['status' => 'success', 'message' => 'Dedicated Internet Detail deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Dedicated Internet Detail not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Dedicated Internet Detail delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Dedicated Internet Detail delete failed']);
       }
   }
}
