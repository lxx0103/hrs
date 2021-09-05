<?php

class Holiday_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_holiday($filters, $orderby = 'id')
    {
        $sql = "SELECT * FROM s_holiday WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM s_holiday WHERE 1";
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
            $sql .= ' AND holiday >= ?';
            $count_sql .= ' AND holiday >= ?';
            array_push($where, $filters['month']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND holiday < ?';
            $count_sql .= ' AND holiday < ?';
            $end_of_the_month = date('Y-m-d', strtotime($filters['month'] . ' +1 month'));
            array_push($where, $end_of_the_month);
        }
        if(isset($filters['is_enable']) && in_array($filters['is_enable'], array(0,1)))
        {
            $sql .= ' AND is_enable = ?';
            $count_sql .= ' AND is_enable = ?';
            array_push($where, $filters['is_enable']);
        }
        $sql .= ' ORDER BY '. $orderby .' ASC';
        $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $holidays = $query->result_array();
        $count = $count_query->row_array();
        if($holidays)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $holidays, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_all_holiday_by_month($month, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_holiday WHERE ((holiday >= ? AND holiday <= ? ) OR (holiday <= ? AND holiday_end > ?))";
        $month_start = $month . '-01';
        $month_end = $month . '-31';
        $where = array($month_start, $month_end, $month_start, $month_start);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $holidays = $query->result_array();
        if($holidays)
        {
            $day_result = array();
            foreach ($holidays as $row) {
                $days = (strtotime($row['holiday_end']) - strtotime($row['holiday']))/60/60/24 + 1;
                for ($i=0; $i < $days; $i++) { 
                    $the_date = date('Y-m-d', strtotime($row['holiday'])+24*60*60*$i );
                    $new_row = $row;
                    $new_row['holiday'] = $the_date;
                    $new_row['holiday_end'] = $the_date;
                    array_push($day_result, $new_row);
                }
            }
            return array('status' => 1, 'msg' => '成功', 'data' => $day_result,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }


    public function get_all_holiday_by_date2($start_date, $end_date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_holiday WHERE ((holiday >= ? AND holiday <= ? ) OR (holiday <= ? AND holiday_end > ?))";
        $where = array($start_date, $end_date, $start_date, $start_date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $holidays = $query->result_array();
        if($holidays)
        {
            $day_result = array();
            foreach ($holidays as $row) {
                $days = (strtotime($row['holiday_end']) - strtotime($row['holiday']))/60/60/24 + 1;
                for ($i=0; $i < $days; $i++) { 
                    $the_date = date('Y-m-d', strtotime($row['holiday'])+24*60*60*$i );
                    $new_row = $row;
                    $new_row['holiday'] = $the_date;
                    $new_row['holiday_end'] = $the_date;
                    array_push($day_result, $new_row);
                }
            }
            return array('status' => 1, 'msg' => '成功', 'data' => $day_result,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function get_one_holiday($holiday_id, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_holiday WHERE id = ? ";
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $sql .= " LIMIT 1";
        $query = $this->db->query($sql, array($holiday_id)); 
        $holiday = $query->row_array();
        if($holiday)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $holiday);
        }
        return array('status' => 2, 'msg' => '用户不存在', 'data' => array() );
    }

    public function save($holiday_id, $target, $dept_id, $staff_code, $holiday, $holiday_end, $hours, $type, $is_enable, $user)
    {
        if(!in_array($target, array(1,2,3)))
        {
            return array('status' => 2, 'msg' => '请选择放假对象', 'data' => array() );
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
        if(!$holiday)
        {
            return array('status' => 2, 'msg' => '请选择假期开始日期', 'data' => array() );
        }
        if(!$holiday_end)
        {
            return array('status' => 2, 'msg' => '请选择假期结束日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择假期时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        if($holiday_id == 0)
        {
            $data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'holiday' => $holiday, 'holiday_end' => $holiday_end, 'hours' => $hours, 'type' => $type, 'is_enable' => $is_enable, 'create_user' => $user, 'update_user' => $user);
            $str = $this->db->insert_string('s_holiday', $data);
        }else{
            $data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'holiday' => $holiday, 'holiday_end' => $holiday_end,  'hours' => $hours, 'type' => $type, 'is_enable' => $is_enable, 'update_user' => $user);
            $where = "id = ". $holiday_id;
            $str = $this->db->update_string('s_holiday', $data, $where);
        }
        //入列操作
        $queue_data = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'date' => $holiday, 'is_enable' => 1, 'create_user' => $user);
        $queue_str = $this->db->insert_string('s_queue', $queue_data);
        $queue_query = $this->db->query($queue_str);
        $queue_data1 = array('target' => $target, 'dept_id' => $dept_id, 'staff_code' => $staff_code, 'date' => $holiday_end, 'is_enable' => 1, 'create_user' => $user);
        $queue_str1 = $this->db->insert_string('s_queue', $queue_data1);
        $queue_query1 = $this->db->query($queue_str1);
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function get_all_holiday_by_date($date, $is_enable = 1)
    {
        $sql = "SELECT * FROM s_holiday WHERE holiday <= ? ANd holiday_end >= ? ";
        $where = array($date, $date);
        if($is_enable == 1)
        {
            $sql .= ' AND is_enable = 1';
        }
        $query = $this->db->query($sql, $where); 
        $holidays = $query->result_array();
        if($holidays)
        {
            $day_result = array();
            foreach ($holidays as $row) {
                $new_row = $row;
                $new_row['holiday_end'] = $row['holiday'];
                array_push($day_result, $new_row);
            }
            return array('status' => 1, 'msg' => '成功', 'data' => $day_result,);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function save_all_staff($staff_code, $holiday, $holiday_end, $hours, $type, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$holiday)
        {
            return array('status' => 2, 'msg' => '请选择假期日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择假期时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        $data = array();
        $queue_data = array();
        $queue_data2 = array();
        foreach ($staff_code as $key => $value) {
            $data[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'holiday' => $holiday, 
                'holiday_end' => $holiday_end, 
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
                'date' => $holiday, 
                'is_enable' => 1, 
                'create_user' => $user
            );
            $queue_data2[$key] = array(
                'staff_code' => $value, 
                'target' => 2, 
                'dept_id' => 0, 
                'date' => $holiday, 
                'is_enable' => 1, 
                'create_user' => $user
            );
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $queue_str2 = $this->db->insert_batch('s_queue', $queue_data2);
        $str = $this->db->insert_batch('s_holiday', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }


    public function save_all_date($staff_code, $holiday, $hours, $type, $is_enable, $user)
    {
        if(!$staff_code)
        {
            return array('status' => 2, 'msg' => '请输入工号', 'data' => array() );            
        }
        if(!$holiday)
        {
            return array('status' => 2, 'msg' => '请选择休假日期', 'data' => array() );
        }
        if(!$hours)
        {
            return array('status' => 2, 'msg' => '请选择休假时长', 'data' => array() );
        }
        if(!$type)
        {
            return array('status' => 2, 'msg' => '请选择类型', 'data' => array() );            
        }
        $data = array();
        foreach ($holiday as $key => $value) {
            $data[$key] = array(
                'staff_code' => $staff_code, 
                'target' => 2, 
                'dept_id' => 0, 
                'holiday' => $value, 
                'holiday_end' => $value, 
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
        $str = $this->db->insert_batch('s_holiday', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }
}