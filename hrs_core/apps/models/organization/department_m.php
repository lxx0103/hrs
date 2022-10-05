<?php

class Department_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_dept($is_enable = 1)
    {
        $sql = "SELECT * FROM s_department";
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
        return array('status' => 2, 'msg' => '部门不存在', 'data' => array() );
    }

    public function get_one_dept($dept_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_department WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($dept_id)); 
        $dept = $query->row_array();
        if($dept)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dept);
        }
        return array('status' => 2, 'msg' => '部门不存在', 'data' => array() );
    }

    public function save($dept_id, $dept_name, $has_overtime, $noon_break_start, $noon_break_end, $night_break_start, $night_break_end, $xianbie, $rengongleibie, $floor, $gongziguishufeiyong, $is_enable, $user)
    {
        if($dept_id == 0)
        {
            $data = array('dept_name' => $dept_name, 'has_overtime' => $has_overtime, 'noon_break_start' => $noon_break_start, 'noon_break_end' => $noon_break_end, 'night_break_start' => $night_break_start, 'night_break_end' => $night_break_end, 'xianbie' => $xianbie, 'rengongleibie' => $rengongleibie, 'floor' => $floor, 'gongziguishufeiyong' => $gongziguishufeiyong, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_department', $data);
        }else{
            $data = array('dept_name' => $dept_name, 'has_overtime' => $has_overtime, 'noon_break_start' => $noon_break_start, 'noon_break_end' => $noon_break_end, 'night_break_start' => $night_break_start, 'night_break_end' => $night_break_end, 'xianbie' => $xianbie, 'rengongleibie' => $rengongleibie, 'floor' => $floor, 'gongziguishufeiyong' => $gongziguishufeiyong, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $dept_id;
            $str = $this->db->update_string('s_department', $data, $where);
        }
            $query = $this->db->query($str);
            return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }


    public function get_one_dept_by_name($dept_name, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_department WHERE dept_name = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($dept_name)); 
        $dept = $query->row_array();
        if($dept)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dept);
        }
        return array('status' => 2, 'msg' => '部门不存在', 'data' => array() );
    }
}