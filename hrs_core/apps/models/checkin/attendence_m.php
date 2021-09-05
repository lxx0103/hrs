<?php

class Attendence_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_attendence($filters)
    {
        $sql = "SELECT * FROM u_check_in_out WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM u_check_in_out WHERE 1";
        $where = array();
        if(isset($filters['machine_id']) && $filters['machine_id'])
        {
            $sql .= ' AND machine_id = ?';
            $count_sql .= ' AND machine_id = ?';
            array_push($where, $filters['machine_id']);
        }
        if(isset($filters['start_time']) && $filters['start_time'])
        {
            $sql .= ' AND check_date >= ?';
            $count_sql .= ' AND check_date >= ?';
            array_push($where, $filters['start_time']);
        }
        if(isset($filters['end_time']) && $filters['end_time'])
        {
            $sql .= ' AND check_date < ?';
            $count_sql .= ' AND check_date < ?';
            array_push($where, $filters['end_time']);
        }
        $sql .= ' ORDER BY machine_id ASC, check_time ASC';
        if(isset($filters['page']) && isset($filters['page_size']))
        {
            $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        }
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $menus = $query->result_array();
        $count = $count_query->row_array();
        if($menus)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $menus, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }


    public function save($machine_id, $check_date, $check_time, $user, $check_type = 0)
    {
        if(!$machine_id)
        {
            return array('status' => 2, 'msg' => '用户错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $check_date))
        {
            return array('status' => 2, 'msg' => '日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d:\d\d$/', $check_time))
        {
            return array('status' => 2, 'msg' => '时间错误', 'data' => array() );            
        }
        $data = array('machine_id' => $machine_id, 'check_date' => $check_date, 'check_time' => $check_date .' '.$check_time, 'create_user' => $user);    
        //入列数据
        $queue_data = array('target' => 4, 'dept_id' => 0, 'staff_code' => $machine_id, 'date' => $check_date, 'is_enable' => 1, 'create_user' => $user);
        if($check_type == 1)
        {
            $data['check_date'] = date('Y-m-d', strtotime($data['check_date'])-86400);
            $queue_data['date'] = date('Y-m-d', strtotime($queue_data['date'])-86400);
        }
        $str = $this->db->insert_string('u_check_in_out', $data);        
        //入列操作
        $queue_str = $this->db->insert_string('s_queue', $queue_data);
        $queue_query = $this->db->query($queue_str);
        //入列結束
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function set_check_date($check_id, $type, $user)
    {
        $sql = "SELECT * FROM u_check_in_out WHERE id = ? LIMIT 1";
        $query = $this->db->query($sql, array($check_id));
        $result = $query->row_array();
        if($type == 2){
            $new_check_date = date('Y-m-d', strtotime($result['check_time'] . ' - 1 day'));
        }else{
            $new_check_date = date('Y-m-d', strtotime($result['check_time'] ));
        }
        $queue_data = array();
        $queue_data[] = array(
                'staff_code' => $result['machine_id'], 
                'target' => 4, 
                'dept_id' => 0, 
                'date' => date('Y-m-d', strtotime($result['check_time'])), 
                'is_enable' => 1, 
                'create_user' => $user
            );
        $queue_data[] = array(
                'staff_code' => $result['machine_id'], 
                'target' => 4, 
                'dept_id' => 0, 
                'date' => date('Y-m-d', strtotime($result['check_time'] . ' - 1 day')), 
                'is_enable' => 1, 
                'create_user' => $user
            );
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $update_sql = "UPDATE u_check_in_out SET check_date = ? WHERE id = ? LIMIT 1";
        $update_query = $this->db->query($update_sql, array($new_check_date, $check_id));
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function save_mul($machine_ids, $check_date, $check_time, $user, $check_type = 0)
    {
        if(!$machine_ids)
        {
            return array('status' => 2, 'msg' => '用户错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d\d\d-\d\d-\d\d$/', $check_date))
        {
            return array('status' => 2, 'msg' => '日期错误', 'data' => array() );
        }
        if(!preg_match('/^\d\d:\d\d$/', $check_time))
        {
            return array('status' => 2, 'msg' => '时间错误', 'data' => array() );            
        }
        $data = array();
        $queue_data = array();
        foreach ($machine_ids as $key => $value) {
            $data[$key] = array(
                'machine_id' => $value['machine_id'], 
                'check_date' => $check_date, 
                'check_time' => $check_date .' '.$check_time, 
                'create_user' => $user
            );
            //入列数据
            $queue_data[$key] = array(
                'staff_code' => $value['machine_id'], 
                'target' => 4, 
                'dept_id' => 0, 
                'date' => $check_date, 
                'is_enable' => 1, 
                'create_user' => $user
            );
            if($check_type == 1)
            {
                $data[$key]['check_date'] = date('Y-m-d', strtotime($data['check_date'])-86400);
                $queue_data[$key]['date'] = date('Y-m-d', strtotime($queue_data['date'])-86400);
            }
        }
        $queue_str = $this->db->insert_batch('s_queue', $queue_data);
        $str = $this->db->insert_batch('u_check_in_out', $data);
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function del_check_in($id, $user)
    {
        $sql = "SELECT * FROM u_check_in_out WHERE id = ? LIMIT 1";
        $query = $this->db->query($sql, array($id));
        $result = $query->row_array();
        if($result){
            //入列操作
            $queue_data = array('target' => 4, 'dept_id' => 0, 'staff_code' => $result['machine_id'], 'date' => $result['check_date'], 'is_enable' => 1, 'create_user' => $user);
            $queue_str = $this->db->insert_string('s_queue', $queue_data);
            $queue_query = $this->db->query($queue_str);
            //入列結束            
        }
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->delete('u_check_in_out');
        return array('status' => 1, 'msg' => '成功！', 'data' => $this->db->affected_rows());
    }

    public function get_all_attendence_by_machine_ids($filters)
    {
        $sql = "SELECT * FROM u_check_in_out WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM u_check_in_out WHERE 1";
        $where = array();
        if(isset($filters['machine_ids']) && $filters['machine_ids'])
        {
            $sql .= ' AND machine_id in ('.$filters['machine_ids'].')';
            $count_sql .= ' AND machine_id in ('.$filters['machine_ids'].')';
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND check_date >= ?';
            $count_sql .= ' AND check_date >= ?';
            array_push($where, $filters['month'].'-01');
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND check_date < ?';
            $count_sql .= ' AND check_date < ?';
            array_push($where, date('Y-m-d', strtotime($filters['month'].'-01' . ' +1 month')));
        }
        $sql .= ' ORDER BY machine_id ASC, check_date ASC, check_time ASC';
        if(isset($filters['page']) && isset($filters['page_size']))
        {
            $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        }
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $menus = $query->result_array();
        $count = $count_query->row_array();
        if($menus)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $menus, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function save_history($data, $user)
    {
        $is_exist_query = $this->db->query("SELECT * FROM u_history WHERE staff_code = '". $data['staff_code'] . "' AND month = '" . $data['month'] ."'");
        $is_exist = $is_exist_query->row_array();
        if($is_exist){
            return array('status' => 2, 'msg' => '已存在');
        }
        $data['create_user'] = $user;
        $str = $this->db->insert_string('u_history', $data);
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功');


    }

    public function save_history_detail($data, $user)
    {
        $is_exist_query = $this->db->query("SELECT * FROM u_history_detail WHERE staff_code = '". $data['staff_code'] . "' AND date = '" . $data['date'] ."'");
        $is_exist = $is_exist_query->row_array();
        if($is_exist){
            return array('status' => 2, 'msg' => '已存在');
        }
        $data['create_user'] = $user;
        $str = $this->db->insert_string('u_history_detail', $data);
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功');
    }

    public function get_all_history($filters)
    {
        $sql = "SELECT * FROM u_history WHERE 1";
        $count_sql = "SELECT COUNT(1) AS total FROM u_history WHERE 1";
        $where = array();
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['department']) && $filters['department'])
        {
            $sql .= ' AND department = ?';
            $count_sql .= ' AND department = ?';
            array_push($where, $filters['department']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND month = ?';
            $count_sql .= ' AND month = ?';
            array_push($where, $filters['month']);
        }
        $sql .= ' ORDER BY department ASC, staff_code ASC';
        if(isset($filters['page']) && isset($filters['page_size']))
        {
            $sql .= ' LIMIT ' . ($filters['page']-1) * $filters['page_size'] . ','. $filters['page_size'];
        }
        $query = $this->db->query($sql, $where); 
        $count_query = $this->db->query($count_sql, $where);
        $data = $query->result_array();
        $count = $count_query->row_array();
        if($data)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $data, 'total'=>$count['total']);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array(), 'total'=>$count['total']);
    }

    public function get_all_history_detail($staff_code, $month)
    {
        $sql = "SELECT * FROM u_history_detail WHERE 1";
        $where = array();
        $sql .= ' AND staff_code = ?';
        array_push($where, $staff_code);
        $sql .= ' AND month = ?';
        array_push($where, $month);
        $sql .= ' ORDER BY date ASC';
        $query = $this->db->query($sql, $where); 
        $data = $query->result_array();
        if($data)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $data);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

    public function get_all_depts()
    {
        $sql = "SELECT distinct(department) FROM u_history";
        $query = $this->db->query($sql); 
        $data = $query->result_array();
        if($data)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $data);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }
}