<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repository\Admin\Company\CompanyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public $company;

    public function __construct(CompanyRepository $company)
    {
        $this->company = $company;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $companies = Cache::remember('company', 60,function() {

            return Company::orderBy('id', 'desc')->get();

        });

        if($companies->isEmpty()) {
            return response()->json('companies does not exist !');
        }

        return response()->json([
            'companies', $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompanyRequest $request)
    {
       
       $data = $request->all();

      $this->company->storeCompany($request, $data);

       Cache::put('company', $data);

        return response()->json([
           // 'company' => $company,
            'message' => 'Company Saved Successfully !'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        $companyId = Cache::remember('company:'. $id, 60, function() use ($company) {
            return $company;
        });

        if(! $company) {
            return response()->json('company id does not exist');
        }

            return response()->json([
                'status' => $companyId,
            ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = Company::find($id);

        if(!$company) {
            return response()->json('cpmpany not found');
        }

        $data = $request->all();

        $this->company->updateCompany($request, $id, $data);

       Cache::put('company', $data);

        return response()->json([
            'company' => $company,
            'message' => 'Company Saved Successfully !'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        if(!$company) {
            return response()->json('comany not found');
        }

        $this->company->deleteCompany($company);

        Cache::pull('company');

       
            return response()->json([
                'message' => 'Company Deleted Successfully !'
            ]); 
        
    }

    public function search($search)
    {
        $company = Company::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($company) {
            return response()->json([
                'success' => true,
                'company' => $company
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'company not found'
            ]);
        }
    }
}
