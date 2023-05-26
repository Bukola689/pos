<?php

namespace App\Repository\Admin\Supplier;

use App\Models\Supplier;
use Illuminate\Http\Request;

interface ISupplierRepository
{
     public function storeSupplier(Request $request, array $data);

     // public function updateSupplier(Request $request, Supplier $supplier, array $data);

     // public function deleteSupplier(Supplier $supplier);
}