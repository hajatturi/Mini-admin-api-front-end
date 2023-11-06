<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CompanyResource;
use App\Notifications\NewCompanyAdded;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companys = Company::latest()->paginate(10);
        return CompanyResource::collection($companys);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
       
        $validator = Validator::make($data, [
            'name' => 'required',
            'logo' => 'image|dimensions:min_width=100,min_height=100',

        ]);
        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $data['creator_id']=auth()->user()->id;
        if ($file = $request->file('logo')) {
            $uploadedFile = $request->file('logo');
            $filename = time().$uploadedFile->getClientOriginalName();
            $destinationPath = 'storage/logos/';
            $file->move($destinationPath, $filename);
            $data['logo']=$filename;
        }
        
        $company = Company::create($data);
      //  $company->notify(new NewCompanyAdded($company));
        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required',
            'logo' => 'image|dimensions:min_width=100,min_height=100',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        if ($file = $request->file('logo')) {
            $uploadedFile = $request->file('logo');
            $filename = time().$uploadedFile->getClientOriginalName();
            $destinationPath = 'storage/logo/';
            $file->move($destinationPath, $filename);
            $data['logo']=$filename;
        }

        $company->update($data);
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $Company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $Company)
    {
        $Company->delete();
        return new CompanyResource($Company);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $Companys = Company::where('name', 'like', '%'.$title.'%')->get();
        return CompanyResource::collection($Companys);
    }
}