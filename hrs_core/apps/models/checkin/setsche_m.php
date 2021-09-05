<?php

class Setsche_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_rule($is_enable = 1)
    {
        $sql = "SELECT * FROM s_dept_sche";
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
        return array('status' => 2, 'msg' => '不存在', 'data' => array() );
    }

    public function get_one_rule($rule_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_dept_sche WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($rule_id)); 
        $rule = $query->row_array();
        if($rule)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $rule);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array() );
    }

    public function get_rule_by_dept_id($dept_id, $date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_dept_sche WHERE dept_id = ? AND start_date <= ? AND end_date >= ?";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= ' ORDER BY start_time ASC';
        $query = $this->db->query($sql, array($dept_id, $date, $date)); 
        $rule = $query->result_array();

        if($rule)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $rule);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array() );
    }

    public function save($rule_id, $dept_id, $start_date, $end_date, $start_time, $is_enable, $user)
    {
        if(!$dept_id){
            return array('status' => 2, 'msg' => '部门错误', 'data' => array() );
        }
        if(!$start_date){
            return array('status' => 2, 'msg' => '开始日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $start_date)){
            return array('status' => 2, 'msg' => '开始日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$end_date){
            return array('status' => 2, 'msg' => '结束日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $end_date)){
            return array('status' => 2, 'msg' => '结束日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$start_time){
            return array('status' => 2, 'msg' => '上班时间错误', 'data' => array() );
        }
        if($rule_id == 0)
        {
            $data = array('dept_id' => $dept_id, 'start_date' => $start_date, 'end_date' => $end_date, 'start_time' => $start_time, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_dept_sche', $data);
        }else{
            $data = array('dept_id' => $dept_id, 'start_date' => $start_date, 'end_date' => $end_date, 'start_time' => $start_time, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $rule_id;
            $str = $this->db->update_string('s_dept_sche', $data, $where);
        }
        //入列操作
        if($start_date == $end_date){
            $queue_data = array('target' => 1, 'dept_id' => $dept_id, 'staff_code' => '', 'date' => $start_date, 'is_enable' => 1, 'create_user' => $user);
            $queue_str = $this->db->insert_string('s_queue', $queue_data);
            $queue_query = $this->db->query($queue_str);            
        }else{
            $queue_data = array();            
            $period = new DatePeriod(
                new DateTime($start_date),
                new DateInterval('P1D'),
                new DateTime($end_date)
            );
            foreach ($period as $date){
                $queue_data[] = array(
                    'staff_code' => '', 
                    'target' => 1, 
                    'dept_id' => $dept_id, 
                    'date' => $date->format('Y-m-d'), 
                    'is_enable' => 1, 
                    'create_user' => $user
                );
            }
            $queue_data[] = array(
                'staff_code' => '', 
                'target' => 1, 
                'dept_id' => $dept_id, 
                'date' => $end_date, 
                'is_enable' => 1, 
                'create_user' => $user
            );
            $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        }
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function get_all_rule_staff($filters, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_staff_sche WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM s_staff_sche WHERE 1";
        $where = array();
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND start_date >= ?';
            $count_sql .= ' AND start_date >= ?';
            array_push($where, $filters['month']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND start_date < ?';
            $count_sql .= ' AND start_date < ?';
            $end_of_the_month = date('Y-m-d', strtotime($filters['month'] . ' +1 month'));
            array_push($where, $end_of_the_month);
        }
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $rules = $query->result_array();
        $count = $count_query->row_array();
        if($rules)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $rules, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_one_rule_staff($rule_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_staff_sche WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($rule_id)); 
        $rule = $query->row_array();
        if($rule)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $rule);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array() );
    }

    public function get_rule_by_staff_code($staff_code, $date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_staff_sche WHERE staff_code = ? AND start_date <= ? AND end_date >= ?";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= ' ORDER BY start_time ASC';
        $query = $this->db->query($sql, array($staff_code, $date, $date)); 
        $rule = $query->result_array();

        if($rule)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $rule);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array() );
    }

    public function save_staff($rule_id, $staff_code, $start_date, $end_date, $start_time, $is_enable, $user)
    {
        if(!$staff_code){
            return array('status' => 2, 'msg' => '部门错误', 'data' => array() );
        }
        if(!$start_date){
            return array('status' => 2, 'msg' => '开始日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $start_date)){
            return array('status' => 2, 'msg' => '开始日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$end_date){
            return array('status' => 2, 'msg' => '结束日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $end_date)){
            return array('status' => 2, 'msg' => '结束日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$start_time){
            return array('status' => 2, 'msg' => '上班时间错误', 'data' => array() );
        }
        if($rule_id == 0)
        {
            $data = array('staff_code' => $staff_code, 'start_date' => $start_date, 'end_date' => $end_date, 'start_time' => $start_time, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_staff_sche', $data);
        }else{
            $data = array('staff_code' => $staff_code, 'start_date' => $start_date, 'end_date' => $end_date, 'start_time' => $start_time, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $rule_id;
            $str = $this->db->update_string('s_staff_sche', $data, $where);
        }
        //入列操作
        if($start_date == $end_date){
            $queue_data = array('target' => 2, 'dept_id' => 0, 'staff_code' => $staff_code, 'date' => $start_date, 'is_enable' => 1, 'create_user' => $user);
            $queue_str = $this->db->insert_string('s_queue', $queue_data);
            $queue_query = $this->db->query($queue_str);            
        }else{
            $queue_data = array();            
            $period = new DatePeriod(
                new DateTime($start_date),
                new DateInterval('P1D'),
                new DateTime($end_date)
            );
            foreach ($period as $date){
                $queue_data[] = array(
                    'staff_code' => $staff_code, 
                    'target' => 2, 
                    'dept_id' => 0, 
                    'date' => $date->format('Y-m-d'), 
                    'is_enable' => 1, 
                    'create_user' => $user
                );
            }
            $queue_data[] = array(
                'staff_code' => $staff_code, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $end_date, 
                'is_enable' => 1, 
                'create_user' => $user
            );
            $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        }
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
    public function save_staff_all($staff_code, $start_date, $end_date, $start_time, $is_enable, $user)
    {
        if(!$staff_code){
            return array('status' => 2, 'msg' => '部门错误', 'data' => array() );
        }
        if(!$start_date){
            return array('status' => 2, 'msg' => '开始日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $start_date)){
            return array('status' => 2, 'msg' => '开始日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$end_date){
            return array('status' => 2, 'msg' => '结束日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $end_date)){
            return array('status' => 2, 'msg' => '结束日期格式错误，必须类似1999-01-01', 'data' => array() );            
        }
        if(!$start_time){
            return array('status' => 2, 'msg' => '上班时间错误', 'data' => array() );
        }
        $data = array();
        $queue_data = array();
        foreach ($staff_code as $key => $value) {
            $data[$key] = array(
                'staff_code' => $value, 
                'start_date' => $start_date, 
                'end_date' => $end_date,
                'start_time' => $start_time,
                'is_enable' => $is_enable, 
                'create_user' => $user
            );
            //入列数据
            $queue_data[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $start_date, 
                'is_enable' => 1, 
                'create_user' => $user
            );
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $str = $this->db->insert_batch('s_staff_sche', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }


    public function save_date_all($staff_code, $start_date, $start_time, $is_enable, $user)
    {
        if(!$staff_code){
            return array('status' => 2, 'msg' => '部门错误', 'data' => array() );
        }
        if(!$start_date){
            return array('status' => 2, 'msg' => '开始日期错误', 'data' => array() );
        }
        if(!$start_time){
            return array('status' => 2, 'msg' => '上班时间错误', 'data' => array() );
        }
        $data = array();
        $queue_data = array();
        foreach ($start_date as $key => $value) {
            $data[$key] = array(
                'staff_code' => $staff_code, 
                'start_date' => $value, 
                'end_date' => $value,
                'start_time' => $start_time,
                'is_enable' => $is_enable, 
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
        $str = $this->db->insert_batch('s_staff_sche', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

}