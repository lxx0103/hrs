<?php

class Duty_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_duty($filters, $is_enable = 1, $orderby = 'id')
    {
        $sql = "SELECT * FROM s_duty WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM s_duty WHERE 1";
        $where = array();
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND duty >= ?';
            $count_sql .= ' AND duty >= ?';
            array_push($where, $filters['month']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND duty < ?';
            $count_sql .= ' AND duty < ?';
            $end_of_the_month = date('Y-m-d', strtotime($filters['month'] . ' +1 month'));
            array_push($where, $end_of_the_month);
        }
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= ' ORDER BY '. $orderby .' ASC';
        $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $dutys = $query->result_array();
        $count = $count_query->row_array();
        if($dutys)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dutys, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_all_duty_by_month($month, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_duty WHERE duty >= ? AND duty <= ?";
        $month_start = $month . '-01';
        $month_end = $month . '-31';
        $where = array($month_start, $month_end);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $dutys = $query->result_array();
        if($dutys)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dutys,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function get_all_duty_by_date2($start_date, $end_date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_duty WHERE duty >= ? AND duty <= ?";
        $where = array($start_date, $end_date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $dutys = $query->result_array();
        if($dutys)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dutys,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function get_one_duty($duty_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_duty WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($duty_id)); 
        $duty = $query->row_array();
        if($duty)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $duty);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($duty_id, $staff_code, $duty, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$duty)
        {
            return array('status' => 2, 'msg' => '请选择假期日期', 'data' => array() );
        }
        if($duty_id == 0)
        {
            $data = array('staff_code' => $staff_code, 'duty' => $duty, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_duty', $data);
        }else{
            $data = array('staff_code' => $staff_code, 'duty' => $duty, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $duty_id;
            $str = $this->db->update_string('s_duty', $data, $where);
        }
        //入列操作
        $queue_data = array('target' => 2, 'dept_id' => 0, 'staff_code' => $staff_code, 'date' => $duty, 'is_enable' => 1, 'create_user' => $user);
        $queue_str = $this->db->insert_string('s_queue', $queue_data);
        $queue_query = $this->db->query($queue_str);
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function get_all_duty_by_date($date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_duty WHERE duty = ?";
        $where = array($date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $dutys = $query->result_array();
        if($dutys)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $dutys,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function save_all_staff($staff_code, $duty, $hours, $type, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$duty)
        {
            return array('status' => 2, 'msg' => '请选择假期日期', 'data' => array() );
        }
        $data = array();
        foreach ($staff_code as $key => $value) {
            $data[$key] = array(
                'staff_code' => $value, 
                'duty' => $duty, 
                'is_enable' => $is_enable, 
                'type' => $type, 
                'create_user' => $user
            );
            //入列数据
            $queue_data[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $duty, 
                'is_enable' => 1, 
                'create_user' => $user
            );
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $str = $this->db->insert_batch('s_duty', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}