<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceList;
use App\Services\LoggerService;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class PriceListController extends Controller
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
             $data = PriceList::select('*');
             return DataTables::of($data)
                 ->addColumn('action', function ($row) {
                     $id = $row->id;
                     $btn = '<a class="btn btn-warning" href="' . route("pricelist.edit", $id) . '"><i class="bi bi-exclamation-square-fill"></i></a>&nbsp; <button class="btn btn-danger delete-item" data-id="'.$id.'"><i class="bi bi-trash-fill"></i></button>';
                     return $btn;
                 })
                 ->editColumn('desc', function($row) {
                    return $row->desc;
                })
                ->rawColumns(['action', 'desc'])
                 ->make(true);
         }
         return view('admin.pricelist.index');
     }
 
     /**
      * Show the form for creating a new resource.
      */
     public function create()
     {
         return view('admin.pricelist.create');
     }
 
     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {
         try {
            $validatedData = $request->validate([
                 'title' => 'required',
                 'bandwith' => 'required',
                 'price' => 'required',
                 'desc' => 'required',
                 'category' => 'required'
             ]);
 
            $priceList = new PriceList();
            $priceList->title = $validatedData['title'];
            $priceList->bandwith = $validatedData['bandwith'];
            $priceList->price = $validatedData['price'];
            $priceList->desc = $validatedData['desc'];
            $priceList->category = $validatedData['category'];
            $priceList->save();
            
             return redirect()->route('pricelist.index')->with('success', 'Created New pricelist Successfully.');
         } catch (\Exception $e) {
             //send to log provider
             $message = $e->getMessage();
             $this->logger->logMessage($message);
 
             return redirect()->back()->with('error', 'An error occurred while create the pricelist.');
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      */
     public function edit(PriceList $pricelist)
     {
         return view('admin.pricelist.edit', compact('pricelist'));
     }
 
     /**
      * Update the specified resource in storage.
      */
     public function update(Request $request, $id)
     {
        
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'bandwith' => 'required|string|max:255',
                'price' => 'required|numeric',
                'desc' => 'required|string|max:255',
                'category' => 'required|string|max:255',
            ]);
    
            $pricelist = PriceList::findOrFail($id);
            $pricelist->update($validatedData);
    
            return redirect()->route('pricelist.index')->with('success', 'Price List updated successfully.');
        
     }
 
     /**
      * Remove the specified resource from storage.
      */
      public function delete(Request $request)
      {
          $id = $request->itemID;
          $pricelist = PriceList::find($id);
  
          if ($pricelist) {
              $pricelist->delete();
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
