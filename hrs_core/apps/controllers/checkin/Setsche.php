<?php

class Setsche extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/Department_m');
        $this->load->model('checkin/Setsche_m');
    }

    public function index()
    {
        $rules = $this->Setsche_m->get_all_rule(false);
        $this->data['rules'] = $rules['data'];
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->load->view('checkin/setsche_list_v', $this->data);
    }


    public function one()
    {
        $rule_id = trim($this->input->post('rule_id'));
        $rule = $this->Setsche_m->get_one_rule($rule_id, false);
        echo json_encode($rule);
    }

    public function save()
    {
        $rule_id = trim($this->input->post('rule_id'));
        $dept_id = trim($this->input->post('dept_id'));
        $start_date = trim($this->input->post('start_date'));
        $end_date = trim($this->input->post('end_date'));
        $start_time = trim($this->input->post('start_time'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Setsche_m->save($rule_id, $dept_id, $start_date, $end_date, $start_time, $is_enable, $this->session->username);
        echo json_encode($save);
    }

    public function staff()
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
        $rules = $this->Setsche_m->get_all_rule_staff($filters, false);
        $this->data['total'] = $rules['total'];
        $this->data['filters'] = $filters;
        $this->data['rules'] = $rules['data'];
        $this->data['query_str'] = $query_str;
        $this->load->view('checkin/setsche_staff_list_v', $this->data);
    }


    public function onestaff()
    {
        $rule_id = trim($this->input->post('rule_id'));
        $rule = $this->Setsche_m->get_one_rule_staff($rule_id, false);
        echo json_encode($rule);
    }

    public function savestaff()
    {
        $rule_id = trim($this->input->post('rule_id'));
        $staff_code = trim($this->input->post('staff_code'));
        $start_date = trim($this->input->post('start_date'));
        $end_date = trim($this->input->post('end_date'));
        $start_time = trim($this->input->post('start_time'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Setsche_m->save_staff($rule_id, $staff_code, $start_date, $end_date, $start_time, $is_enable, $this->session->username);
        echo json_encode($save);
    }

    public function savestaffall()
    {
        $staff_code = $this->input->post('staff_code');
        $start_date = trim($this->input->post('start_date'));
        $end_date = trim($this->input->post('end_date'));
        $start_time = trim($this->input->post('start_time'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Setsche_m->save_staff_all($staff_code, $start_date, $end_date, $start_time, $is_enable, $this->session->username);
        echo json_encode($save);
    }


    public function savedateall()
    {
        $staff_code = trim($this->input->post('staff_code'));
        $start_date = $this->input->post('start_date');
        $start_time = trim($this->input->post('start_time'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Setsche_m->save_date_all($staff_code, $start_date, $start_time, $is_enable, $this->session->username);
        echo json_encode($save);
    }



}