<?php

class Privilege extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $role_id = trim($this->input->get('role_id'));
        if(!$role_id){
            redirect('privilege/role');
        }
        $menus = $this->Menu_m->get_all_menu(false);
        $sorted_menus = array();
        foreach ($menus['data'] as $row) 
        {
            $sorted_menus[$row['id']] = $row;
        }
        $menu_level = array();
        foreach ($sorted_menus as $key => $value)
        {
            if($value['parent_id'] == 0)
            {
                $menu_level[$key] = $value;             
            }
            elseif(isset($sorted_menus[$value['parent_id']]))
            {
                $menu_level[$value['parent_id']]['child'][] = $value;
            }
        }
        $privileges = $this->Privilege_m->get_privilege_by_role($role_id);
        $assigned = array();
        foreach ($privileges['data'] as $privilege) {
            $assigned[] = $privilege['menu_id'];
        }
        $this->data['privileges'] = $assigned;
        $this->data['all_menus'] = $menu_level;
        $this->data['role_id'] = $role_id;
        $this->load->view('privilege/privilege_list_v', $this->data);
    }


    public function save()
    {
        $role_id = trim($this->input->post('role_id'));
        $menus = trim($this->input->post('menus'), ',');
        $save = $this->Privilege_m->save($role_id, $menus, $this->session->username);
        echo json_encode($save);
    }



    public function pagesize()
    {
        $page_size = trim($this->input->post('page_size'));
        $this->session->page_size = $page_size;
        echo json_encode(array('status' => 1, 'msg' => '成功'));
    }



}