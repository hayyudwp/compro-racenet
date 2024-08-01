<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coverage;
use Illuminate\Http\Request;
use App\Services\LoggerService;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
class CoverageController extends Controller
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
             $data = Coverage::select('*');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("coverage.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->addColumn('image', function ($row) {
                     // Assuming 'image' is the field containing the image path or URL
                     $imagePath = $row->image;
                     $imgTag = '<img src="' . asset('storage/coverage') . '/' . $imagePath . '" alt="coverage Image" width="200" height="200">';
                     return $imgTag;
                 })
                 ->rawColumns(['action', 'image'])
                 ->make(true);
         }
         return view('admin.coverage.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.coverage.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
            $validatedData = $request->validate([
                'area' => 'required',
                'code_map' => 'required',
                'district' => 'required'
            ]);

           $coverage = new Coverage();
           $coverage->area = $validatedData['area'];
           $coverage->code_map = $validatedData['code_map'];
           $coverage->district = $validatedData['district'];
           $coverage->save();
           
             return redirect()->route('coverage.index')->with('success', 'Created New Coverage Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the Coverage.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Coverage $coverage)
     {
         return view('admin.coverage.edit', compact('coverage'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id)
     {

             $validatedData = $request->validate([
                'area' => 'required',
                'code_map' => 'required',
                'district' => 'required'
            ]);
    
            $coverage = Coverage::findOrFail($id);
            $coverage->update($validatedData);
    
            return redirect()->route('coverage.index')->with('success', 'Coverage updated successfully.');
             // Handle image upload
        
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request)
     {
         try {
             $id = $request->itemID;
             $record = Coverage::find($id);
 
             if (Storage::exists('public/coverage/' . $record->image)) {
                 Storage::delete('public/coverage/' . $record->image);
             }
             
             $record->delete();
 
             return response()->json(['status' => 'success', 'message' => 'Coverage deleted successfully']);
         } catch (\Exception $e) {
             $this->logger->logMessage($e->getMessage());
             return response()->json(['status' => 'failed', 'message' => 'Coverage deleted failed']);
         }
     }
}
