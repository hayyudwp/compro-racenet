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

class ColocationController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->input('table'); // Mendeteksi tabel yang diminta
    
            if ($table == 'colocation') {
                $data = Product::where('category', 'colocation')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("colocation.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;';
                        return $btn;
                    })
                    ->addColumn('image', function ($row) {
                        $imagePath = asset('storage/product/colocation/' . $row->image);
                        return '<img src="' . $imagePath . '" alt="Colocation Server Image" width="100" height="auto">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
            } elseif ($table == 'colocation-detail') {
                $data = ProductDetail::where('category', 'colocation')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("colocation-detail.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;<button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
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
    
       return view('admin.colocation.index');
   }

   
   public function create()
   {
       return view('admin.colocation.create-detail');
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
               $image->storeAs('public/product/colocation', $imageName);
           }

           // Prepare data for creation
           $data = $request->only([
               'title', 
               'desc',
               'category',
           ]);
           $data['created_by'] = Auth::user()->name;
           $data['image'] = $imageName;

           // Create the Colocation Server
           Product::create($data);

           return redirect()->route('colocation.index')->with('success', 'Created New Colocation Server Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Colocation Server creation error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while creating the colocation.');
       }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Product $colocation)
   {
       return view('admin.colocation.edit', compact('colocation'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, Product $colocation)
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
               $path = $image->storeAs('public/product/colocation', $imageName);

               // Debugging: Log the image name and path
               Log::info('Image Name: ' . $imageName);
               Log::info('Storage Path: ' . storage_path('app/public/product/colocation'));

               // Delete the old image if it exists
               if ($colocation->image && Storage::exists('public/product/colocation/' . $colocation->image)) {
                   Storage::delete('public/product/colocation/' . $colocation->image);
               }

               // Update the image path in the Colocation Server
               $colocation->image = $imageName;
           }

           // Prepare data for update
           $data = $request->except('image');
           $data['updated_by'] = Auth::user()->name;

           // Update the Colocation Server
           $colocation->update($data);

           return redirect()->route('colocation.index')->with('success', 'Updated Colocation Server Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Colocation Server update error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while updating the colocation.');
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
               if ($record->image && Storage::exists('public/product/colocation/' . $record->image)) {
                   Storage::delete('public/product/colocation/' . $record->image);
               }

               $record->delete();
               return response()->json(['status' => 'success', 'message' => 'Colocation Server deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Colocation Server not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Colocation Server delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Colocation Server delete failed']);
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

        // Create the Colocation Server Detail record
        ProductDetail::create($data);

        // Redirect with success message
        return redirect()->route('colocation.index')->with('success', 'Created New Colocation Server Detail Successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error('Colocation Server Detail creation error: ' . $e->getMessage());

        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while creating the colocation server detail.');
    }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit_detail(ProductDetail $colocation_detail)
   {
       return view('admin.colocation.edit-detail', compact('colocation_detail'));
   }

   /**
    * Update the specified resource in storage.
    */
    public function update_detail(Request $request, ProductDetail $colocation_detail)
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
    
            // Update the Colocation Server Detail
            $colocation_detail->update($data);
    
            return redirect()->route('colocation.index')->with('success', 'Updated Colocation Server Detail Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Colocation Server Detail update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the colocation.');
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
               return response()->json(['status' => 'success', 'message' => 'Colocation Server Detail deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'Colocation Server Detail not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('Colocation Server Detail delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'Colocation Server Detail delete failed']);
       }
   }
}
