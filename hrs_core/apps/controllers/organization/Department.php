<?php

class Department extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/Department_m');
    }

    public function index()
    {
        $depts = $this->Department_m->get_all_dept(false);
        $this->data['depts'] = $depts['data'];
        $this->load->view('organization/department_list_v', $this->data);
    }


    public function one()
    {
        $dept_id = trim($this->input->post('dept_id'));
        $dept = $this->Department_m->get_one_dept($dept_id, false);
        echo json_encode($dept);
    }

    public function save()
    {
        $dept_id = trim($this->input->post('dept_id'));
        $dept_name = trim($this->input->post('dept_name'));
        $has_overtime = trim($this->input->post('has_overtime'));
        $noon_break_start = trim($this->input->post('noon_break_start'));
        $noon_break_end = trim($this->input->post('noon_break_end'));
        $night_break_start = trim($this->input->post('night_break_start'));
        $night_break_end = trim($this->input->post('night_break_end'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Department_m->save($dept_id, $dept_name, $has_overtime, $noon_break_start, $noon_break_end, $night_break_start, $night_break_end, $is_enable, $this->session->username);
        echo json_encode($save);
    }






}