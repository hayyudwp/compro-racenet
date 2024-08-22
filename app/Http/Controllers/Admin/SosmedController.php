<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sosmed;
use App\Services\LoggerService;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class SosmedController extends Controller
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
             $data = Sosmed::select('*');
             return DataTables::of($data)
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("sosmed.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="'.$id.'"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->editColumn('code_icon', function($item) {
                    $code_icon = $item->code_icon;
                    $class = '<div class="icon-data-table">'.$code_icon.'</div>';
                    return $class; // Pastikan HTML tidak di-escape
                })
                ->rawColumns(['action', 'code_icon']) // Tambahkan 'link' di sini
                 ->make(true);
         }
         return view('admin.sosmed.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.sosmed.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
            $validatedData = $request->validate([
                 'title' => 'required',
                 'code_icon' => 'required',
                 'link' => 'required',
             ]);
 
            $sosmed = new Sosmed();
            $sosmed->title = $validatedData['title'];
            $sosmed->code_icon = $validatedData['code_icon'];
            $sosmed->link = $validatedData['link'];
            $sosmed->save();
            
             return redirect()->route('sosmed.index')->with('success', 'Created New Social Media Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the Social Media.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Sosmed $sosmed)
     {
         return view('admin.sosmed.edit', compact('sosmed'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id)
     {
        
            $validatedData = $request->validate([
                'title' => 'required',
                'code_icon' => 'required',
                'link' => 'required',
            ]);
    
            $sosmed = Sosmed::findOrFail($id);
            $sosmed->update($validatedData);
    
            return redirect()->route('sosmed.index')->with('success', 'Social Media updated successfully.');
        
     }
 
     /**
      * Remove the specified resource from storage.
      */
      public function delete(Request $request)
      {
          $id = $request->itemID;
          $sosmed = Sosmed::find($id);
  
          if ($sosmed) {
              $sosmed->delete();
              return response()->json([
                  'status' => 'success',
                  'message' => 'Item deleted successfully!'
              ]);
          } else {
              return response()->json([
                  'status' => 'error',
                  'message' => 'Item not found!'
              ]);
          }
      }
}
