<?php

namespace App\Repository\Admin\Supplier;

use App\Models\Supplier;
use Illuminate\Http\Request;


class SupplierRepository implements ISupplierRepository
{
   public function storeSupplier(Request $request, array $data)
     {
       $supplier = new Supplier();
       $supplier->name = $request->name;
       $supplier->address = $request->address;
       $supplier->phone = $request->phone;
       $supplier->email = $request->email;
       $supplier->save();
     }

  public function updateSupplier(Request $request, $id, array $data)
     {
      $supplier = Supplier::find($id);

      $supplier->name = $request->name;
      $supplier->address = $request->address;
      $supplier->phone = $request->phone;
      $supplier->email = $request->email;
      $supplier->update();
     }

     public function deleteSupplier($id)
     {
      $supplier = Supplier::find($id);
      
        $supplier->delete();
     }

}