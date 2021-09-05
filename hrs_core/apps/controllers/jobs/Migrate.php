<?php
class Migrate extends CI_Controller {

    public function message()
    {
        $access_db = new PDO("odbc:driver={Microsoft Access Driver (*.mdb)};dbq=".realpath("E:\ZKTime5.0\att2000.mdb")) or die("Connect Error");
        $staff_info_rs = $access_db->query("SELECT * FROM USERINFO");
        $staff_data = $staff_info_rs->fetchAll();
        foreach ($staff_data as $row) {
            $sql = "SELECT * FROM s_staff_machine WHERE machine_id = ? AND machine_code = ? AND is_enable = 1";
            $query = $this->db->query($sql, array($row['USERID'], $row['Badgenumber']));
            $is_exist = $query->row_array();
            if(!$is_exist){
                $update_data = array('is_enable' => 0, 'update_user' => 'SYSTEM');
                $where = "machine_code = '".  $row['Badgenumber'] ."'" ;
                $update_str = $this->db->update_string('s_staff_machine', $update_data, $where);
                $update_query = $this->db->query($update_str);

                $insert_data = array('machine_id' => $row['USERID'], 'machine_code' => $row['Badgenumber'], 'is_enable' => 1, 'create_user' => 'SYSTEM', 'update_user' => 'SYSTEM');
                $insert_str = $this->db->insert_string('s_staff_machine', $insert_data);
                $insert_query = $this->db->query($insert_str);
            }

            $update_staff = array('machine_id' => $row['USERID'], 'update_user' => 'SYSTEM');
            $where_staff = "staff_code = '".  $row['Badgenumber'] ."'";
            $update_staff_str = $this->db->update_string('s_staff', $update_staff, $where_staff);
            $query_staff = $this->db->query($update_staff_str);
        }
        $rs = $access_db->query('select * from CHECKINOUT');
        $check_data = $rs->fetchAll();
        foreach ($check_data as $check_row) {
            $check_inster = array('machine_id' => $check_row['USERID'], 'check_date' => date('Y-m-d', strtotime($check_row['CHECKTIME'])), 'check_time' => $check_row['CHECKTIME'], 'create_user' => 'MIGRATE');
            $check_exist_sql = "SELECT * FROM u_check_in_out WHERE machine_id = ? AND check_time > ? AND check_time <= ?";
            $check_exist_query = $this->db->query($check_exist_sql, array($check_row['USERID'], date('Y-m-d H:i:s', strtotime($check_row['CHECKTIME'] . ' -2 mins')), $check_row['CHECKTIME']));            
            $check_exist = $check_exist_query->row_array();
            if($check_exist){
                continue;
            }
            //入列操作
            $queue_data = array('target' => 4, 'dept_id' => 0, 'staff_code' => $check_row['USERID'], 'date' => date('Y-m-d', strtotime($check_row['CHECKTIME'])), 'is_enable' => 1, 'create_user' => 'migrate');
            $queue_str = $this->db->insert_string('s_queue', $queue_data);
            $queue_query = $this->db->query($queue_str);
            //入列結束
            $check_str = $this->db->insert_string('u_check_in_out', $check_inster);
            $check_query = $this->db->query($check_str);
        }
        $access_db->query("Delete FROM CHECKINOUT");

    }
}