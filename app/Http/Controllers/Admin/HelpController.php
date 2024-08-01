<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Help;
use App\Services\LoggerService;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class HelpController extends Controller
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
             $data = Help::select('*');
             return DataTables::of($data)
                 ->addIndexColumn()
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("help.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="' . $id . '"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->addColumn('image', function ($row) {
                     // Assuming 'image' is the field containing the image path or URL
                     $imagePath = $row->image;
                     $imgTag = '<img src="' . asset('storage/help') . '/' . $imagePath . '" alt="Help Image" width="200" height="200">';
                     return $imgTag;
                 })
                 ->rawColumns(['action', 'image'])
                 ->make(true);
         }
         return view('admin.help.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.help.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
            $validatedData = $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'category' => 'required'
            ]);

           $help = new Help();
           $help->question = $validatedData['question'];
           $help->answer = $validatedData['answer'];
           $help->category = $validatedData['category'];
           $help->save();
           
             return redirect()->route('help.index')->with('success', 'Created New Help Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the help.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Help $help)
     {
         return view('admin.help.edit', compact('help'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id)
     {

             $validatedData = $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'category' => 'required'
            ]);
    
            $help = Help::findOrFail($id);
            $help->update($validatedData);
    
            return redirect()->route('help.index')->with('success', 'Help updated successfully.');
             // Handle image upload
        
     }
 
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request)
     {
         try {
             $id = $request->itemID;
             $record = Help::find($id);
 
             if (Storage::exists('public/help/' . $record->image)) {
                 Storage::delete('public/help/' . $record->image);
             }
             
             $record->delete();
 
             return response()->json(['status' => 'success', 'message' => 'Help deleted successfully']);
         } catch (\Exception $e) {
             $this->logger->logMessage($e->getMessage());
             return response()->json(['status' => 'failed', 'message' => 'Help deleted failed']);
         }
     }
}
