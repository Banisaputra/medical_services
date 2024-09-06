<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Models\MasterDrugs;

class MasterDrugController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = MasterDrugs::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('masterObat.edit', $row->id);
                    $deleteUrl = route('masterObat.destroy', $row->id);
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
    
        return view('master_drugs.index');

    }

    public function create() {
        return view('master_drugs.create');
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'drug_name' => 'required|string|max:255',
            'remark' => 'required|string',
        ]);
        MasterDrugs::create($validated);
        if(isset($request->is_service) && $request->is_service == 1) {
            return redirect()->back()->with('success', 'Obat baru berhasil ditambahkan');
        }
        return redirect()->route('masterObat.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id) {
        $item = MasterDrugs::find($id);
        return view('master_drugs.edit', compact('item'));
    }

    public function update(Request $request, $id) {
        // Validate the incoming request data
        $validated = $request->validate([
            'drug_name' => 'required|string|max:255',
            'remark' => 'required|string',
        ]);

        // MasterDrugs::find($id)->update($request->all());
        $item = MasterDrugs::findOrFail($id);
        $item->update($validated);

        return redirect()->route('masterObat.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id) {
        $item = MasterDrugs::findOrFail($id);
        $item->delete();
        return redirect()->route('masterObat.index')->with('success', 'Data berhasil dihapus');
    }
}
