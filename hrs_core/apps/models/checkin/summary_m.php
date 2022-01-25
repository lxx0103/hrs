<?php

class Summary_m extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }


    public function get_all_summary($filters)
    {
        $sql = "SELECT '汇总' as month,dept_id, department, name, staff_code, sum(work_day) as work_day, sum(check_count) as check_count, sum(legal_work_time) as legal_work_time, sum(work_time) as work_time, sum(over_time) as over_time, sum(off_time) as off_time, sum(leave_time) as leave_time, sum(holiday_time) as holiday_time, sum(error_time) as error_time, sum(late_time) as late_time, sum(first_late) as first_late, sum(second_late) as second_late, sum(other_late) as other_late FROM u_month_summary WHERE 1";
        $count_sql = "SELECT count(distinct(staff_code)) AS total FROM u_month_summary WHERE 1";
        $where = array();
        if(isset($filters['staff_code']) && $filters['staff_code'])
        {
            $sql .= ' AND staff_code = ?';
            $count_sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['dept_id']) && $filters['dept_id'])
        {
            $sql .= ' AND dept_id = ?';
            $count_sql .= ' AND dept_id = ?';
            array_push($where, $filters['dept_id']);
        }
        if(isset($filters['month']) && $filters['month'])
        {
            $sql .= ' AND month >= ?';
            $count_sql .= ' AND month >= ?';
            array_push($where, $filters['month']);
        }
        if(isset($filters['month_to']) && $filters['month_to'])
        {
            $sql .= ' AND month <= ?';
            $count_sql .= ' AND month <= ?';
            array_push($where, $filters['month_to']);
        }
        $sql .= ' GROUP BY staff_code ';
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

    public function get_all_detail($filters)
    {
        $sql = "SELECT * FROM u_month_detail WHERE 1";
        $where = array();
        if(isset($filters['staff_code']) && $filters['staff_code']){
            $sql .= ' AND staff_code = ?';
            array_push($where, $filters['staff_code']);
        }
        if(isset($filters['dept_id']) && $filters['dept_id'])
        {
            $sql .= ' AND dept_id = ?';
            array_push($where, $filters['dept_id']);
        }
        $sql .= ' AND month >= ?';
        $sql .= ' AND month <= ?';
        array_push($where, $filters['month']);
        array_push($where, $filters['month_to']);
        $sql .= ' ORDER BY staff_code ASC, date ASC';
        $query = $this->db->query($sql, $where); 
        $data = $query->result_array();
        if($data)
        {
            return array('status' => 1, 'msg' => '成功', 'data' => $data);
        }
        return array('status' => 2, 'msg' => '不存在', 'data' => array());
    }

}