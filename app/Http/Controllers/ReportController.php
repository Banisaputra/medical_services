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
                $serviceHistories = ServiceHistories::all();

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'No.');
                $sheet->setCellValue('B1', 'Nama Pasien');
                $sheet->setCellValue('C1', 'Tanggal Periksa');
                $sheet->setCellValue('D1', 'Diagnosis');
                $sheet->setCellValue('E1', 'Resep Obat');

                $column = 2;
                foreach ($serviceHistories as $key => $value) {
                    $sheet->setCellValue('A' . $column, ($key + 1));
                    $sheet->setCellValue('B' . $column, $value->patient->patient_name);
                    $sheet->setCellValue('C' . $column, $value->created_at->format('d-m-Y'));
                    $sheet->setCellValue('D' . $column, $value->diagnosis);
                    $sheet->setCellValue('E' . $column, $value->medical_prescription);
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
