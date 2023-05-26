<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use App\Repository\Admin\Supplier\SupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use SebastianBergmann\CodeUnit\FunctionUnit;

class SupplierController extends Controller
{
     /**
     * get all repository for supplier.
     *
     * @param  \Illuminate\Http\SuplierRepository  $supplier
     * @return \Illuminate\Http\Response
     */

    public $supplier;

    public function __construct(SupplierRepository $supplier)
    {
        $this->supplier = $supplier;
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $suppliers = Cache::remember('suppliers', 60, function() {
            return Supplier::orderBy('id', 'asc')->get();
        });

        if($suppliers->isEmpty) {
            return response()->json('Supplier list is empty');
        }

        return response()->json($suppliers);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreSupplierRequest $request)
    {
        $data = $request->all();

        $this->supplier->storeSupplier($request, $data);

        Cache::put('supplier', $data);

        return response()->json([
            'message' => 'Supplier Saved Successfully'
        ]);
    }

    public function show(Request $request, $id)
    {
        $supplier = Supplier::find($id);

        $supplierId = Cache::remember('supplier:'. $id, 60, function () use ($supplier) {
            return $supplier;
        });

        if(!$supplier) {
            return response()->json('suppier id not found');
        }

        return response()->json($supplierId);
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = Supplier::find($id);

        $data = $request->all();

        $this->supplier->updateSupplier($request, $supplier, $data);

        Cache::put('supplier', $data);

        return response()->json([
            'message' => 'Supplier Updated Successfully'
        ]);
    }

    public function destroy( $id)
    {
        $supplier = Supplier::find($id);

        if(! $supplier) {
            return response()->json([
                'error message' => 'Product Does Not Exist For This Id'
            ]);
        }

        $this->supplier->deleteSupplier($supplier);

        Cache::pull('supplier');

        return response()->json([
            'message' => 'Supplier Removed Successfully'
        ]);
    }

}
