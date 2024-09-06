<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Models\MasterPatients;

class MasterPatientController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = MasterPatients::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('masterPatient.edit', $row->id);
                    $deleteUrl = route('masterPatient.destroy', $row->id);
                    $csrfToken = csrf_field(); 
                    $methodField = method_field('DELETE');
            
                    $actionBtn = "
                        <a href='{$editUrl}' class='edit btn btn-success btn-sm'>Edit</a>
                        <form action='{$deleteUrl}' method='POST' style='display:inline;' onsubmit='return confirmDelete()'>
                            {$csrfToken}
                            {$methodField}
                            <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                        </form>";
            
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        return view('master_patients.index');

    }

    public function create() {
        return view('master_patients.create');
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_address' => 'required|string',
        ]);

        MasterPatients::create($validated);
        if(isset($request->is_service) && $request->is_service == 1) {
            return redirect()->back()->with('success', 'Pasien baru berhasil ditambahkan');
        }
        return redirect()->route('masterPatient.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id) {
        $item = MasterPatients::find($id);
        return view('master_patients.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        // Validate the incoming request data
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_address' => 'required|string',
        ]);
        
        // MasterPatients::find($id)->update($request->all());
        $item = MasterPatients::findOrFail($id);
        $item->update($validated);

        return redirect()->route('masterPatient.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id) {
        $item = MasterPatients::findOrFail($id);
        $item->delete();
        return redirect()->route('masterPatient.index')->with('success', 'Data berhasil dihapus');
    }
}
