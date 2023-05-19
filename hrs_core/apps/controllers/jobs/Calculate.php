<?php

class Calculate extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('checkin/Attendence_m');
        $this->load->model('organization/Department_m');
        $this->load->model('organization/Staff_m');
        $this->load->model('checkin/Setsche_m');
        $this->load->model('checkin/Holiday_m');
        $this->load->model('checkin/Addition_m');
        $this->load->model('checkin/Duty_m');
    }

    public function index()
    {
        set_time_limit(0);
        $this->get_queue();
        echo 'queue success<br/> ';
        $this->do_calc();
        // echo 'calc success<br/> ';
    }

    private function get_queue()
    {
        $queue_sql = "SELECT * FROM s_queue WHERE is_enable = 1 order by id asc limit 500";
        $queue_query = $this->db->query($queue_sql);
        $queue_result = $queue_query->result_array();
        if(count($queue_result) > 0){
            foreach ($queue_result as $row) {
                if($row['target'] == 1){
                    $sql = 'SELECT * FROM s_staff where dept_id = '. $row['dept_id'];
                }elseif($row['target'] == 2){
                    $sql = 'SELECT * FROM s_staff WHERE staff_code = "' . $row['staff_code'] .'"';
                }elseif($row['target'] == 3){
                    $sql = 'SELECT * FROM s_staff WHERE 1';
                }elseif($row['target'] == 4){
                    $sql = 'SELECT * FROM s_staff WHERE machine_id = ' . $row['staff_code'];
                }
                $query = $this->db->query($sql);
                $result = $query->result_array();
                if(count($result) > 0){
                    foreach ($result as $staff) {
                        if(strtotime($staff['in_date']) > strtotime(date('Y-m-t', strtotime($row['date'])))){
                            // echo $staff['staff_code'].'-----'.$staff['in_date'].'<br/>';
                            continue;
                        }
                        if($staff['machine_id'] == 0){
                            continue;
                        }
                        if($staff['out_date'] == '1970-01-01' || strtotime($staff['out_date']) >= strtotime(substr($row['date'], 0, 7))){
                            $is_exist_query = $this->db->query("SELECT * FROM s_queue_staff WHERE staff_code = '". $staff['staff_code'] . "' AND month = '" . substr($row['date'], 0, 7) ."' AND is_enable =1");
                            $is_exist = $is_exist_query->row_array();
                            if($is_exist){
                                continue;
                            }
                            $data['staff_code'] = $staff['staff_code'];
                            $data['month'] = substr($row['date'], 0, 7);
                            $data['is_enable'] = 1;
                            $data['create_user'] = 'SYSTEM';
                            $str = $this->db->insert_string('s_queue_staff', $data);
                            $query = $this->db->query($str);
                        }
                    }
                }
                $this->db->query('UPDATE s_queue SET is_enable = 2 WHERE id = ' .$row['id'] );  
            }
        }
    }

    private function do_calc()
    {
        $sql = 'SELECT * FROM s_queue_staff WHERE is_enable = 1 order by id asc limit 20';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as $row) {            
            $staff_sql = "SELECT * FROM s_staff WHERE staff_code='".$row['staff_code']."' LIMIT 1";
            $staff_query = $this->db->query($staff_sql); 
            $staff = $staff_query->row_array();
            if($staff['machine_id'] == 0){
                $this->db->query('UPDATE s_queue_staff SET is_enable = 2 WHERE id = ' .$row['id'] ); 
                continue;
            }
            $calc_result = $this->calc_attendence($staff, $row['month']);
            foreach ($calc_result['data'] as $date => $attendence_data) {
                $checkin_ids = '';
                $checkin_times = '';
                foreach ($attendence_data['check_detail_array'] as $check_in_row) {
                    $checkin_ids .= $check_in_row['id'].',';
                    $checkin_times .= $check_in_row['check_time'].',';
                }
                $checkin_ids = trim($checkin_ids, ',');
                $checkin_times = trim($checkin_times, ',');
                $insert_data = array();
                $insert_data['month'] = $attendence_data['month'];
                $insert_data['date'] = $date;
                $insert_data['dept_id'] = $staff['dept_id'];
                $insert_data['department'] = $attendence_data['dept_name'];
                $insert_data['name'] = $staff['name'];
                $insert_data['staff_code'] = $staff['staff_code'];
                $insert_data['work_day'] = $attendence_data['work_day'];
                $insert_data['check_count'] = $attendence_data['check_count'];
                $insert_data['check_in_ids'] = $checkin_ids;
                $insert_data['check_in'] = $checkin_times;
                $insert_data['in_time'] = implode(',', $attendence_data['in_time']);
                $insert_data['legal_work_time'] = $attendence_data['legal_work_time'];
                $insert_data['work_time'] = $attendence_data['work_time'];
                $insert_data['over_time'] = $attendence_data['over_time'];
                $insert_data['off_time'] = $attendence_data['off_time'];
                $insert_data['leave_time'] = $attendence_data['leave_time'];
                $insert_data['holiday_time'] = $attendence_data['holiday_time'];
                $insert_data['error_time'] = $attendence_data['error_time'];
                $insert_data['late_time'] = $attendence_data['late_time'];
                $insert_result = $this->save_detail($insert_data, 'SYSTEM');
            }
            $insert_sum = array();
            $insert_sum['month'] = $calc_result['sum']['month'];
            $insert_sum['dept_id'] = $staff['dept_id'];
            $insert_sum['department'] = $calc_result['sum']['dept_name'];
            $insert_sum['name'] = $staff['name'];
            $insert_sum['staff_code'] = $staff['staff_code'];
            $insert_sum['work_day'] = $calc_result['sum']['work_day'];
            $insert_sum['check_count'] = $calc_result['sum']['check_count'];
            $insert_sum['legal_work_time'] = $calc_result['sum']['legal_work_time'];
            $insert_sum['work_time'] = $calc_result['sum']['work_time'];
            $insert_sum['over_time'] = $calc_result['sum']['over_time'];
            $insert_sum['off_time'] = $calc_result['sum']['off_time'];
            $insert_sum['leave_time'] = $calc_result['sum']['leave_time'];
            $insert_sum['holiday_time'] = $calc_result['sum']['holiday_time'];
            $insert_sum['error_time'] = $calc_result['sum']['error_time'];
            $insert_sum['late_time'] = $calc_result['sum']['late_time'];
            $insert_sum['first_late'] = $calc_result['sum']['first_late'];
            $insert_sum['second_late'] = $calc_result['sum']['second_late'];
            $insert_sum['other_late'] = $calc_result['sum']['other_late'];
            $insert_sum_result = $this->save_summary($insert_sum, 'SYSTEM');  
            $this->db->query('UPDATE s_queue_staff SET is_enable = 2 WHERE id = ' .$row['id'] );  
            echo $row['staff_code'].':'.$row['month'].'<br/>';
        }
    }

    public function calc_attendence($staff, $month)
    {   
        echo $staff['staff_code'];
        //获取部门信息
        $department = $this->Department_m->get_one_dept($staff['dept_id'], 0);
        $staff['dept_name'] = $department['data']['dept_name'];
        //获取假日信息
        $holiday = $this->Holiday_m->get_all_holiday_by_month($month);
        $holiday_array = array();
        foreach ($holiday['data'] as $holiday_row) 
        {
            $holiday_array[$holiday_row['holiday']][] = $holiday_row;
        }
        //获取值班信息
        $duty = $this->Duty_m->get_all_duty_by_month($month);
        $duty_array = array();
        foreach ($duty['data'] as $duty_row) 
        {
            $duty_array[$duty_row['duty']][] = $duty_row;
        }
        //获取连班信息
        $addition = $this->Addition_m->get_all_addition_by_month($month);
        $addition_array = array();
        foreach ($addition['data'] as $addition_row) 
        {
            $addition_array[$addition_row['addition']][] = $addition_row;
        }
        //获取考勤信息
        $attendence_filter = array();
        $attendence_filter['machine_id'] = $staff['machine_id'];
        $attendence_filter['start_time'] = date('Y-m-d H:i:s', strtotime($month));;
        $attendence_filter['end_time'] = date('Y-m-d H:i:s', strtotime($month . "+ 1 month"));
        $staff_attendence = $this->Attendence_m->get_all_attendence($attendence_filter);
        //构建月数组
        $day = date('t', strtotime($month));
        $attendence_array = array();
        $attendence_array_detail = array();
        for ($i=0; $i < $day; $i++) { 
            $now_day = date('Y-m-d', strtotime($month. "+ $i days"));
            $attendence_array[$now_day] = array();
            $attendence_array_detail[$now_day] = array();
        }
        foreach ($staff_attendence['data'] as $row) {
            $check_time = $row['check_time'];
            $check_day = $row['check_date'];
            $attendence_array[$check_day][] = date('Y-m-d H:i:s', strtotime($check_time)- strtotime($check_time)%60);
            $attendence_array_detail[$check_day][] = array('id'=>$row['id'], 'check_time'=>date('Y-m-d H:i:s', strtotime($check_time)- strtotime($check_time)%60));
        }
        $attendence_result = array();
        $sum = array();
        $sum['legal_work_time'] = 0;
        $sum['work_time'] = 0;
        $sum['over_time'] = 0;
        $sum['holiday_time'] = 0;
        $sum['leave_time'] = 0;
        $sum['error_time'] = 0;
        $sum['off_time'] = 0;
        $sum['late_time'] = 0;
        $sum['late_count'] = 0;
        $sum['first_late'] = 0;
        $sum['second_late'] = 0;
        $sum['other_late'] = 0;
        $sum['work_day'] = 0;
        $sum['check_count'] = 0;
        $sum['month'] = $month;
        $sum['dept_name'] = $staff['dept_name'];
        foreach ($attendence_array as $key => $value) {
            $day_sum = array();
            $day_sum['check_detail'] = $value;
            $day_sum['check_detail_array'] = $attendence_array_detail[$key];
            if(count($value)%2 != 0){
                unset($value[count($value)-1]);
            }
            $in_time_array = array();
            $out_time_array = array();
            $staff_sche = $this->Setsche_m->get_rule_by_staff_code($staff['staff_code'], $key);
            if($staff_sche['status'] != 1)
            {
                $dept_sche = $this->Setsche_m->get_rule_by_dept_id($staff['dept_id'], $key);
                if($dept_sche['status'] != 1)
                {
                    $in_time_array[] = '08:30:00';
                }else
                {                        
                    foreach ($dept_sche['data'] as $dept_sche_row) {
                        $in_time_array[] = $dept_sche_row['start_time'];
                    }
                }
            }else{
                foreach ($staff_sche['data'] as $staff_sche_row) {
                    $in_time_array[] = $staff_sche_row['start_time'];
                }
            }
            $day_sum['in_time'] = $in_time_array;
            $legal_work_time = 480;
            $max_work_time = 480;
            $work_time = 0;
            $late_time = 0;
            $over_time = 0;
            for ($i=0; $i < count($value)-1; $i+=2) {
                if(count($in_time_array) >= $i/2+1)
                {
                    $in_time = $in_time_array[$i/2];
                }else
                {
                    $in_time = $in_time_array[count($in_time_array) - 1];
                }
                if(strtotime($value[$i]) < strtotime($key . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $value[$i] = $key . ' ' . $in_time;
                }
                if(strtotime($value[$i+1]) < strtotime($key . ' ' . $in_time))//早于上班时间则默认为上班时间
                {
                    $value[$i+1] = $key . ' ' . $in_time;
                }
                if(strtotime($value[$i]) >= strtotime($key . ' ' . $department['data']['noon_break_start']) && strtotime($value[$i]) < strtotime($key . ' ' . $department['data']['noon_break_end']))
                {
                    $value[$i] = $key . ' ' . $department['data']['noon_break_end'] ;
                }
                if(strtotime($value[$i+1]) >= strtotime($key . ' ' . $department['data']['noon_break_start']) && strtotime($value[$i+1]) < strtotime($key . ' ' . $department['data']['noon_break_end']))
                {
                    $value[$i+1] = $key . ' ' . $department['data']['noon_break_end'] ;
                }
                if(count($in_time_array) >= $i/2+1 && strtotime($value[$i]) > strtotime($key . ' ' . $in_time))//迟到时间
                {
                    $late_time += (strtotime(substr($value[$i], 0, -3)) - strtotime($key . ' ' . $in_time))/60;
                    $value[$i] = $key . ' ' . $in_time;
                }
                if (strtotime($value[$i])%1800 != 0 ) {
                    $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) + (1800 - strtotime($value[$i])%1800)));
                }
                $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) - strtotime($value[$i+1])%1800));
                // if(strtotime($value[$i]) % 1800 >= 900)
                // {
                //     $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) + (1800 - strtotime($value[$i])%1800)));
                // }
                // else
                // {
                //     $value[$i] = date('Y-m-d H:i:s', (strtotime($value[$i]) - strtotime($value[$i])%1800));
                // }
                // if(strtotime($value[$i+1]) % 1800 >= 900)
                // {
                //     $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) + (1800 - strtotime($value[$i+1])%1800)));
                // }
                // else
                // {
                //     $value[$i+1] = date('Y-m-d H:i:s', (strtotime($value[$i+1]) - strtotime($value[$i+1])%1800));
                // }
                if(strtotime($value[$i]) < strtotime($key . ' ' . $department['data']['noon_break_start']))//如果上班卡早于12点
                {
                    if(strtotime($value[$i+1]) > strtotime($key . ' ' . $department['data']['noon_break_start']))//如果下班卡晚于12点
                    {
                        $work_time += (strtotime($key . ' ' . $department['data']['noon_break_start']) - strtotime($value[$i]))/60;//早上做满了
                        if(strtotime($value[$i+1]) > strtotime($key . ' ' . $department['data']['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += (strtotime($key . ' ' . $department['data']['night_break_start']) - strtotime($key . ' ' . $department['data']['noon_break_end']))/60;
                            if(strtotime($value[$i+1]) > strtotime($key . ' ' . $department['data']['night_break_end']))//如果下班卡晚于18:00
                            {
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_start'])+86400)){
                                    $over_time += 1080;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_end'])+86400)){
                                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_start'])+86400)){
                                            $over_time += 280;
                                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_end'])+86400)){
                                                $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['night_break_end']) - 86400)/60;
                                            }
                                        }else{
                                           $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['noon_break_end']) - 86400)/60; 
                                        }
                                    }
                                }else{
                                    $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['night_break_end']))/60;//加班了
                                }
                            }
                        }else
                        {
                            $work_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['noon_break_end']))/60;
                        }                    
                    }else//早上打卡下班了
                    {
                        $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60;
                    }
                }else
                {
                    if(strtotime($value[$i]) < strtotime($key . ' ' . $department['data']['night_break_start']))
                    {
                        if(strtotime($value[$i+1]) > strtotime($key . ' ' . $department['data']['night_break_start']))//如果下班卡晚于17:30
                        {
                            $work_time += (strtotime($key . ' ' . $department['data']['night_break_start']) - strtotime($value[$i]))/60;//下午做满了
                            if(strtotime($value[$i+1]) > strtotime($key . ' ' . $department['data']['night_break_end']))//如果下班卡晚于18:00
                            {
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_start'])+86400)){
                                    $over_time += 1080;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_end'])+86400)){
                                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_start'])+86400)){
                                            $over_time += 280;
                                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_end'])+86400)){
                                                $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['night_break_end']) - 86400)/60;
                                            }
                                        }else{
                                           $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['noon_break_end']) - 86400)/60; 
                                        }
                                    }
                                }else{
                                    $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['night_break_end']))/60;//加班了
                                }
                            }
                        }else
                        {
                           $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60; 
                        }
                    }else
                    {   
                        if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_start'])+86400)){
                            $over_time += (strtotime($key . ' ' . $department['data']['noon_break_start'])+86400 - strtotime($value[$i]))/60;
                            if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['noon_break_end'])+86400)){
                                if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_start'])+86400)){
                                    $over_time += 280;
                                    if(strtotime($value[$i+1]) > (strtotime($key . ' ' . $department['data']['night_break_end'])+86400)){
                                        $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['night_break_end']) - 86400)/60;
                                    }
                                }else{
                                   $over_time += (strtotime($value[$i+1]) - strtotime($key . ' ' . $department['data']['noon_break_end']) - 86400)/60; 
                                }
                            }
                        }else{
                            $work_time += (strtotime($value[$i+1]) - strtotime($value[$i]))/60;
                        }
                    }
                }
            }
            $holiday_time = 0;
            $leave_time = 0;
            $error_time = 0;
            if(isset($holiday_array[$key]))
            {
                foreach ($holiday_array[$key] as $holiday_key => $holiday_value) 
                {
                    if($holiday_value['target'] == 3 || ($holiday_value['target'] == 1 && $holiday_value['dept_id'] == $staff['dept_id']) || ($holiday_value['target'] == 2 && $holiday_value['staff_code'] == $staff['staff_code']))
                    {
                        if($holiday_value['type'] == 1){
                            $holiday_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }else if($holiday_value['type'] == 4){
                            $error_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }else{
                            $leave_time += $holiday_value['hours'];
                            $max_work_time = $max_work_time - $holiday_value['hours']*60;
                        }
                    }
                }
            }
            if(isset($duty_array[$key]))
            {
                foreach ($duty_array[$key] as $duty_key => $duty_value) 
                {
                    if($duty_value['staff_code'] == $staff['staff_code'])
                    {
                        $holiday_time = 0;
                        $max_work_time = 480;
                    }
                }
            }
            if(isset($addition_array[$key]))
            {
                foreach ($addition_array[$key] as $addition_key => $addition_value) 
                {
                    if(($addition_value['target'] == 1 && $addition_value['dept_id'] == $staff['dept_id']) || ($addition_value['target'] == 2 && $addition_value['staff_code'] == $staff['staff_code']))
                    {
                        $work_time += intval($addition_value['hours']*60);
                    }
                }
            }
            if($department['data']['has_overtime'] == 0)
            {
                // var_dump($over_time);
                // $over_time = 0;
            }
            if($work_time < $max_work_time){
                if($work_time + $over_time <= $max_work_time)
                {
                    $work_time = $over_time + $work_time;
                    $over_time = 0;
                }else
                {
                    $over_time = $over_time + $work_time - $max_work_time;
                    $work_time = $max_work_time;
                }
            }
            if($work_time > $max_work_time)
            {
                $over_time = $over_time + $work_time - $max_work_time;
                $work_time = $max_work_time;
            }
            if($department['data']['has_overtime'] == 0)
            {
                $over_time = 0;
                if($work_time > 0)
                {
                    $work_time = $max_work_time;
                }
            }
            if($work_time >0 || $over_time > 0 && $holiday_time != 8)
            {
                $day_sum['work_day'] = ($legal_work_time - $holiday_time * 60 - $leave_time * 60)/($legal_work_time - $holiday_time * 60);
            }else
            {
                $day_sum['work_day'] = 0;
            }

            if($staff['out_date'] != '1970-01-01' && strtotime($staff['out_date']) <= strtotime($key)){
                $holiday_time = ($legal_work_time - $work_time - intval($leave_time*60) - intval($holiday_time*60))/60;
            }
            if(strtotime($staff['in_date']) > strtotime($key)){
                $holiday_time = ($legal_work_time - $work_time - intval($leave_time*60) - intval($holiday_time*60))/60;
            }
            $day_sum['legal_work_time'] = $legal_work_time/60 - $holiday_time;
            $day_sum['work_time'] = $work_time/60;
            $day_sum['over_time'] = $over_time/60;
            $day_sum['leave_time'] = $leave_time;
            $day_sum['error_time'] = $error_time;
            $day_sum['holiday_time'] = $holiday_time;
            $day_sum['off_time'] = ($legal_work_time - $work_time - intval($leave_time*60) - intval($holiday_time*60))/60;
            $day_sum['late_time'] = $late_time;
            $day_sum['check_count'] = count($value);
            $day_sum['month'] = $month;
            $day_sum['dept_name'] = $staff['dept_name'];

            $sum['legal_work_time'] += $day_sum['legal_work_time'];
            $sum['work_time'] += $day_sum['work_time'];
            $sum['over_time'] += $day_sum['over_time'];
            $sum['leave_time'] += $day_sum['leave_time'];
            $sum['holiday_time'] += $day_sum['holiday_time'];
            $sum['off_time'] += $day_sum['off_time'];
            $sum['late_time'] += $day_sum['late_time'];
            if($day_sum['late_time'] > 0 ){
                if($sum['late_count'] == 0){
                    if($day_sum['late_time'] <= 5){
                        $sum['first_late'] += $day_sum['late_time'];
                    }else{
                        $sum['first_late'] = 5;
                        $sum['second_late'] += $day_sum['late_time'] - 5;
                    }
                }else if($sum['late_count'] < 4) {
                    $sum['second_late'] += $day_sum['late_time'];
                }else {
                    $sum['other_late'] += $day_sum['late_time'];
                }
                $sum['late_count'] += 1;
            }
            $sum['error_time'] += $day_sum['error_time'];
            $sum['check_count'] += $day_sum['check_count'];
            $sum['work_day'] += $day_sum['work_day'];
            $attendence_result[$key] = $day_sum;
        }
        if($sum['work_time'] < $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time']) {
            if($sum['work_time'] + $sum['over_time'] >= $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time']){
                $sum['over_time'] = $sum['work_time'] + $sum['over_time'] - $sum['legal_work_time'] + $sum['leave_time'] + $sum['error_time'];
                $sum['work_time'] = $sum['legal_work_time'] - $sum['leave_time'] - $sum['error_time'];
                $sum['off_time'] = $sum['error_time'] + $sum['leave_time'];
            }else{
                $sum['work_time'] = $sum['work_time'] + $sum['over_time'];
                $sum['off_time'] = $sum['off_time'] - $sum['over_time'];
                $sum['over_time'] = 0;
            }
        }
        return array('sum' => $sum, 'data' => $attendence_result, 'staff' => $staff);
    }


    public function save_summary($data, $user)
    {
        $is_exist_query = $this->db->query("DELETE FROM u_month_summary WHERE staff_code = '". $data['staff_code'] . "' AND month = '" . $data['month'] ."'");
        $data['create_user'] = $user;
        $str = $this->db->insert_string('u_month_summary', $data);
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功');
    }
    public function save_detail($data, $user)
    {
        $is_exist_query = $this->db->query("DELETE FROM u_month_detail WHERE staff_code = '". $data['staff_code'] . "' AND date = '" . $data['date'] ."'");
        $data['create_user'] = $user;
        $str = $this->db->insert_string('u_month_detail', $data);
        $query = $this->db->query($str);
        return array('status' => 1, 'msg' => '成功');
    }
}