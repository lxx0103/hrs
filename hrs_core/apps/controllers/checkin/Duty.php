<?php

class Duty extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin/Duty_m');
        $this->load->model('organization/Department_m');
    }

    public function index()
    {
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['month'] = trim($this->input->get('month'));
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
        $dutys = $this->Duty_m->get_all_duty($filters, false);
        $this->data['total'] = $dutys['total'];
        $this->data['filters'] = $filters;
        $this->data['dutys'] = $dutys['data'];
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/duty_list_v', $this->data);
    }


    public function one()
    {
        $duty_id = trim($this->input->post('duty_id'));
        $duty = $this->Duty_m->get_one_duty($duty_id, false);
        echo json_encode($duty);
    }

    public function save()
    {
        $duty_id = trim($this->input->post('duty_id'));
        $staff_code = trim($this->input->post('staff_code'));
        $duty = trim($this->input->post('duty'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Duty_m->save($duty_id, $staff_code, $duty, $is_enable, $this->session->username);
        echo json_encode($save);
    }


    public function saveall()
    {
        $staff_code = $this->input->post('staff_code');
        $duty = trim($this->input->post('duty'));
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Duty_m->save_all_staff($staff_code, $duty, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }




}