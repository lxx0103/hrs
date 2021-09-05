<?php

class Menu extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
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
        $this->data['all_menus'] = $menu_level;
        // echo '<pre>';
        // print_r($menu_level);
        $this->load->view('privilege/menu_list_v', $this->data);
    }


    public function one()
    {
        $menu_id = trim($this->input->post('menu_id'));
        $role = $this->Menu_m->get_menu_by_id($menu_id, false);
        echo json_encode($role);
    }

    public function save()
    {
        $menu_id = trim($this->input->post('menu_id'));
        $name = trim($this->input->post('name'));
        $dir = trim($this->input->post('dir'));
        $controller = trim($this->input->post('controller'));
        $method = trim($this->input->post('method'));
        $parent_id = trim($this->input->post('parent_id'));
        $is_hidden = trim($this->input->post('is_hidden'));
        $is_enable = trim($this->input->post('is_enable'));
        $save = $this->Menu_m->save($menu_id, $name, $dir, $controller, $method, $parent_id, $is_hidden, $is_enable, $this->session->username);
        echo json_encode($save);
    }






}