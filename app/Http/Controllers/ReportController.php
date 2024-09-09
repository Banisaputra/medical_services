<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// models
use App\Models\MasterDrugs;
use App\models\MasterPatients;
use App\models\ServiceHistories;


class ReportController extends Controller
{
    public function index() {
        return view('reports.index');
    }
    
    public function exportXlsx($type) 
    {
        switch ($type) {
            case 'masterDrug':
                $masterDrugs = MasterDrugs::all();

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'No.');
                $sheet->setCellValue('B1', 'Nama Obat');
                $sheet->setCellValue('C1', 'Keterangan');

                $column = 2;
                foreach ($masterDrugs as $key => $value) {
                    $sheet->setCellValue('A' . $column, ($key + 1));
                    $sheet->setCellValue('B' . $column, $value->drug_name);
                    $sheet->setCellValue('C' . $column, $value->remark);
                    $column++;
                }

                $sheet->getStyle('A1:C1')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename=master_obat_'.date("YmdHis").'.xlsx');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                exit();
                break;

            case 'masterPatient':
                $masterPatients = MasterPatients::all();

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'No.');
                $sheet->setCellValue('B1', 'Nama Pasien');
                $sheet->setCellValue('C1', 'Alamat Pasien');

                $column = 2;
                foreach ($masterPatients as $key => $value) {
                    $sheet->setCellValue('A' . $column, ($key + 1));
                    $sheet->setCellValue('B' . $column, $value->patient_name);
                    $sheet->setCellValue('C' . $column, $value->patient_address);
                    $column++;
                }

                $sheet->getStyle('A1:C1')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename=master_patient_'.date("YmdHis").'.xlsx');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                exit();
                break;
            case 'serviceHistory':
                $servHistory = ServiceHistories::latest()->get();
                $serviceHistories = [];
                foreach ($servHistory as $key => $history) {
                    $patient = $history->patient;
                    // get drug history
                    $drugPrescription = MasterDrugs::whereIn('id', explode(",", $history->medical_prescription))->get();
                    $drugHistory = "";
                    foreach ($drugPrescription as $drug) {
                        $drugHistory .= "- " .$drug->drug_name. "\n";
                    }
                    $serviceHistories[$key] = (object) [
                        'id' => $history->id,
                        'patient_name' => $patient->patient_name,
                        'date_service' => $history->created_at->format('d/m/Y'),
                        'diagnosis' => $history->diagnosis,
                        'drug_history' => $drugHistory,
                    ];
                }

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'No.');
                $sheet->setCellValue('B1', 'Nama Pasien');
                $sheet->setCellValue('C1', 'Tanggal Periksa');
                $sheet->setCellValue('D1', 'Diagnosis');
                $sheet->setCellValue('E1', 'Resep Obat');

                $column = 2;
                foreach ($serviceHistories as $key => $value) {
                    $sheet->setCellValue('A' . $column, ($key + 1))->getStyle('A' . $column)->getAlignment()->setVertical('top');
                    $sheet->setCellValue('B' . $column, $value->patient_name)->getStyle('B' . $column)->getAlignment()->setVertical('top');
                    $sheet->setCellValue('C' . $column, $value->date_service)->getStyle('C' . $column)->getAlignment()->setVertical('top');
                    $sheet->setCellValue('D' . $column, $value->diagnosis)->getStyle('D' . $column)->getAlignment()->setVertical('top');
                    $sheet->setCellValue('E' . $column, $value->drug_history)->getStyle('E' . $column)->getAlignment()->setWrapText(true);
                    $column++;
                }

                $sheet->getStyle('A1:E1')->getFont()->setBold(true);
                $sheet->getColumnDimension('A')->setAutoSize(true);
                $sheet->getColumnDimension('B')->setAutoSize(true);
                $sheet->getColumnDimension('C')->setAutoSize(true);
                $sheet->getColumnDimension('D')->setAutoSize(true);
                $sheet->getColumnDimension('E')->setAutoSize(true);

                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename=service_histories_'.date("YmdHis").'.xlsx');
                header('Cache-Control: max-age=0');
                $writer->save('php://output');
                exit();
                break;

            default:
                return redirect('/report')->with('error', 'Invalid type provided');
                break;
        }
    }

    public function exportPDF($type) {
        switch ($type) {
            case 'masterDrug':
                $masterDrugs = MasterDrugs::all();
                $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'FOLIO-P']);

                $data = [
                    'masterDrugs' => $masterDrugs
                ];
                $html = view('export_templates.master_drugs', $data);
                $mpdf->writeHTML(utf8_encode($html));
                // $this->response->setContentType('application/pdf');
                $mpdf->Output('master_drugs.pdf','I');
                break;

            case 'masterPatient':
                $masterPatients = MasterPatients::all();
                $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'FOLIO-P']);

                $data = [
                    'masterPatients' => $masterPatients
                ];
                $html = view('export_templates.master_patients', $data);
                $mpdf->writeHTML(utf8_encode($html));
                // $this->response->setContentType('application/pdf');
                $mpdf->Output('master_patients.pdf','I');
                break;
            
            case 'serviceHistory':
                $servHistories = ServiceHistories::all();
                $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'FOLIO-P']);
                $serviceHistories = [];
                foreach ($servHistories as $key => $history) {
                    $patient = $history->patient;
                    // get drug history
                    $drugPrescription = MasterDrugs::whereIn('id', explode(",", $history->medical_prescription))->get();
                    $drugHistory = "";
                    foreach ($drugPrescription as $drug) {
                        $drugHistory .= "- " .$drug->drug_name. "<br/>";
                    }
                    $serviceHistories[$key] = (object) [
                        'id' => $history->id,
                        'patient_name' => $patient->patient_name,
                        'date_service' => $history->created_at->format('d/m/Y'),
                        'diagnosis' => $history->diagnosis,
                        'drug_history' => $drugHistory,
                    ];
                }

                $data = [
                    'serviceHistories' => $serviceHistories
                ];
                $html = view('export_templates.service_histories', $data);
                $mpdf->writeHTML(utf8_encode($html));
                // $this->response->setContentType('application/pdf');
                $mpdf->Output('service_histories.pdf','I');
                break;
            
            default:
                return redirect('/report')->with('error', 'Invalid type provided');
                break;
        }
    }
    public function import() 
    {
        Excel::import(new DrugImport, request()->file('file'));
            
        return back();
    }
}
