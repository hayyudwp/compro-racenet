<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\LoggerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
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
             $data = Gallery::select('*');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("gallery.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->addColumn('image', function ($row) {
                     // Assuming 'image' is the field containing the image path or URL
                     $imagePath = $row->image;
                     $imgTag = '<img src="' . asset('storage/gallery') . '/' . $imagePath . '" alt="Gallery Image" width="200" height="200">';
                     return $imgTag;
                 })
                 ->rawColumns(['action', 'image'])
                 ->make(true);
         }
         return view('admin.gallery.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.gallery.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
             $request->validate([
                 'category' => 'required'
             ]);
 
             // Handle image upload
             if ($request->hasFile('image')) {
                 $image = $request->file('image');
                 $imageName = time() . '-' . $request->category . '.' . $image->getClientOriginalExtension();
                 $image->storeAs('public/gallery', $imageName);
                 // You can also store the image path in the database if needed
             }

             $request->merge([
                'created_by' => Auth::user()->name
            ]);
 
             Gallery::create($request->except('image') + ['image' => $imageName ?? null]);
             return redirect()->route('gallery.index')->with('success', 'Created New Gallery Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the gallery.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Gallery $gallery)
     {
         return view('admin.gallery.edit', compact('gallery'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, Gallery $gallery)
     {
         try {
             $request->validate([
                'category' => 'required'
             ]);
             // Handle image upload
             if ($request->hasFile('image')) {
                 $image = $request->file('image');
                 $imageName = time() . '-' . $request->category . '.' . $image->getClientOriginalExtension();
                 $image->storeAs('public/gallery', $imageName);
                 // You can also update the image path in the database if needed
                 if (Storage::exists('public/gallery/' . $gallery->image)) {
                     Storage::delete('public/gallery/' . $gallery->image);
                 }
 
                 $gallery->image = $imageName;
             }

             $request->merge([
                 'updated_by' => Auth::user()->name
             ]);
 
             $gallery->update($request->except('image'));
 
             return redirect()->route('gallery.index')->with('success', 'Updated Gallery Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while update the Gallery.');
         }
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request)
     {
         try {
             $id = $request->itemID;
             $record = Gallery::find($id);
 
             if (Storage::exists('public/gallery/' . $record->image)) {
                 Storage::delete('public/gallery/' . $record->image);
             }
             
             $record->delete();
 
             return response()->json(['status' => 'success', 'message' => 'Gallery deleted successfully']);
         } catch (\Exception $e) {
             $this->logger->logMessage($e->getMessage());
             return response()->json(['status' => 'failed', 'message' => 'Gallery deleted failed']);
         }
     }
}
