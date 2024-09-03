<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\Datatables;
use App\Models\ServiceHistories;
use App\Models\MasterDrugs;
use App\Models\MasterPatients;

class ServiceHistoryController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $histories = ServiceHistories::latest()->get();
            $data = [];
            // get data pasien dengan riwayat pengobatan
            foreach ($histories as $key => $history) {
                $patient = $history->patient;
                // get drug history
                $drugPrescription = MasterDrugs::whereIn('id', explode(",", $history->medical_prescription))->get();
                $drugHistory = "";
                foreach ($drugPrescription as $drug) {
                    $drugHistory .= "- " .$drug->drug_name. "<br>";
                }
                $data[$key] = (object) [
                    'id' => $history->id,
                    'patient_name' => $patient->patient_name,
                    'diagnosis' => $history->diagnosis,
                    'drug_history' => $drugHistory,
                ];
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $editUrl = route('serviceHistory.edit', $row->id);
                    $deleteUrl = route('serviceHistory.destroy', $row->id);
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
                ->rawColumns(['action','drug_history'])
                ->make(true);
        }
    
        return view('service_histories.index');

    }

    public function patient(Request $request) {
        $search = $request->get('keyword');

        $options = MasterPatients::where('patient_name', 'like', '%' . $search . '%')->get();

        return response()->json($options);
    }
    public function drug(Request $request) {
        $search = $request->get('keyword');

        $options = MasterDrugs::where('drug_name', 'like', '%' . $search . '%')->get();

        return response()->json($options);
    }

    public function create() {
        return view('service_histories.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'patient_id' => 'required|numeric',
            'diagnosis' => 'required|string|max:255',
            'medical_prescription' => 'required|array',
        ]);

        $data = [
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'medical_prescription' => implode(',', $request->medical_prescription),
        ];
        ServiceHistories::create($data);
        return redirect()->route('serviceHistory.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(Request $request, $id) {
        $data = ServiceHistories::find($id);
        if($request->ajax()) {
            $drugHistory =[];
            $drugPrescription = MasterDrugs::whereIn('id', explode(",", $data->medical_prescription))->get();
            foreach ($drugPrescription as $key => $value) {
               $drugHistory[] = [
                    'id' => $value->id,
                    'drug_name' => $value->drug_name,
               ];
            }

            $result = [
                'id' => $id,
                'patient_id' => $data->patient_id,
                'patient_name' => $data->patient->patient_name,
                'diagnosis' => $data->diagnosis,
                'medical_prescription' => explode(',', $data->medical_prescription),  // convert string to array for view in edit form
                'drug_history' => $drugHistory
            ];
            return response()->json($result);
        }
        return view('service_histories.edit', compact('data'));
    }

    public function update(Request $request, $id) {
        // dd($id);
        // Validate the incoming request data
        $validated = $request->validate([
            'patient_id' => 'required|numeric',
            'diagnosis' => 'required|string|max:255',
            'medical_prescription' => 'required|array',
        ]);
        $data = [
            'patient_id' => $request->patient_id,
            'diagnosis' => $request->diagnosis,
            'medical_prescription' => implode(',', $request->medical_prescription),
        ];
        // ServiceHistories::find($id)->update($request->all());
        $item = ServiceHistories::findOrFail($id);
        $item->update($data);

        return redirect()->route('serviceHistory.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id) {
        $item = ServiceHistories::findOrFail($id);
        $item->delete();
        return redirect()->route('serviceHistory.index')->with('success', 'Data berhasil dihapus');
    }
}
