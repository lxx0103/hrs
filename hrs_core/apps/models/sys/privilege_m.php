<?php

class Privilege_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    public function check_role_privilege($role_id, $menu_id)
    {
        $sql = "SELECT * FROM u_role_privilege WHERE role_id = ? AND menu_id = ? AND is_enable = 1 AND is_delete = 0 LIMIT 1";
        $query = $this->db->query($sql, array($role_id, $menu_id)); 
        $privilege = $query->row_array();
        if($privilege)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $privilege);
        }
        return array('status' => 2, 'msg' => '菜单不存在', 'data' => array() );
    }

    public function get_privilege_by_role($role_id)
    {
        $sql = "SELECT * FROM u_role_privilege WHERE role_id = ? AND is_enable = 1 AND is_delete = 0";
        $query = $this->db->query($sql, array($role_id));
        $privileges = $query->result_array();
        return array('status' => 1, 'msg' => '成功', 'data' => $privileges);
    }

    public function save($role_id, $menus, $user)
    {
        //删除所有权限
        $delete_data = array('is_delete' => 1, 'update_user' => $user);
        $delete_where = "role_id = ". $role_id;
        $delete_str = $this->db->update_string('u_role_privilege', $delete_data, $delete_where);
        $this->db->query($delete_str);
        //添加权限
        if($menus != '')
        {
            $menu_array = explode(',', $menus);
            $insert_data = array();
            foreach ($menu_array as $key => $value) {
                $insert_data[] = array('role_id' => $role_id, 'menu_id' => $value, 'is_enable' => 1, 'create_user' => $user, 'update_user' => $user);
            }
            $this->db->insert_batch('u_role_privilege', $insert_data);
        }
        return array('status' => 1, 'msg' => '成功！');
    }
}