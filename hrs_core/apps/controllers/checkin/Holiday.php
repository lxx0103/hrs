<?php

class Holiday extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin/Holiday_m');
        $this->load->model('organization/Department_m');
    }

    public function index()
    {
        $filters['target'] = trim($this->input->get('target'));
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['type'] = trim($this->input->get('type'));
        $filters['month'] = trim($this->input->get('month'));
        $filters['is_enable'] = trim($this->input->get('is_enable'))===''?2:trim($this->input->get('is_enable'));
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
        $holidays = $this->Holiday_m->get_all_holiday($filters);
        $this->data['total'] = $holidays['total'];
        $this->data['filters'] = $filters;
        $this->data['holidays'] = $holidays['data'];
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/holiday_list_v', $this->data);
    }


    public function one()
    {
        $holiday_id = trim($this->input->post('holiday_id'));
        $holiday = $this->Holiday_m->get_one_holiday($holiday_id, false);
        echo json_encode($holiday);
    }

    public function save()
    {
        $holiday_id = trim($this->input->post('holiday_id'));
        $target = trim($this->input->post('target'));
        $dept_id = trim($this->input->post('dept_id'));
        $staff_code = trim($this->input->post('staff_code'));
        $holiday = trim($this->input->post('holiday'));
        $holiday_end = trim($this->input->post('holiday_end'));
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Holiday_m->save($holiday_id, $target, $dept_id, $staff_code, $holiday, $holiday_end, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }


    public function saveall()
    {
        $staff_code = $this->input->post('staff_code');
        $holiday = trim($this->input->post('holiday'));
        $holiday_end = trim($this->input->post('holiday_end'));
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Holiday_m->save_all_staff($staff_code, $holiday, $holiday_end, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }

    public function savedateall()
    {
        $staff_code = trim($this->input->post('staff_code'));
        $holiday = $this->input->post('holiday');
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Holiday_m->save_all_date($staff_code, $holiday, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }



    public function expholiday()
    {
        $filters['target'] = trim($this->input->get('target'));
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['type'] = trim($this->input->get('type'));
        $filters['month'] = trim($this->input->get('month'));
        $filters['is_enable'] = trim($this->input->get('is_enable'))===''?2:trim($this->input->get('is_enable'));
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = 1;
        $filters['page_size'] = 65536;
        $holidays = $this->Holiday_m->get_all_holiday($filters);
        $holidays_data = $holidays['data'];
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '放假对象');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '开始日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '结束日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '时长');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '类型');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '是否启用');
        $line = 2;
        foreach ($holidays_data as $holiday_row) { 
            $row_target = '';
            $row_department = ''; 
            $row_type = '';
            if($holiday_row['target'] == 1){
                $row_target = '部门';
            } 
            elseif($holiday_row['target'] == 2){
                $row_target = '员工';
            } 
            elseif($holiday_row['target'] == 3){
                $row_target = '全公司';
            }
            if($holiday_row['dept_id'] != 0)
            {
                $row_department = $sorted_depts[$holiday_row['dept_id']]['dept_name'];
            }
            if($holiday_row['type'] == 1){
                $row_type = '放假';
            } 
            elseif($holiday_row['type'] == 2){
                $row_type = '事假';
            } 
            elseif($holiday_row['type'] == 3){
                $row_type = '病假';
            }
            elseif($holiday_row['type'] == 4){
                $row_type = '旷工';
            }
            elseif($holiday_row['type'] == 5){
                $row_type = '其他';
            }
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $line, $row_target);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $line, $row_department);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $line, $holiday_row['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $line, $holiday_row['holiday']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $line, $holiday_row['holiday_end']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $line, $holiday_row['hours']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $line, $row_type);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $line, $holiday_row['is_enable']?'是':'否');
            $line ++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="请假记录.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}