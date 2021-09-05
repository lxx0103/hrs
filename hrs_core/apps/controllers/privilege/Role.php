<?php

class Role extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('privilege/Role_m');
    }

    public function index()
    {
        $roles = $this->Role_m->get_all_role(false);
        $this->data['roles'] = $roles['data'];
        $this->load->view('privilege/role_list_v', $this->data);
    }


    public function one()
    {
        $role_id = trim($this->input->post('role_id'));
        $role = $this->Role_m->get_one_role($role_id, false);
        echo json_encode($role);
    }

    public function save()
    {
        $role_id = trim($this->input->post('role_id'));
        $role_name = trim($this->input->post('role_name'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Role_m->save($role_id, $role_name, $is_enable, $this->session->username);
        echo json_encode($save);
    }






}