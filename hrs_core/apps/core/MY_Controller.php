<?php

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->data = array();
        $this->check_login();
        $this->load->model('sys/Menu_m');
        $this->load->model('sys/Privilege_m');
        $this->check_privilege();
        $this->get_menus();
        if(!isset($this->session->page_size)||$this->session->page_size ==0){
            $this->session->page_size = 20;
        }
    }

    private function check_login()
    {
        if($this->session->is_logged_in === 1)
        {
            $this->data['user'] = array();
            $this->data['user']['username'] = $this->session->username;
            $this->data['user']['role_name'] = $this->session->role_name;
        }else
        {
            redirect('auth/login');
        }
    }

    private function check_privilege()
    {
        $directory_name = trim($this->router->fetch_directory(), '/');
        $class_name = $this->router->fetch_class();
        $method_name = $this->router->fetch_method();
        $menu = $this->Menu_m->get_one_menu($directory_name, $class_name, $method_name);
        if($menu['status'] == 1)
        {
            $this->data['current_menu'] = $menu['data'];
        }else
        {
            redirect('home/exists');
        }
        if($menu['data']['need_privilege'] == 1)
        {
            $role_privilege = $this->Privilege_m->check_role_privilege($this->session->role_id, $menu['data']['id']);
            if($role_privilege['status'] !== 1)
            {
                redirect('home/privilege');
            }
        }
    }

    private function get_menus()
    {
        $menus = $this->Menu_m->get_all_menu();
        if($menus['status'] == 1)
        {
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
                    if($value['is_hidden'] == 0)
                    {
                        $menu_level[$key] = $value;
                    }                    
                }
                elseif(isset($sorted_menus[$value['parent_id']]) && $sorted_menus[$value['parent_id']]['is_hidden'] == 0)
                {
                    if($value['is_hidden'] == 0)
                    {
                        $menu_level[$value['parent_id']]['child'][] = $value;
                    }
                }
            }
            // var_dump($menu_level);
            $this->data['menus'] = $menu_level;

        }else
        {
            $this->data['menus'] = array();
        }
    }
}