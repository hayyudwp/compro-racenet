<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class ContentController extends Controller
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
             $data = Content::select('*');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("content.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->addColumn('image', function ($row) {
                     // Assuming 'image' is the field containing the image path or URL
                     $imagePath = $row->image;
                     $imgTag = '<img src="' . asset('storage/content') . '/' . $imagePath . '" alt="About Content Image" width="100%" height="auto">';
                     return $imgTag;
                 })
                 ->rawColumns(['action', 'image'])
                 ->make(true);
         }
         return view('admin.content.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.content.create');
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
      
              // Handle image upload
              if ($request->hasFile('image')) {
                  $image = $request->file('image');
                  $imageName = time() . '-' . Str::slug($request->title, '-') . '.' . $image->getClientOriginalExtension();
                  $image->storeAs('public/content', $imageName);
              }
      
              // Merge additional data into the request
              $request->merge([
                  'created_by' => Auth::user()->name,
                  'image' => $imageName ?? null
              ]);
      
              // Create the content
              Content::create($request->except(['image']));
      
              return redirect()->route('content.index')->with('success', 'Created New About Content Successfully.');
          } catch (\Exception $e) {
              // Log the error message
              Log::error('Content creation error: ' . $e->getMessage());
      
              return redirect()->back()->with('error', 'An error occurred while creating the content.');
          }
      }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Content $content)
     {
         return view('admin.content.edit', compact('content'));
     }
 
     /**
      * Update the specified resource in storage.
      */
      public function update(Request $request, Content $content)
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
                  
                  // Debugging: Log the image name and path
                  Log::info('Image Name: ' . $imageName);
                  Log::info('Storage Path: ' . storage_path('app/public/content'));
      
                  $path = $image->storeAs('public/content', $imageName);
                  
                  // Debugging: Log the storage path
                  Log::info('Stored Path: ' . $path);
      
                  // Delete the old image if it exists
                  if ($content->image && Storage::exists('public/content/' . $content->image)) {
                      Storage::delete('public/content/' . $content->image);
                  }
      
                  // Update the image path in the content
                  $content->image = $imageName;
              }
      
              // Merge additional data into the request
              $request->merge([
                  'updated_by' => Auth::user()->name
              ]);
      
              // Update the content, excluding the image if not provided
              $content->update($request->except('image'));
      
              return redirect()->route('content.index')->with('success', 'Updated About Content Successfully.');
          } catch (\Exception $e) {
              // Log the error message
              Log::error('Content update error: ' . $e->getMessage());
      
              return redirect()->back()->with('error', 'An error occurred while updating the About Content.');
          }
      }
 
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request)
     {
         try {
             $id = $request->itemID;
             $record = Content::find($id);
 
             if (Storage::exists('public/content/' . $record->image)) {
                 Storage::delete('public/content/' . $record->image);
             }
             
             $record->delete();
 
             return response()->json(['status' => 'success', 'message' => 'About Content deleted successfully']);
         } catch (\Exception $e) {
             $this->logger->logMessage($e->getMessage());
             return response()->json(['status' => 'failed', 'message' => 'About Content deleted failed']);
         }
     }
}
