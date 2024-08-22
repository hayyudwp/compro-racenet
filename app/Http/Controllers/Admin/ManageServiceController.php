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
class ManageServiceController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->input('table'); // Mendeteksi tabel yang diminta
    
            if ($table == 'manage-service') {
                $data = Product::where('category', 'manage-service')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("manage-service.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;';
                        return $btn;
                    })
                    ->addColumn('image', function ($row) {
                        $imagePath = asset('storage/product/manage-service/' . $row->image);
                        return '<img src="' . $imagePath . '" alt="Manage Service Solution Image" width="100" height="auto">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
            } elseif ($table == 'manage-service-detail') {
                $data = ProductDetail::where('category', 'manage-service')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("manage-service-detail.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;<button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
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
    
       return view('admin.manage-service.index');
   }

   
   public function create()
   {
       return view('admin.manage-service.create-detail');
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
               $image->storeAs('public/product/manage-service', $imageName);
           }

           // Prepare data for creation
           $data = $request->only([
               'title', 
               'desc',
               'category',
           ]);
           $data['created_by'] = Auth::user()->name;
           $data['image'] = $imageName;

           // Create the Manage Service Solution
           Product::create($data);

           return redirect()->route('manage-service.index')->with('success', 'Created New Manage Service Solution Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Manage Service Solution creation error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while creating the manage service.');
       }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Product $manage_service)
   {
       return view('admin.manage-service.edit', compact('manage_service'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, Product $manage_service)
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
               $path = $image->storeAs('public/product/manage-service', $imageName);

               // Debugging: Log the image name and path
               Log::info('Image Name: ' . $imageName);
               Log::info('Storage Path: ' . storage_path('app/public/product/manage-service'));

               // Delete the old image if it exists
               if ($manage_service->image && Storage::exists('public/product/manage-service/' . $manage_service->image)) {
                   Storage::delete('public/product/manage-service/' . $manage_service->image);
               }

               // Update the image path in the Manage Service Solution
               $manage_service->image = $imageName;
           }

           // Prepare data for update
           $data = $request->except('image');
           $data['updated_by'] = Auth::user()->name;

           // Update the Manage Service Solution
           $manage_service->update($data);

           return redirect()->route('manage-service.index')->with('success', 'Updated Manage Service Solution Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Manage Service Solution update error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while updating the manage service.');
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
               if ($record->image && Storage::exists('public/product/manage-service/' . $record->image)) {
                   Storage::delete('public/product/manage-service/' . $record->image);
               }

               $record->delete();
               return response()->json(['status' => 'success', 'message' => 'Manage Service Solution deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Manage Service Solution not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Manage Service Solution delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Manage Service Solution delete failed']);
       }
   }

   
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

        // Create the Manage Service Solution Detail record
        ProductDetail::create($data);

        // Redirect with success message
        return redirect()->route('manage-service.index')->with('success', 'Created New Manage Service Solution Detail Successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error('Manage Service Solution Detail creation error: ' . $e->getMessage());

        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while creating the Manage Service Solution detail.');
    }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit_detail(ProductDetail $manage_service_detail)
   {
       return view('admin.manage-service.edit-detail', compact('manage_service_detail'));
   }

   /**
    * Update the specified resource in storage.
    */
    public function update_detail(Request $request, ProductDetail $manage_service_detail)
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
    
            // Update the Manage Service Solution Detail
            $manage_service_detail->update($data);
    
            return redirect()->route('manage-service.index')->with('success', 'Updated Manage Service Solution Detail Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Manage Service Solution Detail update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the manage service.');
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
               return response()->json(['status' => 'success', 'message' => 'Manage Service Solution Detail deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Manage Service Solution Detail not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Manage Service Solution Detail delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Manage Service Solution Detail delete failed']);
       }
   }
}
