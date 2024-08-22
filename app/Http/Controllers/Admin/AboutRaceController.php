<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutRN;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class AboutRaceController extends Controller
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
             $data = AboutRN::select('*');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("about.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->editColumn('link_icon', function($item) {
                    $link_icon = $item->link_icon;
                    $class = '<div class="icon-data-table">'.$link_icon.'</div>';
                    return $class; // Pastikan HTML tidak di-escape
                })
                ->rawColumns(['action', 'link_icon']) // Tambahkan 'link' di sini
                 ->make(true);
         }
         return view('admin.about.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.about.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
            $validatedData = $request->validate([
                 'title' => 'required',
                 'desc' => 'required',
                 'link_icon' => 'required'
             ]);
 
             // Handle image upload
            $priceList = new AboutRN();
            $priceList->title = $validatedData['title'];
            $priceList->desc = $validatedData['desc'];
            $priceList->link_icon = $validatedData['link_icon'];
            $priceList->save();
            
 
            //  AboutRN::create($request->except('image') + ['image' => $imageName ?? null]);
             return redirect()->route('about.index')->with('success', 'Created New About Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the about.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(AboutRN $about)
     {
         return view('admin.about.edit', compact('about'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, AboutRN $about)
     {
         try {
            $validatedData = $request->validate([
                'title' => 'required',
                'desc' => 'required',
                 'link_icon' => 'required'
             ]);
             // Handle image upload
 
             $about->update($validatedData);
 
             return redirect()->route('about.index')->with('success', 'Updated About Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while update the about.');
         }
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request)
     {
         try {
             $id = $request->itemID;
             $record = AboutRN::find($id);
 
             if (Storage::exists('public/about/' . $record->image)) {
                 Storage::delete('public/about/' . $record->image);
             }
             
             $record->delete();
 
             return response()->json(['status' => 'success', 'message' => 'About deleted successfully']);
         } catch (\Exception $e) {
             $this->logger->logMessage($e->getMessage());
             return response()->json(['status' => 'failed', 'message' => 'About deleted failed']);
         }
     }
}
