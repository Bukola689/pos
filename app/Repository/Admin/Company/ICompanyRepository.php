<?php

namespace App\Repository\Admin\Company;

use App\Models\Company;
use Illuminate\Http\Request;

interface ICompanyRepository
{
     public function storeCompany(Request $request, array $data);

     public function updateCompany(Request $request, Company $company, array $data);

     public function deleteCompany(Company $company);
}