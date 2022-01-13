<?php

class Attendence extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin/Attendence_m');
        $this->load->model('organization/Department_m');
        $this->load->model('organization/Staff_m');
        $this->load->model('checkin/Setsche_m');
        $this->load->model('checkin/Holiday_m');
        $this->load->model('checkin/Addition_m');
        $this->load->model('checkin/Duty_m');
        $this->load->model('checkin/Summary_m');
    }

    public function index()
    {
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = trim($this->input->get('month'));
        // $filters['start_time'] = trim($this->input->get('start_time'));
        // $filters['end_time'] = trim($this->input->get('end_time'));
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $query_filters = array();
        $machine_id_str = '';
        if($filters['staff_code']){
            $staff_array = $this->Staff_m->get_all_staff(array('staff_code'=>$filters['staff_code'], 'page'=>1, 'page_size'=>500));
            foreach ($staff_array['data'] as $key => $value) {
                $machine_id_str .= $value['machine_id'].',';
            }
            $machine_id_str = trim($machine_id_str, ',');

        }elseif($filters['dept_id']){
            $staff_array = $this->Staff_m->get_all_staff(array('dept_id'=>$filters['dept_id'], 'page'=>1, 'page_size'=>500));
            foreach ($staff_array['data'] as $key => $value) {
                $machine_id_str .= $value['machine_id'].',';
            }
            $machine_id_str = trim($machine_id_str, ',');
        }else{            
            $staff_array = $this->Staff_m->get_all_staff(array('page'=>1, 'page_size'=>500));
        }
        $staff = array();
        foreach ($staff_array['data'] as $staff_array_key => $staff_array_value) {
            $staff[$staff_array_value['machine_id']] = $staff_array_value;
        }
        $query_filters['machine_ids'] = $machine_id_str;
        $query_filters['month'] = $filters['month'];
        $query_filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $query_filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;
        $attendence = $this->Attendence_m->get_all_attendence_by_machine_ids($query_filters);       
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['total'] = $attendence['total'];
        $this->data['filters'] = $filters;
        $this->data['attendence'] = $attendence['data'];
        $this->data['query_str'] = $query_str;
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['staff'] = $staff;
        $this->load->view('checkin/attendence_list_v', $this->data);
    }

    public function expcheckin()
    {

        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = trim($this->input->get('month'));
        $query_filters = array();
        $machine_id_str = '';
        if($filters['staff_code']){
            $staff_array = $this->Staff_m->get_all_staff(array('staff_code'=>$filters['staff_code'], 'page'=>1, 'page_size'=>4000));
            foreach ($staff_array['data'] as $key => $value) {
                $machine_id_str .= $value['machine_id'].',';
            }
            $machine_id_str = trim($machine_id_str, ',');

        }elseif($filters['dept_id']){
            $staff_array = $this->Staff_m->get_all_staff(array('dept_id'=>$filters['dept_id'], 'page'=>1, 'page_size'=>4000));
            foreach ($staff_array['data'] as $key => $value) {
                $machine_id_str .= $value['machine_id'].',';
            }
            $machine_id_str = trim($machine_id_str, ',');
        }else{            
            $staff_array = $this->Staff_m->get_all_staff(array('page'=>1, 'page_size'=>4000));
        }
        $staff = array();
        foreach ($staff_array['data'] as $staff_array_key => $staff_array_value) {
            $staff[$staff_array_value['machine_id']] = $staff_array_value;
        }
        $query_filters['machine_ids'] = $machine_id_str;
        $query_filters['month'] = $filters['month'];
        $query_filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $query_filters['page_size'] = 99999;
        $attendence = $this->Attendence_m->get_all_attendence_by_machine_ids($query_filters);       
        $depts = $this->Department_m->get_all_dept(false);
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $sorted_attends = array();
        foreach ($attendence['data'] as $attendence_key => $attendence_value) {
            $sorted_attends[$attendence_value['machine_id']][$attendence_value['check_date']][] = $attendence_value;
        }
        
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '打卡次数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '考勤时间');
        $line = 2;
        foreach ($sorted_attends as $sorted_attends_key => $sorted_attends_value) {
            if(!isset($staff[$sorted_attends_key])){
                continue;
            }
            $day = date('t', strtotime($filters['month']));
            for ($i=0; $i < $day; $i++) { 
                $now_day = date('Y-m-d', strtotime($filters['month']. "+ $i days"));
                if(isset($sorted_attends_value[$now_day])){
                    $line_add = count($sorted_attends_value[$now_day]) - 1;
                    // var_dump(intval($line + $line_add));die();
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$line.":".'A'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$line.":".'B'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('C'.$line.":".'C'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('D'.$line.":".'D'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('E'.$line.":".'E'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('F'.$line.":".'F'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $staff[$sorted_attends_key]['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $sorted_depts[$staff[$sorted_attends_key]['dept_id']]['dept_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $staff[$sorted_attends_key]['staff_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $now_day);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, 1);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, $line_add+1);
                    for ($j=0; $j < count($sorted_attends_value[$now_day]); $j++) { 
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.intval($line+$j), $sorted_attends_value[$now_day][$j]['check_time']);
                        if(($j == count($sorted_attends_value[$now_day]) -1) && strtotime($sorted_attends_value[$now_day][$j]['check_time']) >= strtotime($now_day . ' 03:30:00') + 86400){
                            $objPHPExcel->getActiveSheet()->getStyle('G'.intval($line+$j))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                        }
                    }
                    $line = $line + $line_add + 1;
                }else{
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $staff[$sorted_attends_key]['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $sorted_depts[$staff[$sorted_attends_key]['dept_id']]['dept_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $staff[$sorted_attends_key]['staff_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $now_day);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, 0);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, 0);
                    $line ++;
                }
            }
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="打卡记录_'.$filters['month'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function staff()
    {
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;        
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $summary = $this->Summary_m->get_all_summary($filters);
        $this->data['staff'] = $summary['data'];
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['total'] = $summary['total'];
        $this->data['filters'] = $filters;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/attendence_staff_list_v', $this->data);
    }

    public function detail()
    {   
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $detail = $this->Summary_m->get_all_detail($filters);
        $summary = $this->Summary_m->get_all_summary($filters);
        $detail_array = array();
        foreach ($detail['data'] as $key => $value) {
            $detail_array[$value['date']] = $value;
            if($value['check_in'] == ''){
                $detail_array[$value['date']]['check_detail_array'] = array();                
            }else{
                $check_in_array = explode(',', $value['check_in']);
                $check_in_ids = explode(',', $value['check_in_ids']);
                for ($i=0; $i < count($check_in_ids); $i++) { 
                    $detail_array[$value['date']]['check_detail_array'][] = array('id'=>$check_in_ids[$i], 'check_time'=>$check_in_array[$i]);
                }                
            }
            $detail_array[$value['date']]['in_time'] = explode(',', $value['in_time']);
        }
        $staff_data = $this->Staff_m->get_staff_by_code($filters['staff_code']);
        $this->data['sum'] = $summary['data'][0];
        $this->data['attendences'] = $detail_array;
        $this->data['staff'] = $staff_data['data'];
        $this->load->view('checkin/attendence_staff_detail_v', $this->data);
    }

    public function checkin()
    {
        $machine_id = trim($this->input->post('machine_id'));
        $check_date = trim($this->input->post('check_date'));
        $check_time = trim($this->input->post('check_time'));
        $check_type = trim($this->input->post('check_type'));
        // var_dump($check_date);
        $save = $this->Attendence_m->save($machine_id, $check_date, $check_time, $this->session->username, $check_type);
        echo json_encode($save);
    }

    public function expdata()
    {
        set_time_limit(0);
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $summary = $this->Summary_m->get_all_summary($filters);
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '正班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '加班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '缺勤时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '请假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '放假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '旷工时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '第一次迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '第二类迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '其他迟到分钟');
        $line = 2;
        foreach ($summary['data'] as $attendence) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $line, $attendence['department']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $line, $attendence['name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $line, $attendence['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $line, $attendence['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $line, $attendence['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $line, $attendence['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $line, $attendence['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $line, $attendence['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $line, $attendence['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $line, $attendence['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $line, $attendence['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $line, $attendence['late_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $line, $attendence['first_late']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $line, $attendence['second_late']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $line, $attendence['other_late']);
            $line++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="考勤_'.$filters['month'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }


    public function setcheckdate()
    {
        $check_id = $this->input->post('check_id');
        $type = $this->input->post('type');
        $save = $this->Attendence_m->set_check_date($check_id, $type, $this->session->username);
        echo json_encode($save);
    }

    public function expdetail()
    {
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $attendence = $this->Summary_m->get_all_detail($filters);
        $summary = $this->Summary_m->get_all_summary($filters);
        $summary_data = $summary['data'][0];
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '打卡次数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '打卡时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '正班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '加班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '缺勤工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '请假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '放假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '旷工工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '迟到分钟');
        $line = 2;
        
        foreach ($attendence['data'] as $attendence_key => $attendence_value) {
            $line_add = 0;
            if($attendence_value['check_count'] > 1)
            {
                $line_add = $attendence_value['check_count'] - 1;
                // var_dump(intval($line + $line_add));die();
                // var_dump($line);
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$line.":".'A'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$line.":".'B'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('C'.$line.":".'C'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$line.":".'D'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$line.":".'E'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$line.":".'F'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$line.":".'H'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('I'.$line.":".'I'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('J'.$line.":".'J'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$line.":".'K'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$line.":".'L'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$line.":".'M'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$line.":".'N'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $attendence_value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $attendence_value['department']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $attendence_value['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $attendence_value['date']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $attendence_value['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, $attendence_value['check_count']);
            $check_in_array = explode(',', $attendence_value['check_in']);
            foreach ($check_in_array as $check_detail_key => $check_detail_value) {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.intval($line+$check_detail_key), $check_detail_value);
                if(($check_detail_key == count($check_in_array) -1) && strtotime($check_detail_value) >= strtotime($attendence_value['date'] . ' 03:30:00') + 86400){
                    $objPHPExcel->getActiveSheet()->getStyle('G'.intval($line+$check_detail_key))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
            }
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $attendence_value['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $attendence_value['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $attendence_value['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $attendence_value['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $attendence_value['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $attendence_value['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $attendence_value['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $attendence_value['late_time']);
            $line = $line + $line_add + 1;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $summary_data['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $summary_data['department']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $summary_data['staff_code']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $summary_data['month']);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $summary_data['work_day']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$line, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $summary_data['legal_work_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $summary_data['work_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $summary_data['over_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $summary_data['off_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $summary_data['leave_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $summary_data['holiday_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $summary_data['error_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $summary_data['late_time']);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="考勤_'.$summary_data['name']. '_' . $summary_data['month'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function daysum()
    {
        $filters['dept_ids'] =trim($this->input->get('dept_ids'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['name'] = trim($this->input->get('name'));
        $filters['date'] = $this->input->get('date')?trim($this->input->get('date')):date("Y-m-d");
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = 2000;
        $checkin_filters = array();
        $checkin_filters['start_time'] = $filters['date'] . ' 00:00:00';
        $checkin_filters['end_time'] = $filters['date'] . ' 23:59:59';
        $staff = $this->Staff_m->get_all_staff($filters, true, 'dept_id');
        $depts = $this->Department_m->get_all_dept();
        $checkins = $this->Attendence_m->get_all_attendence($checkin_filters);
        $sorted_checkins = array();
        $sorted_checkins_array = array();
        foreach ($checkins['data'] as $checkin_key => $checkin_value) {
            $sorted_checkins[$checkin_value['machine_id']][] = $checkin_value['check_time'];
            $sorted_checkins_array[$checkin_value['machine_id']][] = $checkin_value;
        }
        $next_check_in_filter = array();
        $next_check_in_filter['start_time'] = date('Y-m-d', strtotime($filters['date'])+86400) . ' 00:00:00';
        $next_check_in_filter['end_time'] = date('Y-m-d', strtotime($filters['date'])+86400) . ' 23:59:59';
        $next_checkins = $this->Attendence_m->get_all_attendence($next_check_in_filter);
        $next_sorted_checkins = array();
        $next_sorted_checkins_array = array();
        foreach ($next_checkins['data'] as $next_checkin_key => $next_checkin_value) {
            $next_sorted_checkins[$next_checkin_value['machine_id']][] = $next_checkin_value['check_time'];
            $next_sorted_checkins_array[$next_checkin_value['machine_id']][] = $next_checkin_value;
        }
        $prev_check_in_filter = array();
        $prev_check_in_filter['start_time'] = date('Y-m-d', strtotime($filters['date'])-86400) . ' 00:00:00';
        $prev_check_in_filter['end_time'] = date('Y-m-d', strtotime($filters['date'])-86400) . ' 23:59:59';
        $prev_checkins = $this->Attendence_m->get_all_attendence($prev_check_in_filter);
        $prev_sorted_checkins = array();
        $prev_sorted_checkins_array = array();
        foreach ($prev_checkins['data'] as $prev_checkin_key => $prev_checkin_value) {
            $prev_sorted_checkins[$prev_checkin_value['machine_id']][] = $prev_checkin_value['check_time'];
            $prev_sorted_checkins_array[$prev_checkin_value['machine_id']][] = $prev_checkin_value;
        }
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $holiday_array = $this->Holiday_m->get_all_holiday_by_date($filters['date']);
        $duty_array = $this->Duty_m->get_all_duty_by_date($filters['date']);
        $addition_array = $this->Addition_m->get_all_addition_by_date($filters['date']);
        $staff_checkins = array();
        foreach ($staff['data'] as $staff_key => $staff_value) {
            if($staff_value['out_date'] != '1970-01-01' && strtotime($staff_value['out_date']) < strtotime($filters['date'])){
                unset($staff['data'][$staff_key]);
                continue;
            }
            $department = $sorted_depts[$staff_value['dept_id']];
            $staff_array = array();
            $staff_array['name'] = $staff_value['name'];
            $staff_array['staff_code'] = $staff_value['staff_code'];
            $staff_array['machine_id'] = $staff_value['machine_id'];
            $staff_array['dept_name'] = $sorted_depts[$staff_value['dept_id']]['dept_name'];
            $staff_array['date'] = $filters['date'];
            if(isset($sorted_checkins[$staff_value['machine_id']]))
            {
                $staff_array['checkday'] = 1;
                $staff_array['check_count'] = count($sorted_checkins[$staff_value['machine_id']]);
                $staff_array['check_detail'] = $sorted_checkins[$staff_value['machine_id']];
                $staff_array['check_detail_array'] = $sorted_checkins_array[$staff_value['machine_id']];
                if(isset($next_sorted_checkins[$staff_value['machine_id']])){
                    $staff_array['next_check_detail_array'] = $next_sorted_checkins_array[$staff_value['machine_id']];
                }else{
                    $staff_array['next_check_detail_array'] = array();
                }
                if(isset($prev_sorted_checkins[$staff_value['machine_id']])){
                    $staff_array['prev_check_detail_array'] = $prev_sorted_checkins_array[$staff_value['machine_id']];
                }else{
                    $staff_array['prev_check_detail_array'] = array();
                }
            }else
            {
                $staff_array['checkday'] = 0;
                $staff_array['check_count'] = 0;
                $staff_array['check_detail'] = array();;
                $staff_array['check_detail_array'] = array();
                $staff_array['next_check_detail_array'] = array();
                $staff_array['prev_check_detail_array'] = array();
            }
            $in_time_array = array();
            $out_time_array = array();
            $staff_sche = $this->Setsche_m->get_rule_by_staff_code($staff_value['staff_code'], $filters['date']);
            if($staff_sche['status'] != 1)
            {
                $dept_sche = $this->Setsche_m->get_rule_by_dept_id($staff_value['dept_id'], $filters['date']);
                if($dept_sche['status'] != 1)
                {
                    $in_time_array[] = '08:30:00';
                }else
                {                        
                    foreach ($dept_sche['data'] as $dept_sche_row) {
                        $in_time_array[] = $dept_sche_row['start_time'];
                    }
                }
            }else{
                foreach ($staff_sche['data'] as $staff_sche_row) {
                    $in_time_array[] = $staff_sche_row['start_time'];
                }
            }
            $staff_array['in_time'] = $in_time_array;//班次们
            $legal_work_time = 480;
            $max_work_time = 480;
            $work_time = 0;
            $late_time = 0;
            $over_time = 0;
            $check_details = $staff_array['check_detail'];
            if(count($check_details)%2 != 0){//如果打卡次数不为偶数次，则无视最后一次打卡
                unset($check_details[count($check_details)-1]);
            }
            for ($i=0; $i < count($check_details)-1; $i+=2) {
                if(count($in_time_array) >= $i/2+1)//判断当前打卡属于哪个班次
                {
                    $in_time = $in_time_array[$i/2];
                }else
                {
                    $in_time = $in_time_array[count($in_time_array) - 1];
                }
                if(strtotime($check_details[$i]) < strtotime($filters['date'] . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $check_details[$i] = $filters['date'] . ' ' . $in_time;
                }
                if(strtotime($check_details[$i+1]) < strtotime($filters['date'] . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $check_details[$i+1] = $filters['date'] . ' ' . $in_time;
                }
                if(strtotime($check_details[$i]) >= strtotime($filters['date'] . ' ' . $department['noon_break_start']) && strtotime($check_details[$i]) < strtotime($filters['date'] .  ' ' . $department['noon_break_end']))
                { //若是在午休时间打卡则默认为午休结束时间
                    $check_details[$i] = $filters['date'] . ' ' . $department['noon_break_end'] ;
                }
                if(strtotime($check_details[$i+1]) >= strtotime($filters['date'] . ' ' . $department['noon_break_start']) && strtotime($check_details[$i+1]) < strtotime($filters['date'] .  ' ' . $department['noon_break_end']))
                {
                    $check_details[$i+1] = $filters['date'] .  ' ' . $department['noon_break_end'] ;
                }
                if(count($in_time_array) >= $i/2+1 && strtotime($check_details[$i]) > strtotime($filters['date'] . ' ' . $in_time))//迟到时间
                {
                    $late_time += (strtotime(substr($check_details[$i], 0, -3)) - strtotime($filters['date'] . ' ' . $in_time))/60;
                    $check_details[$i] = $filters['date'] . ' ' . $in_time;
                }
                if (strtotime($check_details[$i])%1800 != 0 ) {
                    $check_details[$i] = date('Y-m-d H:i:s', (strtotime($check_details[$i]) + (1800 - strtotime($check_details[$i])%1800)));
                }
                $check_details[$i+1] = date('Y-m-d H:i:s', (strtotime($check_details[$i+1]) - strtotime($check_details[$i+1])%1800));
                // if(strtotime($check_details[$i]) % 1800 >= 900)//打卡时间以半小时为单位，超过一刻则算多半小时
                // {
                //     $check_details[$i] = date('Y-m-d H:i:s', (strtotime($check_details[$i]) + (1800 - strtotime($check_details[$i])%1800)));
                // }
                // else
                // {
                //     $check_details[$i] = date('Y-m-d H:i:s', (strtotime($check_details[$i]) - strtotime($check_details[$i])%1800));
                // }
                // if(strtotime($check_details[$i+1]) % 1800 >= 900)
                // {
                //     $check_details[$i+1] = date('Y-m-d H:i:s', (strtotime($check_details[$i+1]) + (1800 - strtotime($check_details[$i+1])%1800)));
                // }
                // else
                // {
                //     $check_details[$i+1] = date('Y-m-d H:i:s', (strtotime($check_details[$i+1]) - strtotime($check_details[$i+1])%1800));
                // }
                // echo "<br/>";
                // echo '</pre>';
                // print_r($check_details);
                // echo '</pre>';
                // die();
                if(strtotime($check_details[$i]) < strtotime($filters['date'] .  ' ' . $department['noon_break_start']))//如果上班卡早于12点
                {
                    if(strtotime($check_details[$i+1]) > strtotime($filters['date'] .  ' ' . $department['noon_break_start']))//如果下班卡晚于12点
                    {
                        $work_time += (strtotime($filters['date'] .  ' ' . $department['noon_break_start']) - strtotime($check_details[$i]))/60;//早上做满了
                        if(strtotime($check_details[$i+1]) > strtotime($filters['date'] .  ' ' . $department['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += 4.5*60;//下午做满了
                            if(strtotime($check_details[$i+1]) > strtotime($filters['date'] .  ' ' . $department['night_break_end']))//如果下班卡晚于18:00
                            {
                                $over_time += (strtotime($check_details[$i+1]) - strtotime($filters['date'] .  ' ' . $department['night_break_end']))/60;//加班了
                            }
                        }else
                        {
                            $work_time += (strtotime($check_details[$i+1]) - strtotime($filters['date'] .  ' ' . $department['noon_break_end']))/60;
                        }                    
                    }else//早上打卡下班了
                    {
                        $work_time += (strtotime($check_details[$i+1]) - strtotime($check_details[$i]))/60;
                    }
                }else
                {
                    if(strtotime($check_details[$i]) < strtotime($filters['date'] .  ' ' . $department['night_break_start']))
                    {
                        if(strtotime($check_details[$i+1]) > strtotime($filters['date'] .  ' ' . $department['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += (strtotime($filters['date'] .  ' ' . $department['night_break_start']) - strtotime($check_details[$i]))/60;//下午做满了
                            if(strtotime($check_details[$i+1]) > strtotime($filters['date'] .  ' ' . $department['night_break_end']))//如果下班卡晚于18:00
                            {
                                $over_time += (strtotime($check_details[$i+1]) - strtotime($filters['date'] .  ' ' . $department['night_break_end']))/60;//加班了
                            }
                        }else
                        {
                           $work_time += (strtotime($check_details[$i+1]) - strtotime($check_details[$i]))/60; 
                        }
                    }else
                    {
                        $over_time += (strtotime($check_details[$i+1]) - strtotime($check_details[$i]))/60;
                    }
                }
            }
            $holiday_time = 0;
            $leave_time = 0;
            $error_time = 0;
            foreach ($holiday_array['data'] as $holiday_key => $holiday_value) 
            {
                if($holiday_value['target'] == 3 || ($holiday_value['target'] == 1 && $holiday_value['dept_id'] == $staff_value['dept_id']) || ($holiday_value['target'] == 2 && $holiday_value['staff_code'] == $staff_value['staff_code']))
                {
                    if($holiday_value['type'] == 1){
                        $holiday_time += $holiday_value['hours'];
                        $max_work_time = $max_work_time - $holiday_value['hours']*60;
                    }else if($holiday_value['type'] == 4){
                        $error_time += $holiday_value['hours'];
                        $max_work_time = $max_work_time - $holiday_value['hours']*60;
                    }else{
                        $leave_time += $holiday_value['hours'];
                        $max_work_time = $max_work_time - $holiday_value['hours']*60;
                    }
                }
            }
            foreach ($duty_array['data'] as $duty_key => $duty_value) 
            {
                if($duty_value['staff_code'] == $staff_value['staff_code'])
                {
                    $holiday_time = 0;
                    $max_work_time = 480;
                }
            }
            foreach ($addition_array['data'] as $addition_key => $addition_value) 
            {
                if(($addition_value['target'] == 1 && $addition_value['dept_id'] == $staff_value['dept_id']) || ($addition_value['target'] == 2 && $addition_value['staff_code'] == $staff_value['staff_code']))
                {
                    $work_time += intval($addition_value['hours']*60);
                }
            }
            if($department['has_overtime'] == 0)
            {
                // $over_time = 0;
            }
            if($work_time < $max_work_time){
                if($work_time + $over_time <= $max_work_time)
                {
                    $work_time = $over_time + $work_time;
                    $over_time = 0;
                }else
                {
                    $over_time = $over_time + $work_time - $max_work_time;
                    $work_time = $max_work_time;
                }
            }
            if($work_time > $max_work_time)
            {
                $over_time = $over_time + $work_time - $max_work_time;
                $work_time = $max_work_time;
            }
            if($department['has_overtime'] == 0)
            {
                if($work_time > 0)
                {
                    $work_time = $max_work_time;
                }
                $over_time = 0;
            }
            if($staff_value['out_date'] != '1970-01-01' && strtotime($staff_value['out_date']) <= strtotime($filters['date'])){
                $leave_time = ($legal_work_time - $work_time - intval($leave_time*60))/60;
                // $holiday_time = 8;
                // $max_work_time = 0;
            }
            if(strtotime($staff_value['in_date']) > strtotime($filters['date'])){
                $leave_time = ($legal_work_time - $work_time - intval($leave_time*60))/60;
                // $holiday_time = 8;
                // $max_work_time = 0;
            }
            $staff_array['legal_work_time'] = $legal_work_time/60 - $holiday_time;
            $staff_array['work_time'] = $work_time/60;
            $staff_array['over_time'] = $over_time/60;
            $staff_array['leave_time'] = $leave_time;
            $staff_array['error_time'] = $error_time;
            $staff_array['holiday_time'] = $holiday_time;
            $staff_array['off_time'] = ($legal_work_time - $work_time - intval($leave_time*60) - intval($holiday_time*60))/60;
            $staff_array['late_time'] = intval($late_time);
            $staff_checkins[$staff_value['staff_code']] = $staff_array;
        }
        $this->data['staff_checkins'] = $staff_checkins;
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['total'] = $staff['total'];
        $this->data['filters'] = $filters;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/daysum_list_v', $this->data);
    }

    public function checkinall()
    {
        $check_codes = $this->input->post('check_codes');
        $check_date = trim($this->input->post('check_date'));
        $check_time = trim($this->input->post('check_time'));
        $check_type = trim($this->input->post('check_type'));
        $machine_ids = $this->Staff_m->get_machine_ids($check_codes);
        $save = $this->Attendence_m->save_mul($machine_ids['data'], $check_date, $check_time, $this->session->username, $check_type);
        echo json_encode($save);
    }

    public function delcheck()
    {
        $check_id = $this->input->post('check_id');
        $save = $this->Attendence_m->del_check_in($check_id, $this->session->username);
        echo json_encode($save);
    }

    public function savehistory()
    {
        set_time_limit(0);
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");        
        $detail = $this->Summary_m->get_all_detail($filters);
        $summary = $this->Summary_m->get_all_summary($filters);
        foreach ($detail['data'] as $detail_row) {
            $insert_data = array();
            $insert_data['month'] = $detail_row['month'];
            $insert_data['date'] = $detail_row['date'];
            $insert_data['department'] = $detail_row['department'];
            $insert_data['name'] = $detail_row['name'];
            $insert_data['staff_code'] = $detail_row['staff_code'];
            $insert_data['work_day'] = $detail_row['work_day'];
            $insert_data['check_in'] = $detail_row['check_in'];
            $insert_data['legal_work_time'] = $detail_row['legal_work_time'];
            $insert_data['work_time'] = $detail_row['work_time'];
            $insert_data['over_time'] = $detail_row['over_time'];
            $insert_data['off_time'] = $detail_row['off_time'];
            $insert_data['leave_time'] = $detail_row['leave_time'];
            $insert_data['holiday_time'] = $detail_row['holiday_time'];
            $insert_data['error_time'] = $detail_row['error_time'];
            $insert_data['late_time'] = $detail_row['late_time'];
            $insert_result = $this->Attendence_m->save_history_detail($insert_data, $this->session->username);
        }
        foreach ($summary['data'] as $summary_row) {  
            $insert_sum = array();
            $insert_sum['month'] = $summary_row['month'];
            $insert_sum['department'] = $summary_row['department'];
            $insert_sum['name'] = $summary_row['name'];
            $insert_sum['staff_code'] = $summary_row['staff_code'];
            $insert_sum['work_day'] = $summary_row['work_day'];
            $insert_sum['legal_work_time'] = $summary_row['legal_work_time'];
            $insert_sum['work_time'] = $summary_row['work_time'];
            $insert_sum['over_time'] = $summary_row['over_time'];
            $insert_sum['off_time'] = $summary_row['off_time'];
            $insert_sum['leave_time'] = $summary_row['leave_time'];
            $insert_sum['holiday_time'] = $summary_row['holiday_time'];
            $insert_sum['error_time'] = $summary_row['error_time'];
            $insert_sum['late_time'] = $summary_row['late_time'];
            $insert_sum['first_late'] = $summary_row['first_late'];
            $insert_sum['other_late'] = $summary_row['other_late'];
            $insert__sum_result = $this->Attendence_m->save_history($insert_sum, $this->session->username);
        }
    }

    public function staffhistory()
    {
        $filters['department'] = trim($this->input->get('department'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;
        $data = $this->Attendence_m->get_all_history($filters);
        $depts = $this->Attendence_m->get_all_depts();
        $this->data['staff'] = $data['data'];
        $this->data['depts'] = $depts['data'];
        $this->data['total'] = $data['total'];
        $this->data['filters'] = $filters;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/attendence_staff_history_list_v', $this->data);
    }

    public function detailhistory()
    {   
        //获取员工信息
        $staff_code = trim($this->input->get('staff_code'));
        $month = trim($this->input->get('month'));
        $filters['staff_code'] = $staff_code;
        $filters['month'] = $month;
        $sum = $this->Attendence_m->get_all_history($filters);
        $detail = $this->Attendence_m->get_all_history_detail($staff_code, $month);
        foreach ($detail['data'] as $detail_key => $detail_value) {
            $checkins = explode(',', $detail_value['check_in']);
            $detail['data'][$detail_key]['check_count'] = count($checkins);
        }
        $this->data['sum'] = $sum['data'][0];
        $this->data['staff'] = $detail['data'];
        $this->load->view('checkin/attendence_staff_history_detail_v', $this->data);
    }

    public function exphistory()
    {
        $filters['department'] = trim($this->input->get('department'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:2000;
        $data = $this->Attendence_m->get_all_history($filters);
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '正班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '加班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '缺勤时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '请假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '放假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '旷工时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '第一次迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '其他迟到分钟');
        $line = 2;
        foreach ($data['data'] as $data_key => $data_value) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $line, $data_value['department']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $line, $data_value['name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $line, $data_value['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $line, $data_value['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $line, $data_value['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $line, $data_value['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $line, $data_value['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $line, $data_value['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $line, $data_value['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $line, $data_value['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $line, $data_value['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $line, $data_value['late_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $line, $data_value['first_late']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $line, $data_value['other_late']);
            $line++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="历史考勤_'.$filters['month'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');

    }

    public function exphistorydetail()
    {        
        //获取员工信息
        $staff_code = trim($this->input->get('staff_code'));
        $month = trim($this->input->get('month'));
        $filters['staff_code'] = $staff_code;
        $filters['month'] = $month;
        $sum = $this->Attendence_m->get_all_history($filters);
        $detail = $this->Attendence_m->get_all_history_detail($staff_code, $month);
        foreach ($detail['data'] as $detail_key => $detail_value) {
            $checkins = explode(',', $detail_value['check_in']);
            $detail['data'][$detail_key]['check_count'] = count($checkins);
            $detail['data'][$detail_key]['check_detail'] = $checkins;
        }
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '打卡次数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '打卡时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '正班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '加班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '缺勤工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '请假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '放假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '旷工工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '迟到分钟');
        $line = 2;
        foreach ($detail['data'] as $attendence_key => $attendence_value) {
            $line_add = 0;
            if($attendence_value['check_count'] > 1)
            {
                $line_add = $attendence_value['check_count'] - 1;
                $objPHPExcel->getActiveSheet()->mergeCells('A'.$line.":".'A'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$line.":".'B'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('C'.$line.":".'C'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$line.":".'D'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$line.":".'E'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$line.":".'F'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$line.":".'H'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('I'.$line.":".'I'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('J'.$line.":".'J'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$line.":".'K'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$line.":".'L'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$line.":".'M'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$line.":".'N'.intval($line+$line_add));
                $objPHPExcel->getActiveSheet()->getStyle('A'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('M'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('O'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $attendence_value['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $attendence_value['department']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $attendence_value['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $attendence_value['date']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $attendence_value['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, $attendence_value['check_count']);
            foreach ($attendence_value['check_detail'] as $check_detail_key => $check_detail_value) {
                $objPHPExcel->getActiveSheet()->setCellValue('G'.intval($line+$check_detail_key), $check_detail_value);
                if(($check_detail_key == count($attendence_value['check_detail']) -1) && strtotime($check_detail_value) >= strtotime($attendence_value['date'] . ' 03:30:00') + 86400){
                    $objPHPExcel->getActiveSheet()->getStyle('G'.intval($line+$check_detail_key))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                }
            }
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $attendence_value['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $attendence_value['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $attendence_value['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $attendence_value['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $attendence_value['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $attendence_value['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $attendence_value['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $attendence_value['late_time']);
            $line = $line + $line_add + 1;
        }
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $sum['data'][0]['name']);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $sum['data'][0]['department']);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $sum['data'][0]['staff_code']);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, '');
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $sum['data'][0]['work_day']);
        $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, '');
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$line, '');
        $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $sum['data'][0]['legal_work_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $sum['data'][0]['work_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $sum['data'][0]['over_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $sum['data'][0]['off_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $sum['data'][0]['leave_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $sum['data'][0]['holiday_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $sum['data'][0]['error_time']);
        $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $sum['data'][0]['late_time']);
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="历史考勤明细_'.$sum['data'][0]['name']. '_' . $month.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }


    /**
     * 时间段考勤汇总
     */
    public function staffdate()
    {
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['start_date'] = $this->input->get('start_date')?trim($this->input->get('start_date')):date("Y-m-1");
        $filters['end_date'] = $this->input->get('end_date')?trim($this->input->get('end_date')):date("Y-m-t");
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;
        $staff = $this->Staff_m->get_all_staff($filters, true, 'dept_id');
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        foreach ($staff['data'] as $staff_key => $staff_value) {
            if($staff_value['out_date'] != '1970-01-01' &&  strtotime($staff_value['out_date']) < strtotime($filters['start_date'])){
                unset($staff['data'][$staff_key]);
                $staff['total'] -= 1;
                continue;
            }
            $attendence = $this->calc_attendence2($staff_value['id'], $filters['start_date'], $filters['end_date']);
            $staff['data'][$staff_key]['sum'] = $attendence['sum'];
        }
        $this->data['staff'] = $staff['data'];
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['total'] = $staff['total'];
        $this->data['filters'] = $filters;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/attendence_staff_list_date_v', $this->data);
    }


    public function detaildate()
    {   
        //获取员工信息
        $staff_id = trim($this->input->get('staff_id'));
        $start_date = trim($this->input->get('start_date'));
        $end_date = trim($this->input->get('end_date'));
        $attendence = $this->calc_attendence2($staff_id, $start_date, $end_date);
        $this->data['sum'] = $attendence['sum'];
        $this->data['staff'] = $attendence['staff']['data'];
        $this->data['attendences'] = $attendence['data'];
        $this->load->view('checkin/attendence_staff_detail_date_v', $this->data);
    }

    public function expdatadate()
    {
        set_time_limit(0);
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['start_date'] = $this->input->get('start_date')?trim($this->input->get('start_date')):date("Y-m-1");
        $filters['end_date'] = $this->input->get('end_date')?trim($this->input->get('end_date')):date("Y-m-t");
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:1000;
        $staff = $this->Staff_m->get_all_staff($filters, true, 'dept_id');
        $depts = $this->Department_m->get_all_dept();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '正班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '加班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '缺勤时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '请假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '放假时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '旷工时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '第一次迟到分钟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '其他迟到分钟');
        $line = 2;
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        foreach ($staff['data'] as $staff_key => $staff_value) {
            if($staff_value['out_date'] != '1970-01-01' &&  strtotime($staff_value['out_date']) < strtotime($filters['start_date'])){
                unset($staff['data'][$staff_key]);
                $staff['total'] -= 1;
                continue;
            }
            $attendence = $this->calc_attendence2($staff_value['id'], $filters['start_date'], $filters['end_date']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $line, $sorted_depts[$attendence['staff']['data']['dept_id']]['dept_name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $line, $attendence['staff']['data']['name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $line, $attendence['staff']['data']['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $line, $attendence['sum']['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $line, $attendence['sum']['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $line, $attendence['sum']['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $line, $attendence['sum']['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $line, $attendence['sum']['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $line, $attendence['sum']['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $line, $attendence['sum']['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $line, $attendence['sum']['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $line, $attendence['sum']['late_time']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $line, $attendence['sum']['first_late']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $line, $attendence['sum']['other_late']);
            $line++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="考勤_'.$filters['start_date'].'_'.$filters['end_date'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }


    public function calc_attendence2($staff_id, $start_date, $end_date)
    {   
        $staff = $this->Staff_m->get_staff_by_id($staff_id);
        //获取部门信息
        $department = $this->Department_m->get_one_dept($staff['data']['dept_id']);
        // var_dump($department);
        $staff['data']['dept_name'] = $department['data']['dept_name'];
        //获取假日信息
        $holiday = $this->Holiday_m->get_all_holiday_by_date2($start_date, $end_date);
        $holiday_array = array();
        foreach ($holiday['data'] as $holiday_row) 
        {
            $holiday_array[$holiday_row['holiday']][] = $holiday_row;
        }
        //获取值班信息
        $duty = $this->Duty_m->get_all_duty_by_date2($start_date, $end_date);
        $duty_array = array();
        foreach ($duty['data'] as $duty_row) 
        {
            $duty_array[$duty_row['duty']][] = $duty_row;
        }
        //获取连班信息
        $addition = $this->Addition_m->get_all_addition_by_date2($start_date, $end_date);
        $addition_array = array();
        foreach ($addition['data'] as $addition_row) 
        {
            $addition_array[$addition_row['addition']][] = $addition_row;
        }
        //获取考勤信息
        $attendence_filter = array();
        $attendence_filter['machine_id'] = $staff['data']['machine_id'];
        $attendence_filter['start_time'] = date('Y-m-d 00:00:00', strtotime($start_date));;
        $attendence_filter['end_time'] = date('Y-m-d 23:59:59', strtotime($end_date));
        $staff_attendence = $this->Attendence_m->get_all_attendence($attendence_filter);
        //构建月数组
        $day = (strtotime($end_date) - strtotime($start_date))/86400;
        $attendence_array = array();
        $attendence_array_detail = array();
        for ($i=0; $i <= $day; $i++) { 
            $now_day = date('Y-m-d', strtotime($start_date. "+ $i days"));
            $attendence_array[$now_day] = array();
            $attendence_array_detail[$now_day] = array();
        }
        foreach ($staff_attendence['data'] as $row) {
            $check_time = $row['check_time'];
            $check_day = $row['check_date'];
            $attendence_array[$check_day][] = date('Y-m-d H:i:s', strtotime($check_time)- strtotime($check_time)%60);
            $attendence_array_detail[$check_day][] = array('id'=>$row['id'], 'check_time'=>date('Y-m-d H:i:s', strtotime($check_time)- strtotime($check_time)%60));
        }
        $attendence_result = array();
        $sum = array();
        $sum['legal_work_time'] = 0;
        $sum['work_time'] = 0;
        $sum['over_time'] = 0;
        $sum['holiday_time'] = 0;
        $sum['leave_time'] = 0;
        $sum['error_time'] = 0;
        $sum['off_time'] = 0;
        $sum['late_time'] = 0;
        $sum['late_count'] = 0;
        $sum['first_late'] = 0;
        $sum['second_late'] = 0;
        $sum['other_late'] = 0;
        $sum['work_day'] = 0;
        $sum['check_count'] = 0;
        foreach ($attendence_array as $key => $value) {
            $day_sum = array();
            $day_sum['check_detail'] = $value;
            $day_sum['check_detail_array'] = $attendence_array_detail[$key];
            if(count($value)%2 != 0){
                unset($value[count($value)-1]);
            }
            $in_time_array = array();
            $out_time_array = array();
            $staff_sche = $this->Setsche_m->get_rule_by_staff_code($staff['data']['staff_code'], $key);
            if($staff_sche['status'] != 1)
            {
                $dept_sche = $this->Setsche_m->get_rule_by_dept_id($staff['data']['dept_id'], $key);
                if($dept_sche['status'] != 1)
                {
                    $in_time_array[] = '08:30:00';
                }else
                {                        
                    foreach ($dept_sche['data'] as $dept_sche_row) {
                        $in_time_array[] = $dept_sche_row['start_time'];
                    }
                }
            }else{
                foreach ($staff_sche['data'] as $staff_sche_row) {
                    $in_time_array[] = $staff_sche_row['start_time'];
                }
            }
            $day_sum['in_time'] = $in_time_array;
            $legal_work_time = 480;
            $max_work_time = 480;
            $work_time = 0;
            $late_time = 0;
            $over_time = 0;
            for ($i=0; $i < count($value)-1; $i+=2) {
                if(count($in_time_array) >= $i/2+1)
                {
                    $in_time = $in_time_array[$i/2];
                }else
                {
                    $in_time = $in_time_array[count($in_time_array) - 1];
                }
                if(strtotime($value[$i]) < strtotime($key . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $value[$i] = $key . ' ' . $in_time;
                }
                if(strtotime($value[$i+1]) < strtotime($key . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $value[$i+1] = $key . ' ' . $in_time;
                }
                if(strtotime($value[$i]) >= strtotime($key . ' ' + $department['data']['noon_break_start']) && strtotime($value[$i]) < strtotime($key . ' ' + $department['data']['noon_break_end']))
                {
                    $value[$i] = $key . ' ' + $department['data']['noon_break_end'] ;
                }
                if(strtotime($value[$i+1]) >= strtotime($key . ' ' + $department['data']['noon_break_start']) && strtotime($value[$i+1]) < strtotime($key . ' ' + $department['data']['noon_break_end']))
                {
                    $value[$i+1] = $key . ' ' + $department['data']['noon_break_end'] ;
                }
                if(count($in_time_array) >= $i/2+1 && strtotime($value[$i]) > strtotime($key . ' ' . $in_time))//迟到时间
                {
                    $late_time += (strtotime(substr($value[$i], 0, -3)) - strtotime($key . ' ' . $in_time))/60;
                    $value[$i] = $key . ' ' . $in_time;
                }
                
                if (strtotime($value[$i])%1800 != 0 ) {
                    $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) + (1800 - strtotime($value[$i])%1800)));
                }
                $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) - strtotime($value[$i+1])%1800));
                // if(strtotime($value[$i]) % 1800 >= 900)
                // {
                //     $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) + (1800 - strtotime($value[$i])%1800)));
                // }
                // else
                // {
                //     $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) - strtotime($value[$i])%1800));
                // }
                // if(strtotime($value[$i+1]) % 1800 >= 900)
                // {
                //     $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) + (1800 - strtotime($value[$i+1])%1800)));
                // }
                // else
                // {
                //     $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) - strtotime($value[$i+1])%1800));
                // }
                if(strtotime($value[$i]) < strtotime($key . ' ' + $department['data']['noon_break_start']))//如果上班卡早于12点
                {
                    if(strtotime($value[$i+1]) > strtotime($key . ' ' + $department['data']['noon_break_start']))//如果下班卡晚于12点
                    {
                        $work_time += (strtotime($key . ' ' + $department['data']['noon_break_start']) - strtotime($value[$i]))/60;//早上做满了
                        if(strtotime($value[$i+1]) > strtotime($key . ' ' + $department['data']['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += 4.5*60;//下午做满了
                            if(strtotime($value[$i+1]) > strtotime($key . ' ' + $department['data']['night_break_end']))//如果下班卡晚于18:00
                            {
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_start'])+86400)){
                                    $over_time += 1080;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_end'])+86400)){
                                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_start'])+86400)){
                                            $over_time += 280;
                                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_end'])+86400)){
                                                $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['night_break_end']) - 86400)/60;
                                            }
                                        }else{
                                           $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['noon_break_end']) - 86400)/60; 
                                        }
                                    }
                                }else{
                                    $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['night_break_end']))/60;//加班了
                                }
                            }
                        }else
                        {
                            $work_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['noon_break_end']))/60;
                        }                    
                    }else//早上打卡下班了
                    {
                        $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60;
                    }
                }else
                {
                    if(strtotime($value[$i]) < strtotime($key . ' ' + $department['data']['night_break_start']))
                    {
                        if(strtotime($value[$i+1]) > strtotime($key . ' ' + $department['data']['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += (strtotime($key . ' ' + $department['data']['night_break_start']) - strtotime($value[$i]))/60;//下午做满了
                            if(strtotime($value[$i+1]) > strtotime($key . ' ' + $department['data']['night_break_end']))//如果下班卡晚于18:00
                            {
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_start'])+86400)){
                                    $over_time += 1080;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_end'])+86400)){
                                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_start'])+86400)){
                                            $over_time += 280;
                                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_end'])+86400)){
                                                $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['night_break_end']) - 86400)/60;
                                            }
                                        }else{
                                           $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['noon_break_end']) - 86400)/60; 
                                        }
                                    }
                                }else{
                                    $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['night_break_end']))/60;//加班了
                                }
                            }
                        }else
                        {
                           $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60; 
                        }
                    }else
                    {   
                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_start'])+86400)){
                            $over_time += (strtotime($key . ' ' + $department['data']['noon_break_start'])+86400 - strtotime($value[$i]))/60;
                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['noon_break_end'])+86400)){
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_start'])+86400)){
                                    $over_time += 280;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' + $department['data']['night_break_end'])+86400)){
                                        $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['night_break_end']) - 86400)/60;
                                    }
                                }else{
                                   $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' + $department['data']['noon_break_end']) - 86400)/60; 
                                }
                            }
                        }else{
                            $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60;
                        }
                    }
                }
            }
            $holiday_time = 0;
            $leave_time = 0;
            $error_time = 0;
            if(isset($holiday_array[$key]))
            {
                foreach ($holiday_array[$key] as $holiday_key => $holiday_value) 
                {
                    if($holiday_value['target'] == 3 || ($holiday_value['target'] == 1 && $holiday_value['dept_id'] == $staff['data']['dept_id']) || ($holiday_value['target'] == 2 && $holiday_value['staff_code'] == $staff['data']['staff_code']))
                    {
                        if($holiday_value['type'] == 1){
                            $holiday_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }else if($holiday_value['type'] == 4){
                            $error_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }else{
                            $leave_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }
                    }
                }
            }
            if(isset($duty_array[$key]))
            {
                foreach ($duty_array[$key] as $duty_key => $duty_value) 
                {
                    if($duty_value['staff_code'] == $staff['data']['staff_code'])
                    {
                        $holiday_time = 0;
                        $max_work_time = 480;
                    }
                }
            }
            if(isset($addition_array[$key]))
            {
                foreach ($addition_array[$key] as $addition_key => $addition_value) 
                {
                    if(($addition_value['target'] == 1 && $addition_value['dept_id'] == $staff['data']['dept_id']) || ($addition_value['target'] == 2 && $addition_value['staff_code'] == $staff['data']['staff_code']))
                    {
                        $work_time += intval($addition_value['hours']*60);
                    }
                }
            }
            if($department['data']['has_overtime'] == 0)
            {
                // var_dump($over_time);
                // $over_time = 0;
            }
            if($work_time < $max_work_time){
                if($work_time + $over_time <= $max_work_time)
                {
                    $work_time = $over_time + $work_time;
                    $over_time = 0;
                }else
                {
                    $over_time = $over_time + $work_time - $max_work_time;
                    $work_time = $max_work_time;
                }
            }
            if($work_time > $max_work_time)
            {
                $over_time = $over_time + $work_time - $max_work_time;
                $work_time = $max_work_time;
            }
            if($department['data']['has_overtime'] == 0)
            {
                $over_time = 0;
                if($work_time > 0)
                {
                    $work_time = $max_work_time;
                }
            }
            if($work_time >0 || $over_time > 0 && $holiday_time != 8)
            {
                $day_sum['work_day'] = ($legal_work_time - $holiday_time * 60 - $leave_time * 60)/($legal_work_time - $holiday_time * 60);
            }else
            {
                $day_sum['work_day'] = 0;
            }

            if($staff['data']['out_date'] != '1970-01-01' && strtotime($staff['data']['out_date']) <= strtotime($key)){
                $leave_time = ($legal_work_time - $work_time - intval($leave_time*60))/60;
                // $holiday_time = 8;
                // $max_work_time = 0;
            }
            if(strtotime($staff['data']['in_date']) > strtotime($key)){
                $leave_time = ($legal_work_time - $work_time - intval($leave_time*60))/60;
                // $holiday_time = 8;
                // $max_work_time = 0;
            }
            $day_sum['legal_work_time'] = $legal_work_time/60 - $holiday_time;
            $day_sum['work_time'] = $work_time/60;
            $day_sum['over_time'] = $over_time/60;
            $day_sum['leave_time'] = $leave_time;
            $day_sum['error_time'] = $error_time;
            $day_sum['holiday_time'] = $holiday_time;
            $day_sum['off_time'] = ($legal_work_time - $work_time - intval($leave_time*60) - intval($holiday_time*60))/60;
            $day_sum['late_time'] = $late_time;
            $day_sum['check_count'] = count($value);

            $sum['legal_work_time'] += $day_sum['legal_work_time'];
            $sum['work_time'] += $day_sum['work_time'];
            $sum['over_time'] += $day_sum['over_time'];
            $sum['leave_time'] += $day_sum['leave_time'];
            $sum['holiday_time'] += $day_sum['holiday_time'];
            $sum['off_time'] += $day_sum['off_time'];
            $sum['late_time'] += $day_sum['late_time'];            
            if($day_sum['late_time'] > 0 ){
                if($sum['late_count'] == 0){
                    if($day_sum['late_time'] <= 5){
                        $sum['first_late'] += $day_sum['late_time'];
                    }else{
                        $sum['first_late'] = 5;
                        $sum['second_late'] += $day_sum['late_time'] - 5;
                    }
                }else if($sum['late_count'] < 4) {
                    $sum['second_late'] += $day_sum['late_time'];
                }else {
                    $sum['other_late'] += $day_sum['late_time'];
                }
                $sum['late_count'] += 1;
            }
            $sum['error_time'] += $day_sum['error_time'];
            $sum['check_count'] += $day_sum['check_count'];
            $sum['work_day'] += $day_sum['work_day'];
            $attendence_result[$key] = $day_sum;
        }
        if($sum['work_time'] < $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time']) {
            if($sum['work_time'] + $sum['over_time'] >= $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time']){
                $sum['over_time'] = $sum['work_time'] + $sum['over_time'] - $sum['legal_work_time'] + $sum['leave_time'] + $sum['error_time'];
                $sum['work_time'] = $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time'];
                $sum['off_time'] = $sum['error_time'] + $sum['leave_time'];
            }else{
                $sum['work_time'] = $sum['work_time'] + $sum['over_time'];
                $sum['off_time'] = $sum['off_time'] - $sum['over_time'];
                $sum['over_time'] = 0;
            }
        }
        return array('sum' => $sum, 'data' => $attendence_result, 'staff' => $staff);
    }


    public function expalldetail()
    {
        set_time_limit(0);
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = $this->input->get('month')?trim($this->input->get('month')):date("Y-m");      
        $detail = $this->Summary_m->get_all_detail($filters);
        $summary = $this->Summary_m->get_all_summary($filters);
        $summary_arr = array();
        foreach ($summary['data'] as $summary_row) {
            $summary_arr[$summary_row['staff_code']] = $summary_row;
        }
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '打卡次数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '打卡时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '正班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '加班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '缺勤工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '请假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '放假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '旷工工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '迟到分钟');
        $line = 2;
        foreach ($detail['data'] as $attendence) {
                $line_add = 0;
                if($attendence['check_count'] > 1)
                {
                    $line_add = $attendence['check_count'] - 1;
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$line.":".'A'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$line.":".'B'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('C'.$line.":".'C'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('D'.$line.":".'D'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('E'.$line.":".'E'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('F'.$line.":".'F'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('H'.$line.":".'H'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('I'.$line.":".'I'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('J'.$line.":".'J'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('K'.$line.":".'K'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('L'.$line.":".'L'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('M'.$line.":".'M'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('N'.$line.":".'N'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('N'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('O'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $attendence['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $attendence['department']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $attendence['staff_code']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $attendence['date']);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $attendence['work_day']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, $attendence['check_count']);
                $check_details = explode(',', $attendence['check_in']);
                foreach ($check_details as $check_detail_key => $check_detail_value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.intval($line+$check_detail_key), $check_detail_value);
                    if(($check_detail_key == count($check_details) -1) && strtotime($check_detail_value) >= strtotime($attendence['date'] . ' 03:30:00') + 86400){
                        $objPHPExcel->getActiveSheet()->getStyle('G'.intval($line+$check_detail_key))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                    }
                }
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $attendence['legal_work_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $attendence['work_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $attendence['over_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $attendence['off_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $attendence['leave_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $attendence['holiday_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $attendence['error_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $attendence['late_time']);
                $line = $line + $line_add + 1;
                if($attendence['date'] == date('Y-m-t',strtotime($attendence['date']))){  
                    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$line.':O'.$line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->getActiveSheet()->getStyle( 'A'.$line.':O'.$line)->getFill()->getStartColor()->setARGB('FFBDD7EE');            
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $summary_arr[$attendence['staff_code']]['name'].'(汇总)');
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $summary_arr[$attendence['staff_code']]['department']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $summary_arr[$attendence['staff_code']]['staff_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $summary_arr[$attendence['staff_code']]['work_day']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$line, '');
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $summary_arr[$attendence['staff_code']]['legal_work_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $summary_arr[$attendence['staff_code']]['work_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $summary_arr[$attendence['staff_code']]['over_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $summary_arr[$attendence['staff_code']]['off_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $summary_arr[$attendence['staff_code']]['leave_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $summary_arr[$attendence['staff_code']]['holiday_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $summary_arr[$attendence['staff_code']]['error_time']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $summary_arr[$attendence['staff_code']]['late_time']);
                    $line = $line + 2;
                }
        }

        if(!$filters['dept_id']){
            $file_name = '全厂';
        }else{
            $file_name = $attendence['department'];
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="考勤_'.$file_name . '-'. $filters['month'].'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function expalldetaildate()
    {
        set_time_limit(0);
        $start_date = trim($this->input->get('start_date'));
        $end_date = trim($this->input->get('end_date'));
        $dept_id = $this->input->get('dept_id')?trim($this->input->get('dept_id')):0;
        $staff = $this->Staff_m->get_all_staff(array('dept_id'=>$dept_id,'page'=>1, 'page_size'=> 5000));
        $depts = $this->Department_m->get_all_dept();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '出勤天数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '打卡次数');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '打卡时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '应上班时间');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '正班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '加班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '缺勤工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '请假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '放假工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '旷工工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '迟到分钟');
        $line = 2;
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        // var_dump(count($staff['data']));die();
        for ($i=0; $i < count($staff['data']); $i++) { 
            if(strtotime($staff['data'][$i]['out_date']) < strtotime($start_date)){
                if($staff['data'][$i]['out_date'] != '1970-01-01'){
                    continue;
                }
            }
            if(strtotime($staff['data'][$i]['in_date']) > strtotime($end_date)) {
                    continue;
            }
            $staff_id = $staff['data'][$i]['id'];
            $attendence = $this->calc_attendence2($staff_id, $start_date, $end_date);
            foreach ($attendence['data'] as $attendence_key => $attendence_value) {
                $line_add = 0;
                if($attendence_value['check_count'] > 1)
                {
                    $line_add = $attendence_value['check_count'] - 1;
                    // var_dump(intval($line + $line_add));die();
                    // var_dump($line);
                    $objPHPExcel->getActiveSheet()->mergeCells('A'.$line.":".'A'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('B'.$line.":".'B'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('C'.$line.":".'C'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('D'.$line.":".'D'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('E'.$line.":".'E'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('F'.$line.":".'F'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('H'.$line.":".'H'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('I'.$line.":".'I'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('J'.$line.":".'J'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('K'.$line.":".'K'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('L'.$line.":".'L'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('M'.$line.":".'M'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->mergeCells('N'.$line.":".'N'.intval($line+$line_add));
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('C'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('D'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('I'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('M'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('N'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('O'.$line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
                $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $staff['data'][$i]['name']);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $sorted_depts[$staff['data'][$i]['dept_id']]['dept_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $staff['data'][$i]['staff_code']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, $attendence_key);
                $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $attendence_value['work_day']);
                $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, $attendence_value['check_count']);
                // var_dump(strtotime($attendence_key . ' 03:30:00') + 86400);die();
                foreach ($attendence_value['check_detail'] as $check_detail_key => $check_detail_value) {
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.intval($line+$check_detail_key), $check_detail_value);
                    if(($check_detail_key == count($attendence_value['check_detail']) -1) && strtotime($check_detail_value) >= strtotime($attendence_key . ' 03:30:00') + 86400){
                        $objPHPExcel->getActiveSheet()->getStyle('G'.intval($line+$check_detail_key))->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
                    }
                }
                $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $attendence_value['legal_work_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $attendence_value['work_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $attendence_value['over_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $attendence_value['off_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $attendence_value['leave_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $attendence_value['holiday_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $attendence_value['error_time']);
                $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $attendence_value['late_time']);
                $line = $line + $line_add + 1;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$line, $staff['data'][$i]['name']);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$line, $sorted_depts[$staff['data'][$i]['dept_id']]['dept_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$line, $staff['data'][$i]['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$line, '');
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$line, $attendence['sum']['work_day']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$line, '');
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$line, '');
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$line, $attendence['sum']['legal_work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$line, $attendence['sum']['work_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$line, $attendence['sum']['over_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$line, $attendence['sum']['off_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$line, $attendence['sum']['leave_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$line, $attendence['sum']['holiday_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$line, $attendence['sum']['error_time']);
            $objPHPExcel->getActiveSheet()->setCellValue('O'.$line, $attendence['sum']['late_time']);
            $line = $line + 2;
        }        
        $excel_name = $dept_id?$sorted_depts[$dept_id]['dept_name']:'all';
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="考勤_'.$excel_name . '-'. $start_date . '_' .$end_date.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
}