<?php

namespace App\Http\Controllers\Report;

use App\Attendance;
use App\Classes;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Phpoffice\phpspreadsheet\Writer\Xlsx;


class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('db');
        $this->middleware('auth');
    }
    public function dailyReport(Request $request){
        try{
             return view('report.dailyAttendanceReport');
        }catch (\Exception $e){
            $data=[
                'action' => 'Gallery folder view',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function dailyReportDateData(Request $request){
        try{
            $date = date("F j, Y,  g:i a");
            $reportTitle = "Daily Attendance Report ";
            $name = "daily_attendance $date.xlsx";
            $attendanceData = array();
            $attendanceData['date'] = $request->date;
            $attendanceData['day'] = date('l',strtotime($request->date));
            $data[] = array();
            $attendanceData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                ->where('classes.body_id',$request->body_id)
                ->select('classes.class_name','divisions.division_name','divisions.id')
                ->get()->toArray();
            $iterator = $final['grand_total_present_boys'] = $final['grand_total_present_girls'] = $final['grand_total_present_total'] = 0;
            $final['grand_total_absent_boys'] = $final['grand_total_absent_girls'] = $final['grand_total_absent_total'] = 0;
            $final['grand_total_boys'] = $final['grand_total_girls'] = $final['grand_total'] = 0;
            foreach ($attendanceData['class_division'] as $value){
                $totalPresent = Attendance::where('date',$request->date)->where('division_id',$value['id'])->lists('student_id');
                $data[$iterator]['sr_number'] = $iterator + 1;
                $data[$iterator]['class'] = $value['class_name'];
                $data[$iterator]['division'] = $value['division_name'];
                $data[$iterator]['present_boys'] = User::whereIn('id',$totalPresent)->where('gender','M')->count();
                $data[$iterator]['present_girls'] = User::whereIn('id',$totalPresent)->where('gender','F')->count();
                $data[$iterator]['present_total'] = $data[$iterator]['present_boys'] + $data[$iterator]['present_girls'];
                $data[$iterator]['absent_boys'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('gender','M')->count();
                $data[$iterator]['absent_girls'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('gender','F')->count();
                $data[$iterator]['absent_total'] = $data[$iterator]['absent_boys'] + $data[$iterator]['absent_girls'];
                $data[$iterator]['total_boys'] = User::where('division_id',$value['id'])->where('gender','M')->count();
                $data[$iterator]['total_girls'] = User::where('division_id',$value['id'])->where('gender','F')->count();
                $data[$iterator]['total_of_total'] = $data[$iterator]['total_boys'] + $data[$iterator]['total_girls'];
                $data[$iterator]['teacher_sign'] = "";
                $final['grand_total_present_boys'] += $data[$iterator]['present_boys'];
                $final['grand_total_present_girls'] += $data[$iterator]['present_girls'];
                $final['grand_total_present_total'] += $data[$iterator]['present_total'];
                $final['grand_total_absent_boys'] += $data[$iterator]['absent_boys'];
                $final['grand_total_absent_girls'] += $data[$iterator]['absent_girls'];
                $final['grand_total_absent_total'] += $data[$iterator]['absent_total'];
                $final['grand_total_boys'] += $data[$iterator]['total_boys'];
                $final['grand_total_girls'] += $data[$iterator]['total_girls'];
                $final['grand_total'] += $data[$iterator]['total_of_total'];
                $iterator++;
            }
            $rows[0] = array("Sr.No.","Std","Div","Boys","Girls","Total","Boys","Girls","Total","Boys","Girls","Total","Teacher's Sign");
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
            $column = 'A';
            $rowNumber = 4;
            $rowIndex = 5;
            // Merging Cells
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:M1")
                ->mergeCells("A2:G2")
                ->mergeCells("H2:M2")
                ->mergeCells('A3:A4')
                ->mergeCells('B3:B4')
                ->mergeCells('C3:C4')
                ->mergeCells('M3:M4')
                ->mergeCells('D3:F3')
                ->mergeCells('G3:I3')
                ->mergeCells('J3:L3');
            //Setting Values for the new merged cells
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A1', 'Daily Attendance of Pupils')
                ->setCellValue('A2', "Day: ".$attendanceData['day'])
                ->setCellValue('H2', "Date: ".$attendanceData['date'])
                ->setCellValue('A3','Sr. No')
                ->setCellValue('B3','Class')
                ->setCellValue('C3','Div')
                ->setCellValue('M3','Teachers Sign')
                ->setCellValue('D3','No. of Present')
                ->setCellValue('G3','No. of Absent')
                ->setCellValue('J3','Total');
            $boldText = array(
                'font' => array(
                    'bold' => true,
                    'size'  => 20,
                    'name'  => 'oblique'
                )
            );
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => \PHPExcel_Style_Border::BORDER_THIN
                    ),
                )
            );
            $objPHPExcel->getActiveSheet()
                ->getStyle('A1:M1')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A2:G2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('H2:M2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A3:A4')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('B3:B4')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('C3:C4')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('M3:M4')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('D3:F3')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('G3:I3')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('J3:L3')->applyFromArray($styleArray,$boldText);
            foreach ($rows as $row) {
                $objPHPExcel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(-1);
                foreach ($row as $singleRow) {
                    /* Align Center */
                    $objPHPExcel->getActiveSheet()
                        ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())
                        ->getAlignment()
                        ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);
                    /* Set Cell Width */
                    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(11);
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowNumber, $singleRow);
                    $column++;
                }
                $column = "A";
                $rowNumber++;
            }
            foreach($data as $key => $datavalues) {
                $columnForData = 0;
                foreach($datavalues as $datavalue => $value){

                    /* Align Center */
                    $objPHPExcel->getActiveSheet()
                        ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())
                        ->getAlignment()
                        ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnForData,$rowIndex,$value);
                    $columnForData++;
                }
                $rowIndex++;
            }

            $rowIndex = $rowIndex +1;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$rowIndex:C$rowIndex");
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A$rowIndex", 'Total');
            $objPHPExcel->getActiveSheet()
                ->getStyle("A$rowIndex:C$rowIndex")->applyFromArray($styleArray,$boldText);


            $objPHPExcel->getActiveSheet()
                ->getStyle("D4:L4")->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle("D$rowIndex:L$rowIndex")->applyFromArray($styleArray,$boldText);

            $columnForData = 3;
            foreach ($final as $key => $values){
                        $objPHPExcel->getActiveSheet()
                        ->getStyle($objPHPExcel->getActiveSheet()->calculateWorksheetDimension())
                        ->getAlignment()
                        ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                        ->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER)
                        ->setWrapText(true);
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columnForData,$rowIndex,$values);
                    $columnForData++;
            }
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            ob_end_clean();
            $objWriter->save("php://output");
            exit();

        }catch (\Exception $e){
            $data=[
                'action' => 'Excel Sheet Generated',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
}

