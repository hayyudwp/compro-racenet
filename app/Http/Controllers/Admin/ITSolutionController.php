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
class ITSolutionController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = $request->input('table'); // Mendeteksi tabel yang diminta
    
            if ($table == 'it-solution') {
                $data = Product::where('category', 'it-solution')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("it-solution.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;';
                        return $btn;
                    })
                    ->addColumn('image', function ($row) {
                        $imagePath = asset('storage/product/it-solution/' . $row->image);
                        return '<img src="' . $imagePath . '" alt="IT Solution Image" width="100" height="auto">';
                    })
                    ->rawColumns(['action', 'image'])
                    ->make(true);
            } elseif ($table == 'it-solution-detail') {
                $data = ProductDetail::where('category', 'it-solution')->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $id = $row->id;
                        $btn = '<a class="btn btn-warning" href="' . route("it-solution-detail.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp;<button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
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
    
       return view('admin.it-solution.index');
   }

   
   public function create()
   {
       return view('admin.it-solution.create-detail');
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
               $image->storeAs('public/product/it-solution', $imageName);
           }

           // Prepare data for creation
           $data = $request->only([
               'title', 
               'desc',
               'category',
           ]);
           $data['created_by'] = Auth::user()->name;
           $data['image'] = $imageName;

           // Create the IT Solution
           Product::create($data);

           return redirect()->route('it-solution.index')->with('success', 'Created New IT Solution Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('IT Solution creation error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while creating the IT Solution.');
       }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit(Product $it_solution)
   {
       return view('admin.it-solution.edit', compact('it_solution'));
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, Product $it_solution)
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
               $path = $image->storeAs('public/product/it-solution', $imageName);

               // Debugging: Log the image name and path
               Log::info('Image Name: ' . $imageName);
               Log::info('Storage Path: ' . storage_path('app/public/product/it-solution'));

               // Delete the old image if it exists
               if ($it_solution->image && Storage::exists('public/product/it-solution/' . $it_solution->image)) {
                   Storage::delete('public/product/it-solution/' . $it_solution->image);
               }

               // Update the image path in the IT Solution
               $it_solution->image = $imageName;
           }

           // Prepare data for update
           $data = $request->except('image');
           $data['updated_by'] = Auth::user()->name;

           // Update the IT Solution
           $it_solution->update($data);

           return redirect()->route('it-solution.index')->with('success', 'Updated IT Solution Successfully.');
       } catch (\Exception $e) {
           // Log the error message
           Log::error('IT Solution update error: ' . $e->getMessage());

           return redirect()->back()->with('error', 'An error occurred while updating the IT Solution.');
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
               if ($record->image && Storage::exists('public/product/it-solution/' . $record->image)) {
                   Storage::delete('public/product/it-solution/' . $record->image);
               }

               $record->delete();
               return response()->json(['status' => 'success', 'message' => 'IT Solution deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'IT Solution not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('IT Solution delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'IT Solution delete failed']);
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

        // Create the IT Solution Detail record
        ProductDetail::create($data);

        // Redirect with success message
        return redirect()->route('it-solution.index')->with('success', 'Created New IT Solution Detail Successfully.');
    } catch (\Exception $e) {
        // Log the error message for debugging
        Log::error('IT Solution Detail creation error: ' . $e->getMessage());

        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while creating the IT Solution detail.');
    }
   }

   /**
    * Show the form for editing the specified resource.
    */
   public function edit_detail(ProductDetail $it_solution_detail)
   {
       return view('admin.it-solution.edit-detail', compact('it_solution_detail'));
   }

   /**
    * Update the specified resource in storage.
    */
    public function update_detail(Request $request, ProductDetail $it_solution_detail)
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
    
            // Update the IT Solution Detail
            $it_solution_detail->update($data);
    
            return redirect()->route('it-solution.index')->with('success', 'Updated IT Solution Detail Successfully.');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('IT Solution Detail update error: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'An error occurred while updating the IT Solution.');
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
               return response()->json(['status' => 'success', 'message' => 'IT Solution Detail deleted successfully']);
           } else {
               return response()->json(['status' => 'failed', 'message' => 'IT Solution Detail not found']);
           }
       } catch (\Exception $e) {
           // Log the error message
           Log::error('IT Solution Detail delete error: ' . $e->getMessage());

           return response()->json(['status' => 'failed', 'message' => 'IT Solution Detail delete failed']);
       }
   }
}
