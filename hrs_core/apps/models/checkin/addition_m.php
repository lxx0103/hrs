<?php

class Addition_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_addition($filters, $is_enable = 1, $orderby = 'id')
    {
        $sql = "SELECT * FROM s_addition WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM s_addition WHERE 1";
        $where = array();
        if(isset($filters['target']) && $filters['target'])
        {
            $sql .= ' AND target = ?';
            $count_sql .= ' AND target = ?';
            array_push($where, $filters['target']);
        }
        if(isset($filters['dept_id']) && $filters['dept_id'])
        {
            $sql .= ' AND dept_id = ?';
            $count_sql .= ' AND dept_id = ?';
            array_push($where, $filters['dept_id']);
        }
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['type']) && $filters['type'])
        {
            $sql .= ' AND type = ?';
            $count_sql .= ' AND type = ?';
            array_push($where, $filters['type']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND addition >= ?';
            $count_sql .= ' AND addition >= ?';
            array_push($where, $filters['month']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND addition < ?';
            $count_sql .= ' AND addition < ?';
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
        $additions = $query->result_array();
        $count = $count_query->row_array();
        if($additions)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $additions, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_all_addition_by_month($month, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_addition WHERE addition >= ? AND addition <= ?";
        $month_start = $month . '-01';
        $month_end = $month . '-31';
        $where = array($month_start, $month_end);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $additions = $query->result_array();
        if($additions)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $additions,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function get_all_addition_by_date2($start_date, $end_date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_addition WHERE addition >= ? AND addition <= ?";
        $where = array($start_date, $end_date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $additions = $query->result_array();
        if($additions)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $additions,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }


    public function get_one_addition($addition_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_addition WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($addition_id)); 
        $addition = $query->row_array();
        if($addition)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $addition);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($addition_id, $target, $dept_id, $staff_code, $addition, $hours, $type, $is_enable, $user)
    {
        if(!in_array($target, array(1,2,3)))
        {
            return array('status' => 2, 'msg' => '请选择对象', 'data' => array() );
        }
        if($target == 1 && !$dept_id)
        {
            return array('status' => 2, 'msg' => '请选择部门', 'data' => array() );
        }
        if($target == 2 && !$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if($target == 3)
        {
            $dept_id = 0;
            $staff_code = '';
        }elseif ($target == 1) 
        {
            $staff_code = '';
        }else
        {
            $dept_id = 0;
        }
        if(!$addition)
        {
            return array('status' => 2, 'msg' => '请选择连班日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择连班时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        if($addition_id == 0)
        {
            $count_sql = "SELECT COUNT(1) AS total FROM s_addition WHERE target = ? AND dept_id = ? AND staff_code = ? AND addition = ? AND is_enable = 1";
            $where = array();
            array_push($where, $target);
            array_push($where, $dept_id);
            array_push($where, $staff_code);
            array_push($where, $addition);
            $count_query = $this->db->query($count_sql, $where);
            $count = $count_query->row_array();
            if($count['total'] != 0){
                return array('status' => 2, 'msg' => '一天只能设置一次连班，需要重新设置请先删除');
            }
            $data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'addition' => $addition, 'hours' => $hours, 'type' => $type, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_addition', $data);
        }else{
            $data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'addition' => $addition, 'hours' => $hours, 'type' => $type, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $addition_id;
            $str = $this->db->update_string('s_addition', $data, $where);
        }
        //入列操作
        $queue_data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'date' => $addition, 'is_enable' => 1, 'create_user' => $user);
        $queue_str = $this->db->insert_string('s_queue', $queue_data);
        $queue_query = $this->db->query($queue_str);
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }


    public function get_all_addition_by_date($date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_addition WHERE addition = ?";
        $where = array($date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $additions = $query->result_array();
        if($additions)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $additions,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function save_all_staff($staff_code, $addition, $hours, $type, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$addition)
        {
            return array('status' => 2, 'msg' => '请选择连班日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择连班时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        $data = array();
        foreach ($staff_code as $key => $value) {
            $count_sql = "SELECT COUNT(1) AS total FROM s_addition WHERE target = 2 AND dept_id = 0 AND staff_code = ? AND addition = ? AND is_enable = 1";
            $count_where = array();
            array_push($count_where, $value);
            array_push($count_where, $addition);
            $count_query = $this->db->query($count_sql, $count_where);
            $count = $count_query->row_array();
            if($count['total'] != 0){
                return array('status' => 2, 'msg' => $value.'一天只能设置一次连班，需要重新设置请先删除');
            }
            $data[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'addition' => $addition, 
                'hours' => $hours, 
                'type' => $type, 
                'is_enable' => $is_enable, 
                'type' => $type, 
                'create_user' => $user
            );
            //入列数据
            $queue_data[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $addition, 
                'is_enable' => 1, 
                'create_user' => $user
            );
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $str = $this->db->insert_batch('s_addition', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }


    public function save_all_date($staff_code, $addition, $hours, $type, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$addition)
        {
            return array('status' => 2, 'msg' => '请选择连班日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择连班时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        $data = array();
        foreach ($addition as $key => $value) {
            $count_sql = "SELECT COUNT(1) AS total FROM s_addition WHERE target = 2 AND dept_id = 0 AND staff_code = ? AND addition = ? AND is_enable = 1";
            $count_where = array();
            array_push($count_where, $staff_code);
            array_push($count_where, $value);
            $count_query = $this->db->query($count_sql, $count_where);
            $count = $count_query->row_array();
            if($count['total'] != 0){
                return array('status' => 2, 'msg' => $value.'一天只能设置一次连班，需要重新设置请先删除');
            }
            $data[$key] = array(
                'staff_code' => $staff_code, 
                'target' => 2, 
                'dept_id' => 0, 
                'addition' => $value, 
                'hours' => $hours, 
                'type' => $type, 
                'is_enable' => $is_enable, 
                'type' => $type, 
                'create_user' => $user
            );
            //入列数据
            $queue_data[$key] = array(
                'staff_code' => $staff_code, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $value, 
                'is_enable' => 1, 
                'create_user' => $user
            );
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $str = $this->db->insert_batch('s_addition', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}