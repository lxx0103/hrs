<?php

class Addition extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin/Addition_m');
        $this->load->model('organization/Department_m');
    }

    public function index()
    {
        $filters['target'] = trim($this->input->get('target'));
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['type'] = trim($this->input->get('type'));
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
        $additions = $this->Addition_m->get_all_addition($filters, false);
        $this->data['total'] = $additions['total'];
        $this->data['filters'] = $filters;
        $this->data['additions'] = $additions['data'];
        $this->data['query_str'] = $query_str;
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->load->view('checkin/addition_list_v', $this->data);
    }


    public function one()
    {
        $addition_id = trim($this->input->post('addition_id'));
        $addition = $this->Addition_m->get_one_addition($addition_id, false);
        echo json_encode($addition);
    }

    public function save()
    {
        $addition_id = trim($this->input->post('addition_id'));
        $target = trim($this->input->post('target'));
        $dept_id = trim($this->input->post('dept_id'));
        $staff_code = trim($this->input->post('staff_code'));
        $addition = trim($this->input->post('addition'));
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Addition_m->save($addition_id, $target, $dept_id, $staff_code, $addition, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }

    public function saveall()
    {
        $staff_code = $this->input->post('staff_code');
        $addition = trim($this->input->post('addition'));
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Addition_m->save_all_staff($staff_code, $addition, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }


    public function savedateall()
    {
        $staff_code = trim($this->input->post('staff_code'));
        $addition = $this->input->post('addition');
        $hours = trim($this->input->post('hours'));
        $type = trim($this->input->post('type'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Addition_m->save_all_date($staff_code, $addition, $hours, $type, $is_enable, $this->session->username);
        echo json_encode($save);
    }


}