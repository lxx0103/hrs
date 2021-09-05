<?php

class Position_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_position($is_enable = 1)
    {
        $sql = "SELECT * FROM s_position";
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
        return array('status' => 2, 'msg' => '职务不存在', 'data' => array() );
    }

    public function get_one_position($position_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_position WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($position_id)); 
        $position = $query->row_array();
        if($position)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $position);
        }
        return array('status' => 2, 'msg' => '职务不存在', 'data' => array() );
    }

    public function save($position_id, $position_name, $is_enable, $user)
    {
        if($position_id == 0)
        {
            $data = array('position_name' => $position_name, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_position', $data);
        }else{
            $data = array('position_name' => $position_name, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $position_id;
            $str = $this->db->update_string('s_position', $data, $where);
        }
            $query = $this->db->query($str);
            return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}