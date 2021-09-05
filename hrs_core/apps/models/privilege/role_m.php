<?php

class Role_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_role($is_enable = 1)
    {
        $sql = "SELECT * FROM u_role";
        if($is_enable == 1)
        {
            $sql .= ' WHERE is_enable = 1';
        }
        $query = $this->db->query($sql); 
        $row = $query->result_array();
        if($row)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $row);
        }
        return array('status' => 2, 'msg' => '菜单不存在', 'data' => array() );
    }

    public function get_one_role($role_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM u_role WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($role_id)); 
        $role = $query->row_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($role_id, $role_name, $is_enable, $user)
    {
        if($role_id == 0)
        {
            $data = array('role_name' => $role_name, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('u_role', $data);
        }else{
            $data = array('role_name' => $role_name, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $role_id;
            $str = $this->db->update_string('u_role', $data, $where);
        }
            $query = $this->db->query($str);
            return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}