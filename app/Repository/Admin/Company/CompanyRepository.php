<?php

namespace App\Repository\Admin\Company;

use App\Models\Company;
use App\Http\Resources\CompanyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class CompanyRepository implements ICompanyRepository
{

     public function storeCompany(Request $request,array $data)
     {
      $company = new Company();
      $company->company_name = $request->input('company_name');
      $company->company_address = $request->input('company_address');
      $company->company_phone = $request->input('company_phone');
      $company->company_email = $request->input('company_email');
      $company->company_fax = $request->input('company_fax');
      $company->save();

     }

     public function updateCompany(Request $request,  $id, array $data)
     {
      $company = Company::find($id);
      $company->company_name = $request->input('company_name');
      $company->company_address = $request->input('company_address');
      $company->company_phone = $request->input('company_phone');
      $company->company_email = $request->input('company_email');
      $company->company_fax = $request->input('company_fax');
      $company->update();
      
     }

     public function deleteCompany($id)
     {
      $company = Company::find($id);

        $company = $company->delete();
     }

}