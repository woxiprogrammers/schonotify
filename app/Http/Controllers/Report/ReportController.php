<?php

namespace App\Http\Controllers\Report;
use App\Attendance;
use App\Batch;
use App\Classes;
use App\Division;
use App\Homework;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                'action' => 'Daily Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function dailyReportDateData(Request $request){
        try{
            $date = date("F j, Y");
            $reportTitle = "Daily Attendance Report ";
            $name = "daily_attendance $date.xlsx";
            $attendanceData = array();
            $attendanceData['date'] = $request->date;
            $attendanceData['day'] = date('l',strtotime($request->date));
            $data[] = array();
            $attendanceData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                ->where('classes.body_id',$request->body_id)
                ->select('classes.class_name','divisions.division_name','divisions.id','classes.id as class_id')
                ->get()->toArray();
            $iterator = $final['grand_total_present_boys'] = $final['grand_total_present_girls'] = $final['grand_total_present_total'] = 0;
            $final['grand_total_absent_boys'] = $final['grand_total_absent_girls'] = $final['grand_total_absent_total'] = 0;
            $final['grand_total_boys'] = $final['grand_total_girls'] = $final['grand_total'] = 0;
            foreach ($attendanceData['class_division'] as $value){
                $totalPresent = Attendance::where('date',$request->date)->where('division_id',$value['id'])->lists('student_id');
                $data[$iterator]['sr_number'] = $iterator + 1;
                $data[$iterator]['class'] = $value['class_name'];
                $data[$iterator]['division'] = $value['division_name'];
                $data[$iterator]['present_boys'] = User::whereIn('id',$totalPresent)->where('is_active',1)->where('gender','M')->count();
                $data[$iterator]['present_girls'] = User::whereIn('id',$totalPresent)->where('is_active',1)->where('gender','F')->count();
                $data[$iterator]['present_total'] = $data[$iterator]['present_boys'] + $data[$iterator]['present_girls'];
                $data[$iterator]['absent_boys'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('is_active',1)->where('gender','M')->count();
                $data[$iterator]['absent_girls'] = User::where('division_id',$value['id'])->whereNotIn('id',$totalPresent)->where('is_active',1)->where('gender','F')->count();
                $data[$iterator]['absent_total'] = $data[$iterator]['absent_boys'] + $data[$iterator]['absent_girls'];
                $data[$iterator]['total_boys'] = User::where('division_id',$value['id'])->where('is_active',1)->where('gender','M')->count();
                $data[$iterator]['total_girls'] = User::where('division_id',$value['id'])->where('is_active',1)->where('gender','F')->count();
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
                ->setCellValue('H2', "Date: ".date('d/m/Y',strtotime($attendanceData['date'])))
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
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
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
    public function monthlyReport(Request $request){
        try{
            $batches = Batch::where('body_id',Auth::user()->body_id)->get();
            return view('report.monthlyAttendanceReport')->with(compact('batches'));
        }catch (\Exception $e){
            $data=[
                'action' => 'Monthly Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }
    public function generateMonthlyReport(Request $request){
        try{
            $reportDate = date("F j, Y");
            $reportTitle = "Classwise Monthly Report ";
            $name = "classwise_monthly_attendance $reportDate.xlsx";
            $month = date('F',strtotime($request->month_select));
            $className = Classes::where('id',$request->class_select)->pluck('class_name');
            $divisionName = Division::where('id',$request->div_select)->pluck('division_name');
            $students = User::WhereIn('users.id',$request->student_name)->orderBy('roll_number')->select('id','first_name','last_name','roll_number')->get()->toArray();
            $first_day = date('Y-m-d',mktime(0,0,0,$request->month_select,1,$request->year_select));
            $last_day = date('Y-m-t',mktime(0,0,0,$request->month_select,1,$request->year_select));
            $start_time = strtotime($first_day);
            $end_time = strtotime($last_day);
            $iterator = 0;
            $current_date = array();
            $current_date_words = array();
            $date = array();
            while($start_time <= $end_time){
                    $this_date = date('d',$start_time);
                    $this_date_words = date('D',$start_time);
                    $date[$iterator] = date('Y-m-d',$start_time);
                    $current_date[$iterator] = $this_date ;
                    $current_date_words[$iterator] = $this_date_words;
                    $start_time = strtotime('+1day',$start_time);
                    $iterator ++;
            }
            $iterator = 0;
            $monthlyData = array();
            foreach ($students as $key => $value) {
            $monthlyData[$iterator]['roll_number'] = $value['roll_number'];
            $monthlyData[$iterator]['name'] = $value['first_name']." ".$value['last_name'];
            $jIterator = 0;
            $totalDays = count($date);
            $presentDays = 0;
            $absentDays = 0;
            $sunDays = 0;
            $holiDays = 0;
            foreach ($date as $item => $currentdate){
                $holiday = Attendance::where('date',$currentdate)->where('division_id',$request->div_select)->count();
                $sunday = date('D',strtotime($currentdate));
                $present[$jIterator]['present'] = Attendance::where('student_id',$value['id'])->where('date',$currentdate)->where('status',1)->count();
                if($present[$jIterator]['present'] == 0 && $sunday == "Sun"){
                    $monthlyData[$iterator][$currentdate] = ".";
                    $sunDays ++;
                }elseif($holiday == 0 && $sunday != "Sun"){
                    $monthlyData[$iterator][$currentdate] = "XX";
                    $holiDays ++;
                }elseif($present[$jIterator]['present'] == 0 && $sunday != "Sun" ){
                    $monthlyData[$iterator][$currentdate] = "A";
                    $absentDays ++;
                }else{
                    $monthlyData[$iterator][$currentdate] = "P";
                    $presentDays ++;
                }
                $jIterator ++;
            }
            $monthlyData[$iterator]['total_days'] = $totalDays - $sunDays;
            $monthlyData[$iterator]['total_present'] = $presentDays;
            $monthlyData[$iterator]['total_absent'] = $absentDays;
            $monthlyData[$iterator]['holidays'] = $holiDays + $sunDays;
            $iterator ++;
           }
            $rows = array(
                array_merge(array("Roll.No","Student Name"),$current_date,array("Total days","Present Days","Absent Days","Holidays"))
            );
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
            $rowIndex = 5;
            $rowNumber = 4;
            $column = "A";
            //merging cells
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:AK1")
                                                ->mergeCells("A2:G2")
                                                ->mergeCells("H2:R2")
                                                ->mergeCells("S2:Z2")
                                                ->mergeCells("AA2:AK2")
                                                ->mergeCells("A3:A4")
                                                ->mergeCells("B3:B4");
            //Setting Values for the new merged cells
            $objPHPExcel->getActiveSheet()
                ->setCellValue('A1', 'Classwise Monthly Report')
                ->setCellValue('A2', "Year : $request->year_select")
                ->setCellValue('H2', "Month : $month")
                ->setCellValue('S2', "Class : $className")
                ->setCellValue('AA2', "Division : $divisionName")
                ->setCellValue('A3', "Roll No.")
                ->setCellValue('B3', "Student Name");
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
                ->getStyle('A1:AK1')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A2:G2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('H2:R2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('S2:Z2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('AA2:AK2')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('A3:A4')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle('B3:B4')->applyFromArray($styleArray,$boldText);


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
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(6);
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowNumber, $singleRow);
                    $column++;
                }
                $column = "A";
                $rowNumber++;
            }
            $array_date_in_word = array($current_date_words);
            $rowNumber = 3;
            foreach ($array_date_in_word as $row) {
                $column = "C";
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
                    $objPHPExcel->getActiveSheet()->getColumnDimension($column)->setWidth(6);
                    $objPHPExcel->getActiveSheet()->setCellValue($column . $rowNumber, $singleRow);
                    $column++;
                }
                $rowNumber++;
            }

            $objPHPExcel->getActiveSheet()
                ->getStyle("C3:$column"."3")->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle("C4:$column"."4")->applyFromArray($styleArray,$boldText);

            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("$column"."3:$column"."4");

            $objPHPExcel->getActiveSheet()
                ->setCellValue("$column"."3", 'Total days');

            $objPHPExcel->getActiveSheet()
                ->getStyle("$column"."3:$column"."3")->applyFromArray($styleArray,$boldText);

            foreach($monthlyData as $key => $datavalues) {
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
            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
            $objWriter->save("php://output");
            exit();
        }catch(\Exception $exception){
            $data=[
                'action' => 'Excel Sheet Generated',
                'message' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }
    public function getAllStudents(Request $request,$division_id,$class_id,$batch_id){
        try{
            $students = User::join('divisions','divisions.id','=','users.division_id')
                ->join('classes','classes.id','=','divisions.class_id')
                ->join('batches','batches.id','=','classes.batch_id')
                ->where('users.is_active',1)
                ->where('batches.id','=',$batch_id)
                ->where('classes.id','=',$class_id)
                ->where('divisions.id','=',$division_id)
                ->orderBy('users.roll_number')
                ->select('users.first_name','users.last_name','users.id')->get();
            $students_list = array();
            $iterator = 0;
            foreach ($students as $student){
                $students_list[] =
                  '<li  class="list-group-item"><input type="checkbox"  class="studentCheck" name="student_name['.$iterator.']" value="'.$student['id'].'">'.$student['first_name'].' '.$student['last_name'].' </li>'
                ;
                $iterator++;
            }
            return $students_list;
        }catch (\Exception $exception){
            $data=[
                'action' => 'All student list',
                'message' => $exception->getMessage()
            ];
            Log::critical(json_encode($data));
        }

    }

    public function allStudentReportView(Request $request){
        try{
            $user = Auth::user();
            $batches = Batch::where('body_id',$user->body_id)->select('id','name')->get()->toArray();
            return view('report.allStudentReport')->with(compact('batches'));
        }catch (\Exception $e){
            $data=[
                'action' => 'Daily Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function allStudentReport(Request $request){
        try{
            $date = date("F j, Y");
            $reportTitle = "All Student Report ";
            $name = "all students $date.xlsx";
            $classDivData = array();
            $classDivData['date'] = $request->date;
            $classDivData['day'] = date('l',strtotime($request->date));
            $data[] = array();
            /*$classDivData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                ->where('classes.body_id',$request->body_id)
                ->select('classes.class_name','divisions.division_name','divisions.id','classes.id as class_id')
                ->get()->toArray();*/
            if(empty($request->Divisiondropdown)){
                $classDiv = Classes::where('id',$request->Classdropdown)
                    ->select('class_name')->get();
                $classDivData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                    ->where('classes.body_id',$request->body_id)
                    ->where('classes.id',$request->Classdropdown)
                    ->lists('divisions.id');
            }else{
                $classDiv = Classes::join('divisions','divisions.class_id','=','classes.id')
                    ->where('classes.body_id',$request->body_id)
                    ->where('classes.id',$request->Classdropdown)
                    ->where('divisions.id',$request->Divisiondropdown)
                    ->select('classes.class_name','divisions.division_name')->get();
                $classDivData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                    ->where('classes.body_id',$request->body_id)
                    ->where('classes.id',$request->Classdropdown)
                    ->where('divisions.id',$request->Divisiondropdown)
                    ->lists('divisions.id');
            }

            $data = User::join('parent_extra_info','users.parent_id','=','parent_extra_info.parent_id')
                ->join('students_extra_info','users.id','=','students_extra_info.student_id')
                ->where('users.role_id','=',3)
                ->whereIn('users.division_id',$classDivData['class_division'])
                ->select('users.parent_id','students_extra_info.grn',DB::raw("CONCAT(users.first_name,' ',users.last_name) as student_name"),'users.gender','users.roll_number',DB::raw("CONCAT(parent_extra_info.father_first_name,' ',parent_extra_info.father_last_name) as father_name"),DB::raw("CONCAT(parent_extra_info.mother_first_name,' ',parent_extra_info.mother_last_name) as mother_name"),'users.birth_date','parent_extra_info.parent_email','students_extra_info.religion','students_extra_info.caste','students_extra_info.category','users.mobile','users.alternate_number','users.address','students_extra_info.aadhar_number','students_extra_info.blood_group')
                ->get()->toArray();

            $i = 0;
            foreach ($data as $studentInfo){
                $data[$i]['parent_email'] = User::where('id',$studentInfo['parent_id'])->value('email');
                $data[$i]['alternate_number'] = User::where('id',$studentInfo['parent_id'])->value('alternate_number');
                $data[$i] = array_except($data[$i],'parent_id');
                $i++;
            }

            $rows[0] = array("GRN No.","Student Name","Gender","Roll No.","Father's Name","Mother's Name","Date of Birth","Email","Religion","Caste","Category","Contact No.","Alternative No.","Address","Aadhar Card","Blood Group");
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
            $column = 'A';
            $rowNumber = 3;
            $rowIndex = 4;
            // Merging Cells
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:P1");
            //Setting Values for the new merged cells
            if(empty($request->Divisiondropdown)){
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A1', 'All Student Report : '.$classDiv[0]['class_name']);
            }else{
                $objPHPExcel->getActiveSheet()
                    ->setCellValue('A1', 'All Student Report : '.$classDiv[0]['class_name'].'-'.$classDiv[0]['division_name']);
            }
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
                ->getStyle('A1:P1')->applyFromArray($styleArray,$boldText);
            $objPHPExcel->getActiveSheet()
                ->getStyle("A3:P3")->applyFromArray($styleArray,$boldText);
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("35");
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("35");
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("35");
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("15");
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("100");
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("20");
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

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
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

    public function classWiseHomeworkView(Request $request){
        try{
            return view('report.classWisePerDayHomework');
        }catch (\Exception $e){
            $data=[
                'action' => 'Daily Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function classWiseHomework(Request $request){
        try{
            $date = date("F j, Y");
            $reportTitle = "Class Wise Per Day Homework";
            $name = "class wise home work $date.xlsx";
            $classDivData = array();
            $data[] = array();
            $classDivData['class_division'] = Classes::join('divisions','divisions.class_id','=','classes.id')
                ->where('classes.body_id',$request->body_id)
                ->select('classes.class_name','divisions.division_name','divisions.id','classes.id as class_id')
                ->get()->toArray();
            $iterator = 0;
            foreach ($classDivData['class_division'] as $value){
                $data[$iterator]['div'] = Homework::join('homework_teacher','homework_teacher.homework_id','=','homeworks.id')
                                ->join('users','users.id','=','homework_teacher.teacher_id')
                                ->join('subjects','subjects.id','=','homework_teacher.student_id')
                                ->whereDate('homeworks.created_at','=',$request->date)
                                ->where('homework_teacher.division_id',$value['id'])
                                ->select('subjects.subject_name',DB::raw("CONCAT(users.first_name,' ',users.last_name) as teacher_name"),'homeworks.title','homeworks.description','homeworks.due_date')
                                ->get()->toArray();
                $iterator++;
            }
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
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
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:E1");
            //Setting Values for the new merged cells
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A1",$request->date);
            $objPHPExcel->getActiveSheet()
                ->getStyle("A1:E1")->applyFromArray($styleArray,$boldText);

            $iteratorK = 1;
            $index = 0;
            foreach ($data as $divData){
                if(!empty($divData['div'])){
                    $iteratorK = $iteratorK + 1;
                    $column = 'A';
                    $rowNumber = $iteratorK+1;
                    $rowIndex =$iteratorK + 2;
                    $rows[$rowNumber] = array("Subject","Teacher Name","Title","Description","Due Date");
                    // Merging Cells
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$iteratorK:E$iteratorK");
                    //Setting Values for the new merged cells
                    $objPHPExcel->getActiveSheet()
                        ->setCellValue("A$iteratorK", $classDivData['class_division'][$index]['class_name'].' - '.$classDivData['class_division'][$index]['division_name']);
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$iteratorK:E$iteratorK")->applyFromArray($styleArray,$boldText);
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$rowNumber:E$rowNumber")->applyFromArray($styleArray,$boldText);
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
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("25");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("70");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("90");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");
                    $rowData = $divData['div'];
                    $iteratorK = $iteratorK+2;
                    foreach($rowData as $key => $datavalues) {
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
                        $iteratorK++;
                    }
                }
                $index++;
            }

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
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

    public function allTeachersReportsView(Request $request){
        try{
            return view('report.allTeacherReport');
        }catch (\Exception $e){
            $data=[
                'action' => 'Daily Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function allTeachersReports(Request $request){
        try{
            $date = date("F j, Y");
            $reportTitle = "All Teacher Report";
            $name = "all teacher report $date.xlsx";
            $data[] = array();
            $enableDisableStatus = array(true,false);
            $iterator = 0;
            foreach ($enableDisableStatus as $status){
                $data[$iterator]['teacher'] = User::join('teacher_extra_info','users.id','=','teacher_extra_info.teacher_id')
                    ->where('users.is_active',$status)
                    ->where('users.body_id',$request->body_id)
                    ->where('users.id','<',1000)
                    ->select('users.emp_type',DB::raw("CONCAT(users.first_name,' ',users.last_name) as teacher_name"),DB::raw("CONCAT(teacher_extra_info.spouse_first_name,' ',teacher_extra_info.spouse_last_name) as spouse_name"),'users.gender','teacher_extra_info.designation','users.birth_date',
                        'teacher_extra_info.martial_status','users.email','users.mobile','users.alternate_number','users.address','teacher_extra_info.aadhar_number','teacher_extra_info.pan_card','users.id')
                    ->get()->toArray();
                $iterator++;
            }
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
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
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:N1");
            //Setting Values for the new merged cells
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A1",$request->date);
            $objPHPExcel->getActiveSheet()
                ->getStyle("A1:N1")->applyFromArray($styleArray,$boldText);

            $iteratorK = 0;
            $index = 0;
            foreach ($data as $teacherData){
                if(!empty($teacherData['teacher'])){
                    $iteratorK = $iteratorK + 1;
                    $column = 'A';
                    $rowNumber = $iteratorK+1;
                    $rowIndex =$iteratorK + 2;
                    $rows[$rowNumber] = array("Employee Code","Teacher Name","Father/Spouse Name","Gender","Designation","Date of Birth","Marital Status","Email Address","Contact No.","Alternate No.","Address","Aadhar Card No.","Pan Card No.","Blood Group");
                    // Merging Cells
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$iteratorK:N$iteratorK");
                    //Setting Values for the new merged cells
                    if($enableDisableStatus[$index] == true){
                        $objPHPExcel->getActiveSheet()
                            ->setCellValue("A$iteratorK", "Enabled Teacher List");
                    }else{
                        $objPHPExcel->getActiveSheet()
                        ->setCellValue("A$iteratorK", "Disabled Teacher List");
                    }
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$iteratorK:N$iteratorK")->applyFromArray($styleArray,$boldText);
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$rowNumber:N$rowNumber")->applyFromArray($styleArray,$boldText);
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
                        //$rowNumber++;
                    }
                    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("20");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("50");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("15");
                    $rowData = $teacherData['teacher'];
                    $iteratorK = $iteratorK+2;
                    foreach($rowData as $key => $datavalues) {
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
                        $iteratorK++;
                    }
                }
                $index++;
            }

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
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

    public function teacherWiseHomeworkView(Request $request){
        try{
            $user = Auth::User();
            $teachersData =  User::where('is_active',true)
                ->where('body_id',$user->body_id)
                ->where('role_id',2)
                ->select('id','first_name','last_name')
                ->get()->toArray();
            return view('report.teacherWiseHomework')->with(compact('teachersData'));
        }catch (\Exception $e){
            $data=[
                'action' => 'Daily Attendance Report',
                'message' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
        }
    }

    public function teacherWiseHomeworkReport(Request $request){
        try{
            //dd($request->all());
            $date = date("F j, Y");
            $reportTitle = "Teacher Wise Homework";
            $name = "teacher wise homework $date.xlsx";
            $data[] = array();
            if($request->has('from_date') && $request->from_date != ""){
                if($request->has('to_date') && $request->to_date != ""){
                    $dateData = Homework::join('homework_teacher','homeworks.id','=','homework_teacher.homework_id')
                        ->where('homework_teacher.teacher_id','=',$request->teacher)
                        ->whereDate('homeworks.created_at','>=',$request->from_date)
                        ->whereDate('homeworks.created_at','<=',$request->to_date)
                        ->distinct('homeworks.created_at')
                        ->lists('homeworks.created_at');
                }else{
                    $dateData = Homework::join('homework_teacher','homeworks.id','=','homework_teacher.homework_id')
                        ->where('homework_teacher.teacher_id','=',$request->teacher)
                        ->whereDate('homeworks.created_at','>=',$request->from_date)
                        ->distinct('homeworks.created_at')
                        ->lists('homeworks.created_at');
                }
            }else{
                $dateData = Homework::join('homework_teacher','homeworks.id','=','homework_teacher.homework_id')
                    ->where('homework_teacher.teacher_id','=',$request->teacher)
                    ->distinct('homeworks.created_at')
                    ->lists('homeworks.created_at');
            }
            foreach($dateData as $datum){
               $homeworksDates[] = explode(' ',$datum)[0];
            }
            $iterator = 0;
            foreach ($homeworksDates as $homeworkDate){
                $data[$iterator]['homework_date'] = Homework::join('homework_teacher','homeworks.id','=','homework_teacher.homework_id')
                    ->join('divisions','homework_teacher.division_id','=','divisions.id')
                    ->join('classes','divisions.class_id','=','classes.id')
                    ->join('subjects','homeworks.subject_id','=','subjects.id')
                    ->where('homework_teacher.teacher_id','=',$request->teacher)
                    ->whereDate('homeworks.created_at','=',$homeworkDate)
                    ->distinct('homeworks.id')
                    ->select('classes.class_name','divisions.division_name','subjects.subject_name','homeworks.title','homeworks.description','homeworks.due_date')
                    ->get()->toArray();
                $iterator++;
            }
            $objPHPExcel = new \PHPExcel();
            $objWorkSheet = $objPHPExcel->createSheet();
            $objPHPExcel->getSheet(0)->setTitle($reportTitle);
            $objPHPExcel->setActiveSheetIndex(0);
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
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:F1");
            //Setting Values for the new merged cells
            $objPHPExcel->getActiveSheet()
                ->setCellValue("A1",$request->date);
            $objPHPExcel->getActiveSheet()
                ->getStyle("A1:F1")->applyFromArray($styleArray,$boldText);

            $iteratorK = 1;
            $index = 0;
            foreach ($data as $teacherHomeworkData){
                if(!empty($teacherHomeworkData['homework_date'])){
                    $column = 'A';
                    $iteratorK++;
                    $rowNumber = $iteratorK+1;
                    $rowIndex =$iteratorK + 2;
                    $rows[$rowNumber] = array("Class","Division","Subject","Title","Description","Due Date");
                    // Merging Cells
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$iteratorK:F$iteratorK");
                    //Setting Values for the new merged cells
                    $objPHPExcel->getActiveSheet()
                        ->setCellValue("A$iteratorK", $homeworksDates[$index]);
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$iteratorK:F$iteratorK")->applyFromArray($styleArray,$boldText);
                    $iteratorK++;
                    $objPHPExcel->getActiveSheet()
                        ->getStyle("A$rowNumber:F$rowNumber")->applyFromArray($styleArray,$boldText);
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
                        //$rowNumber++;
                    }
                    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("15");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
                    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("50");
                    $rowData = $teacherHomeworkData['homework_date'];
                    $iteratorK++;
                    foreach($rowData as $key => $datavalues) {
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
                        $iteratorK++;
                    }
                }
                $index++;
            }

            $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
            $fileName = $name;
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=\"".$fileName."\"");
            if (ob_get_length() > 0) {
                ob_end_clean();
            }
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

