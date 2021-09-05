<?php

class Staff_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_staff($filters, $is_enable = 1, $orderby = 'id')
    {
        $sql = "SELECT * FROM s_staff WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM s_staff WHERE 1";
        $where = array();
        if(isset($filters['dept_id']) && $filters['dept_id'])
        {
            $sql .= ' AND dept_id = ?';
            $count_sql .= ' AND dept_id = ?';
            array_push($where, $filters['dept_id']);
        }        
        if(isset($filters['dept_ids']) && $filters['dept_ids'])
        {
            $sql .= ' AND dept_id in  ('.$filters['dept_ids'].')';
            $count_sql .= ' AND dept_id in ('.$filters['dept_ids'].')';
        }
        if(isset($filters['name']) && $filters['name'])
        {
            $sql .= ' AND name = ?';
            $count_sql .= ' AND name = ?';
            array_push($where, $filters['name']);
        }
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['is_working']) && $filters['is_working'] == 1)
        {
            $sql .= ' AND out_date = "1970-01-01"';
            $count_sql .= ' AND out_date = "1970-01-01"';
        }
        if(isset($filters['is_working']) && $filters['is_working'] == 2)
        {
            $sql .= ' AND out_date != "1970-01-01"';
            $count_sql .= ' AND out_date != "1970-01-01"';
        }
        if(isset($filters['start_date']) && $filters['start_date']){
            $sql .= ' AND (out_date > ? OR out_date = "1970-01-01")';
            $count_sql .= ' AND (out_date > ? OR out_date = "1970-01-01")';
            array_push($where, $filters['start_date']);
        }
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
            $count_sql .= ' AND is_enable = 1';
        }
        $sql .= ' ORDER BY '. $orderby .' ASC';
        $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $menus = $query->result_array();
        $count = $count_query->row_array();
        if($menus)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $menus, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '菜单不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_staff_by_id($staff_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_staff WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($staff_id)); 
        $role = $query->row_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($staff_data, $user)
    {   
        if(!isset($staff_data['id']) || $staff_data['id'] == 0)
        {
            $staff_data['create_user'] = $user;
            $staff_data['update_user'] = $user;
            $str = $this->db->insert_string('s_staff', $staff_data);
        }else{
            $where = "id = ". $staff_data['id'];
            unset($staff_data['id']);
            $staff_data['update_user'] = $user;            
            $str = $this->db->update_string('s_staff', $staff_data, $where);
        }
        //入列操作
        if(isset($staff_data['in_date']) && $staff_data['in_date'] != ''){
            $queue_data = array('target' => 2, 'dept_id' => 0, 'staff_code' => $staff_data['staff_code'], 'date' => $staff_data['in_date'], 'is_enable' => 1, 'create_user' => $user);
            $queue_str = $this->db->insert_string('s_queue', $queue_data);
            $queue_query = $this->db->query($queue_str);
        }
        if(isset($staff_data['out_date']) && $staff_data['out_date'] != ''){
            $queue_data1 = array('target' => 2, 'dept_id' => 0, 'staff_code' => $staff_data['staff_code'], 'date' => $staff_data['out_date'], 'is_enable' => 1, 'create_user' => $user);
            $queue_str1 = $this->db->insert_string('s_queue', $queue_data1);
            $queue_query1 = $this->db->query($queue_str1);
        }
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function get_machine_ids($staff_codes, $is_enable = 1)
    {
        $staff_str = implode('","', $staff_codes);
        $staff_str = '("'. $staff_str . '")';
        $sql = "SELECT machine_id FROM s_staff WHERE staff_code in ". $staff_str ;
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql); 
        $role = $query->result_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );

    }

    public function get_machine_id_rel($staff_code, $is_enable = 1)
    {        
        $sql = "SELECT * FROM s_staff_machine WHERE machine_code = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " ORDER BY ID DESC LIMIT 1";
        $query = $this->db->query($sql, array($staff_code)); 
        $role = $query->row_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }


    public function get_staff_by_code($staff_code, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_staff WHERE staff_code = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($staff_code)); 
        $role = $query->row_array();
        if($role)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $role);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

}