<?php
namespace App\Http\Controllers;
use App\Models\UserLogs;
use App\Models\MaritalStatus;
use Illuminate\Http\Request;

class MaritalStatusController extends Controller
{
    public function index()
    {
        $maritalStatuses = MaritalStatus::orderBy('id', 'desc')->paginate(10);
        return view('marital-status.index', compact('maritalStatuses'));
    }

    public function create()
    {
        return view('marital-status.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);
        $data= $request->all();
        $data['created_by']=auth()->id();
        $maritalStatus=MaritalStatus::create($data);
        return redirect()->route('marital-statuses.edit',$maritalStatus->id)->with('success', 'Marital Status created successfully.');
    }

    public function edit(MaritalStatus $maritalStatus)
    {


        return view('marital-status.edit', compact('maritalStatus'));
    }

    public function update(Request $request, MaritalStatus $maritalStatus)
    {
        $this->validation($request, $maritalStatus->id  );
        $data= $request->all();
        $data['updated_by']=auth()->id();
        $maritalStatus->update($data);
        return redirect()->route('marital-statuses.edit', $maritalStatus->id)->with('success', 'Marital Status updated successfully.');
    }

    public function destroy(MaritalStatus $maritalStatus)
    {
        $maritalStatus->delete();
        return redirect()->route('marital-statuses.index')->with('success', 'Marital Status deleted successfully.');
    }
    private function validation(Request $request, $id = null)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                'unique:marital_statuses,name,' . $id
            ],
        ]);
    }


}
