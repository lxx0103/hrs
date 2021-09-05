<?php

class Position extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/Position_m');
    }

    public function index()
    {
        $positions = $this->Position_m->get_all_position(false);
        $this->data['positions'] = $positions['data'];
        $this->load->view('organization/position_list_v', $this->data);
    }


    public function one()
    {
        $position_id = trim($this->input->post('position_id'));
        $position = $this->Position_m->get_one_position($position_id, false);
        echo json_encode($position);
    }

    public function save()
    {
        $position_id = trim($this->input->post('position_id'));
        $position_name = trim($this->input->post('position_name'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Position_m->save($position_id, $position_name, $is_enable, $this->session->username);
        echo json_encode($save);
    }






}