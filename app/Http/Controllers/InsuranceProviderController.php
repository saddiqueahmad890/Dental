<?php

namespace App\Http\Controllers;

use App\Models\InsuranceProvider;
use App\Models\UserLogs;
use Illuminate\Http\Request;

class InsuranceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $insuranceProviders=InsuranceProvider::orderBy('id', 'desc')->paginate(10);
        return view('insurance-provider.index',compact('insuranceProviders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('insurance-provider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        $Data = $request->only(['name', 'email', 'phone','website','address', 'rating']);
        $insuranceProvider=InsuranceProvider::create($Data);
        return redirect()->route('insurance-providers.edit', $insuranceProvider->id)
        ->with('success', 'Insurance provider Created successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InsuranceProvider  $insuranceProvider
     * @return \Illuminate\Http\Response
     */
    public function show(InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider= InsuranceProvider::find($insuranceProvider->id);
        return view('insurance-provider.show',compact('insuranceProvider'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InsuranceProvider  $insuranceProvider
     * @return \Illuminate\Http\Response
     */
    public function edit(InsuranceProvider $insuranceProvider)
    {
        return view('insurance-provider.edit',compact('insuranceProvider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InsuranceProvider  $insuranceProvider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InsuranceProvider $insuranceProvider)
    {
        $this->validation($request);
        $Data = $request->only(['name', 'email', 'phone','website','address', 'rating']);
        $insuranceProvider->update($Data);
        return redirect()->route('insurance-providers.edit',$insuranceProvider->id)
        ->with('success', 'Insurance provider Updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InsuranceProvider  $insuranceProvider
     * @return \Illuminate\Http\Response
     */
    public function destroy(InsuranceProvider $insuranceProvider)
    {
        $insuranceProvider->delete();
        return redirect()->route('insurance-providers.index');
    }


    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'string', 'max:14'],
            'website' => ['nullable', 'string','max:255'],
            'address' => ['nullable', 'string','max:255'],
            'rating' => ['nullable', 'numeric'],
        ]);
    }
}
