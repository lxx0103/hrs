<?php

class Menu_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_menu($is_enable = 1)
    {
        $sql = "SELECT * FROM s_menu";
        if($is_enable == 1)
        {
            $sql .= ' WHERE is_enable = 1';
        }
        $query = $this->db->query($sql); 
        $menus = $query->result_array();
        if($menus)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $menus);
        }
        return array('status' => 2, 'msg' => '菜单不存在', 'data' => array() );
    }

    public function get_one_menu($directory_name, $class_name, $method_name, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_menu WHERE dir = ? AND controller = ? AND method = ?";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        if($method_name == 'index')
        {
            $method_name = '';
        }
        $query = $this->db->query($sql, array($directory_name, $class_name, $method_name)); 
        $menu = $query->row_array();
        // var_dump($menu);die();
        if($menu)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $menu);
        }
        return array('status' => 2, 'msg' => '菜单不存在', 'data' => array() );
    }

    public function get_menu_by_id($menu_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_menu WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($menu_id)); 
        $role = $query->row_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($menu_id, $name, $dir, $controller, $method, $parent_id, $is_hidden, $is_enable, $user)
    {
        if($menu_id == 0)
        {
            $data = array('name' => $name, 'dir' => $dir, 'controller' => $controller, 'method' => $method, 'parent_id' => $parent_id, 'is_hidden' => $is_hidden, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_menu', $data);
        }else{
            $data = array('name' => $name, 'dir' => $dir, 'controller' => $controller, 'method' => $method, 'parent_id' => $parent_id, 'is_hidden' => $is_hidden, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $menu_id;
            $str = $this->db->update_string('s_menu', $data, $where);
        }
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}