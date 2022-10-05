<?php

class Staff extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('organization/Staff_m');
        $this->load->model('organization/Department_m');
        $this->load->model('organization/Position_m');
    }

    public function index()
    {
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['name'] = trim($this->input->get('name'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['is_working'] = trim($this->input->get('is_working'));
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:20;
        $staff = $this->Staff_m->get_all_staff($filters, false);
        $this->data['total'] = $staff['total'];
        $this->data['filters'] = $filters;
        $this->data['staff'] = $staff['data'];
        $this->data['query_str'] = $query_str;
        $depts = $this->Department_m->get_all_dept(0);
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $positions = $this->Position_m->get_all_position();
        $sorted_positions = array();
        foreach ($positions['data'] as $row) 
        {
            $sorted_positions[$row['id']] = $row;
        }
        $this->data['positions'] = $positions['data'];
        $this->data['sorted_positions'] = $sorted_positions;
        $this->load->view('organization/staff_list_v', $this->data);
    }


    public function one()
    {
        $staff_id = trim($this->input->post('staff_id'));
        $staff = $this->Staff_m->get_staff_by_id($staff_id, false);
        echo json_encode($staff);
    }

    public function edit()
    {
        $staff_code = trim($this->input->get('staff_code'));
        if($staff_code){
            $this->data['act'] = 'edit';
            $staff = $this->Staff_m->get_staff_by_code($staff_code, false);
            $this->data['staff'] = $staff['data'];
        }else{
            $this->data['act'] = 'new';
        }
        $depts = $this->Department_m->get_all_dept();
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->data['depts'] = $depts['data'];
        $this->data['sorted_depts'] = $sorted_depts;
        $this->load->view('organization/staff_edit_v', $this->data);
    }

    public function savestaff()
    {
        $staff_data['staff_code'] = $this->input->post('staff_code');
        $staff_data['name'] = $this->input->post('name');
        $staff_data['zhiweizhuangtai'] = $this->input->post('zhiweizhuangtai');
        $staff_data['identification'] = $this->input->post('identification');
        $staff_data['mobile'] = $this->input->post('mobile');
        $staff_data['leibie'] = $this->input->post('leibie');
        $staff_data['linshigonggongjia'] = $this->input->post('linshigonggongjia');
        $staff_data['suoshugongsi'] = $this->input->post('suoshugongsi');
        $staff_data['goumaishebaodangci'] = $this->input->post('goumaishebaodangci');
        $staff_data['in_date'] = $this->input->post('in_date');
        $staff_data['shifouerciruzhi'] = $this->input->post('shifouerciruzhi');
        $staff_data['out_date'] = $this->input->post('out_date');
        $staff_data['shifouzili'] = $this->input->post('shifouzili');
        $staff_data['gongziyijiesuan'] = $this->input->post('gongziyijiesuan');
        $staff_data['dept_id'] = $this->input->post('dept_id');
        $staff_data['gangwei'] = $this->input->post('gangwei');
        $staff_data['legal_work_hour'] = $this->input->post('legal_work_hour');
        $staff_data['jiabanfeibiaozhun'] = $this->input->post('jiabanfeibiaozhun');
        $staff_data['shifouxuetu'] = $this->input->post('shifouxuetu');
        $staff_data['jieshaoren'] = $this->input->post('jieshaoren');
        $staff_data['xinzhibaodi'] = $this->input->post('xinzhibaodi');
        $staff_data['miankouhuoshifei'] = $this->input->post('miankouhuoshifei');
        $staff_data['marrige'] = $this->input->post('marrige');
        $staff_data['shifoudangyuan'] = $this->input->post('shifoudangyuan');
        $staff_data['shebaohao'] = $this->input->post('shebaohao');
        $staff_data['education'] = $this->input->post('education');
        $staff_data['hometown'] = $this->input->post('hometown');
        $staff_data['ethnicity'] = $this->input->post('ethnicity');
        $staff_data['shenfenzhengdizhi'] = $this->input->post('shenfenzhengdizhi');
        $staff_data['address'] = $this->input->post('address');
        $staff_data['room'] = $this->input->post('room');
        $staff_data['gongjuxianghao'] = $this->input->post('gongjuxianghao');
        $staff_data['daishouji'] = $this->input->post('daishouji');
        $staff_data['chouyan'] = $this->input->post('chouyan');
        $staff_data['shifouqiandinghetong'] = $this->input->post('shifouqiandinghetong');
        $staff_data['hetongbianhao'] = $this->input->post('hetongbianhao');
        $staff_data['contract_from'] = $this->input->post('contract_from');
        $staff_data['hetongqixian'] = $this->input->post('hetongqixian');
        $staff_data['zhuanzhengriqi'] = $this->input->post('zhuanzhengriqi');
        $staff_data['shiyongqigongzi'] = $this->input->post('shiyongqigongzi');
        $staff_data['zhuanzhenggongzi'] = $this->input->post('zhuanzhenggongzi');
        $staff_data['emergency'] = $this->input->post('emergency');
        $staff_data['emergency_phone'] = $this->input->post('emergency_phone');
        $staff_data['yinhangkahao'] = $this->input->post('yinhangkahao');
        $staff_data['kaihuhang'] = $this->input->post('kaihuhang');
        $staff_data['zhihang'] = $this->input->post('zhihang');
        $staff_data['id'] = $this->input->post('id');
        $error_message = '';
        if($staff_data['identification'] == ''){
            $error_message .= '缺少证件号,';
        }
        if($staff_data['staff_code'] == ''){
            $error_message .= '缺少工号,';
        }
        if($staff_data['name'] == ''){
            $error_message .= '缺少姓名,';
        }
        if($staff_data['dept_id'] == 0){
            $error_message .= '部门错误,';
        }
        $department = $this->Department_m->get_one_dept($staff_data['dept_id'], 0);
        if($department['status'] != 1){
            $error_message .= '部门错误';
        }
        $staff_data['xianbie'] = $department['data']['xianbie'];
        $staff_data['floor'] = $department['data']['floor'];
        $staff_data['rengongleibie'] = $department['data']['rengongleibie'];
        $staff_data['gongziguishufeiyong'] = $department['data']['gongziguishufeiyong'];
        if($error_message != ''){
            echo json_encode(array('status' => 2, 'msg' => $error_message));
            die();
        }
        $save = $this->Staff_m->save($staff_data, $this->session->username);
        echo json_encode($save);
    }


    public function uploadstaff()
    {
        $config['upload_path'] = 'E:\wamp\www\hrs\uploads';
        // $config['upload_path'] = '/Users/lewis/Project/hrs/hrs/uploads';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = 0;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['file_name'] = time();
        $this->load->library('upload', $config);
        if(!$this->upload->do_upload('staff_xls')){
            $error = array('error'=>$this->upload->display_errors());
            var_dump($error);
        }else{                
            $this->load->library('PHPExcel');
            $this->load->library('PHPExcel/IOFactory');
            $reader = new PHPExcel_Reader_Excel5();
            $PHPExcel = $reader->load('E:\wamp\www\hrs\uploads\\'.$config['file_name'].'.xls');
            // $PHPExcel = $reader->load('/Users/lewis/Project/hrs/hrs/uploads/'.$config['file_name'].'.xls');
            $currentSheet = $PHPExcel->getSheet(0);
            $allColumn = $currentSheet->getHighestColumn();
            $allRow = $currentSheet->getHighestRow();
            $all_error = '';
            for($currentRow=2; $currentRow <= $allRow; $currentRow ++)
            {
                $staff_data = array();
                $staff_data['name'] = $currentSheet->getCell('A'. $currentRow)->getValue();
                $staff_data['staff_code'] = $currentSheet->getCell('B'. $currentRow)->getValue();
                $staff_data['zhiweizhuangtai'] = $currentSheet->getCell('C'. $currentRow)->getValue();
                $staff_data['identification'] = $currentSheet->getCell('D'. $currentRow)->getValue();
                $staff_data['mobile'] = $currentSheet->getCell('E'. $currentRow)->getValue();
                $staff_data['leibie'] = $currentSheet->getCell('F'. $currentRow)->getValue();
                $staff_data['linshigonggongjia'] = $currentSheet->getCell('G'. $currentRow)->getValue();
                $staff_data['suoshugongsi'] = $currentSheet->getCell('H'. $currentRow)->getValue();
                $staff_data['goumaishebaodangci'] = $currentSheet->getCell('I'. $currentRow)->getValue();
                $staff_data['in_date'] = gmdate('Y-m-d', ($currentSheet->getCell('J'. $currentRow)->getValue()- 25569) * 24 * 60 * 60);
                $staff_data['shifouerciruzhi'] = $currentSheet->getCell('K'. $currentRow)->getValue();
                // $staff_data['out_date'] = gmdate('Y-m-d', ($currentSheet->getCell('L'. $currentRow)->getValue()- 25569) * 24 * 60 * 60);
                $staff_data['shifouzili'] = $currentSheet->getCell('M'. $currentRow)->getValue();
                $staff_data['gongziyijiesuan'] = $currentSheet->getCell('N'. $currentRow)->getValue();
                // $staff_data['xianbie'] = $currentSheet->getCell('O'. $currentRow)->getValue();
                $staff_data['dept_id'] = $currentSheet->getCell('P'. $currentRow)->getValue();
                $staff_data['gangwei'] = $currentSheet->getCell('Q'. $currentRow)->getValue();
                // $staff_data['floor'] = $currentSheet->getCell('R'. $currentRow)->getValue();
                // $staff_data['rengongleibie'] = $currentSheet->getCell('S'. $currentRow)->getValue();
                $staff_data['legal_work_hour'] = $currentSheet->getCell('T' . $currentRow)->getValue();
                $staff_data['jiabanfeibiaozhun'] = $currentSheet->getCell('U'. $currentRow)->getValue();
                $staff_data['shifouxuetu'] = $currentSheet->getCell('V'. $currentRow)->getValue();
                $staff_data['jieshaoren'] = $currentSheet->getCell('W'. $currentRow)->getValue();
                $staff_data['xinzhibaodi'] = $currentSheet->getCell('X'. $currentRow)->getValue();
                $staff_data['miankouhuoshifei'] = $currentSheet->getCell('Y'. $currentRow)->getValue();
                // $staff_data['gongziguishufeiyong'] = $currentSheet->getCell('Z'. $currentRow)->getValue();
                // $staff_data['birthday'] = gmdate('Y-m-d', ($currentSheet->getCell('AA'. $currentRow)->getValue()- 25569) * 24 * 60 * 60);
                $staff_data['marrige'] = $currentSheet->getCell('AB'. $currentRow)->getValue();
                // $staff_data['gender'] = $currentSheet->getCell('AC'. $currentRow)->getValue();
                $staff_data['shifoudangyuan'] = $currentSheet->getCell('AD'. $currentRow)->getValue();
                $staff_data['shebaohao'] = $currentSheet->getCell('AE'. $currentRow)->getValue();
                $staff_data['education'] = $currentSheet->getCell('AF'. $currentRow)->getValue();
                $staff_data['hometown'] = $currentSheet->getCell('AG'. $currentRow)->getValue();
                $staff_data['ethnicity'] = $currentSheet->getCell('AH'. $currentRow)->getValue();
                $staff_data['shenfenzhengdizhi'] = $currentSheet->getCell('AI'. $currentRow)->getValue();
                $staff_data['address'] = $currentSheet->getCell('AJ'. $currentRow)->getValue();
                $staff_data['room'] = $currentSheet->getCell('AK'. $currentRow)->getValue();
                $staff_data['gongjuxianghao'] = $currentSheet->getCell('AL'. $currentRow)->getValue();
                $staff_data['daishouji'] = $currentSheet->getCell('AM'. $currentRow)->getValue();
                $staff_data['chouyan'] = $currentSheet->getCell('AN'. $currentRow)->getValue();
                $staff_data['shifouqiandinghetong'] = $currentSheet->getCell('AO'. $currentRow)->getValue();
                $staff_data['hetongbianhao'] = $currentSheet->getCell('AP'. $currentRow)->getValue();
                $staff_data['contract_from'] = gmdate('Y-m-d', ($currentSheet->getCell('AQ'. $currentRow)->getValue()- 25569) * 24 * 60 * 60);
                $staff_data['hetongqixian'] = $currentSheet->getCell('AR'. $currentRow)->getValue();
                $staff_data['zhuanzhengriqi'] = $currentSheet->getCell('AS'. $currentRow)->getValue();
                $staff_data['shiyongqigongzi'] = $currentSheet->getCell('AT'. $currentRow)->getValue();
                $staff_data['zhuanzhenggongzi'] = $currentSheet->getCell('AU'. $currentRow)->getValue();
                $staff_data['emergency'] = $currentSheet->getCell('AV'. $currentRow)->getValue();
                $staff_data['emergency_phone'] = $currentSheet->getCell('AW'. $currentRow)->getValue();
                $staff_data['yinhangkahao'] = $currentSheet->getCell('AX'. $currentRow)->getValue();
                $staff_data['kaihuhang'] = $currentSheet->getCell('AY'. $currentRow)->getValue();
                $staff_data['zhihang'] = $currentSheet->getCell('AZ'. $currentRow)->getValue();
                $staff_data['is_enable'] = 1;
                foreach ($staff_data as $key => $value) {
                    if(is_null($value)){
                        $staff_data[$key] = '';
                    }
                }
                $error_message = '';
                if($staff_data['identification'] == ''){
                    $error_message .= '缺少身份证,';
                }else{                    
                    $staff_data['birthday'] = substr($staff_data['identification'], 6, 8);
                    $staff_data['gender'] = substr($staff_data['identification'], -2, 1)%2 == 1? 1:2;
                }
                if($staff_data['staff_code'] == ''){
                    $error_message .= '缺少工号,';
                }
                if($staff_data['name'] == ''){
                    $error_message .= '缺少姓名,';
                }
                if($staff_data['dept_id'] == ''){
                    $error_message .= '缺少部门,';
                }else{
                    $dept = $this->Department_m->get_one_dept_by_name($staff_data['dept_id']);
                    if($dept['status']!=1){
                        $error_message .= '部门不存在,';
                    }else{
                        $staff_data['dept_id'] = $dept['data']['id'];
                        $staff_data['xianbie'] = $dept['data']['xianbie'];
                        $staff_data['floor'] = $dept['data']['floor'];
                        $staff_data['rengongleibie'] = $dept['data']['rengongleibie'];
                        $staff_data['gongziguishufeiyong'] = $dept['data']['gongziguishufeiyong'];
                    }
                }
                if($error_message != '')
                {
                    $error_message .= '出错';
                    $all_error .= '第' . $currentRow . '行' . $error_message;
                }else{
                    // $staff_data['gender'] = $staff_data['gender'] == '男'?'1':'2';
                    $machine_id = $this->Staff_m->get_machine_id_rel($staff_data['staff_code']);
                    if($machine_id['status'] == 1){
                        $staff_data['machine_id'] = $machine_id['data']['machine_id'];
                    }
                    $is_exist = $this->Staff_m->get_all_staff(array('staff_code'=>$staff_data['staff_code'], 'page' => 1, 'page_size' => 1), false);
                    if($is_exist['status'] == 1){
                        $staff_data['id'] = $is_exist['data'][0]['id'];
                    }
                    $save = $this->Staff_m->save($staff_data, $this->session->username);
                }
            }
            var_dump($all_error);
        }
    }

    public function expstaff()
    {
        set_time_limit(0);
        $filters['dept_id'] = trim($this->input->get('dept_id'));
        $filters['name'] = trim($this->input->get('name'));
        $filters['staff_code'] = trim($this->input->get('staff_code'));
        $filters['is_working'] = trim($this->input->get('is_working'));
        $query_str = '?';
        foreach ($filters as $key => $value) 
        {
            if($value)
            {
                $query_str .= $key . '=' . $value . '&';
            }
        }
        $filters['page'] = $this->input->get('page')?$this->input->get('page'):1;
        $filters['page_size'] = isset($this->session->page_size)?$this->session->page_size:1000;
        $staff = $this->Staff_m->get_all_staff($filters, false);
        // print_r($staff);die();
        $depts = $this->Department_m->get_all_dept(0);
        $sorted_depts = array();
        foreach ($depts['data'] as $row) 
        {
            $sorted_depts[$row['id']] = $row;
        }
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        $objPHPExcel =  new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, '姓名');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '工号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 1, '职位状态');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, 1, '证件号码');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, 1, '手机号码');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, 1, '类别');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, 1, '临时工工价/时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, 1, '所属公司');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, 1, '购买社保档次');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, 1, '入职日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, 1, '是否二次入职');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, 1, '离职日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, 1, '是否自离');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, 1, '本期工资是否已结算');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, 1, '线别');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, 1, '部门名称');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, 1, '岗位');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, 1, '楼层');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, 1, '人工类别');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, 1, '应上班工时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, 1, '加班费标准');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, 1, '是否学徒');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(22, 1, '宿舍长补贴');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, 1, '介绍人');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, 1, '性质保底');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(25, 1, '是否免扣伙食费');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(26, 1, '核对学徒期是否满');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(27, 1, '介绍人奖励金额');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(28, 1, '保底工资');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29, 1, '工资归属费用');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(30, 1, '本期是否调换部门');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(31, 1, '新部门名称');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32, 1, '出生日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(33, 1, '生日月份');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(34, 1, '工龄');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(35, 1, '婚姻状况');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(36, 1, '年龄');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(37, 1, '性别');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(38, 1, '是否党员');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(39, 1, '社保号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(40, 1, '学历');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(41, 1, '籍贯');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(42, 1, '民族');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(43, 1, '身份证地址');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(44, 1, '居住地址');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(45, 1, '宿舍号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(46, 1, '工具箱号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(47, 1, '是否能带手机');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(48, 1, '是否能抽烟');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(49, 1, '是否签订合同');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(50, 1, '合同编号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(51, 1, '合同签订日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(52, 1, '合同期限');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(53, 1, '合同到期日');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(54, 1, '合同到期到计时');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(55, 1, '转正日期');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(56, 1, '试用期工资');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(57, 1, '转正后工资');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(58, 1, '紧急联系人');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(59, 1, '紧急联系方式');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(60, 1, '银行卡号');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(61, 1, '开户行');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(62, 1, '支行');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(63, 1, '本月是否核算工资');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(64, 1, '个税');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(65, 1, '备注');
        $line = 2;
        foreach ($staff['data'] as $staff_key => $staff_value) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $line, $staff_value['name']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $line, $staff_value['staff_code']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $line, $staff_value['zhiweizhuangtai']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $line, $staff_value['identification']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $line, $staff_value['mobile']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $line, $staff_value['leibie']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6, $line, $staff_value['linshigonggongjia']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7, $line, $staff_value['suoshugongsi']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8, $line, $staff_value['goumaishebaodangci']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9, $line, $staff_value['in_date']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10, $line, $staff_value['shifouerciruzhi']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11, $line, $staff_value['out_date']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12, $line, $staff_value['shifouzili']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13, $line, $staff_value['gongziyijiesuan']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(14, $line, $staff_value['xianbie']);// '线别');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15, $line, $sorted_depts[$staff_value['dept_id']]['dept_name']);// '部门名称');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(16, $line, $staff_value['gangwei']);// '岗位');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(17, $line, $staff_value['floor']);// '楼层');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(18, $line, $staff_value['rengongleibie']);// '人工类别');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(19, $line, $staff_value['legal_work_hour']);// '应上班工时');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(20, $line, $staff_value['jiabanfeibiaozhun']);// '加班费标准');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(21, $line, $staff_value['shifouxuetu']);// '是否学徒');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(23, $line, $staff_value['jieshaoren']);// '介绍人');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(24, $line, $staff_value['xinzhibaodi']);// '性质保底');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(29, $line, $staff_value['gongziguishufeiyong']);// '工资归属费用');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(32, $line, $staff_value['birthday']);// '出生日期');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(33, $line, substr($staff_value['birthday'], 6, 2));// '生日月份');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(34, $line, floor((time() - strtotime($staff_value['in_date']))/60/60/24/30));// '工龄');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(35, $line, $staff_value['marrige']);// '婚姻状况');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(36, $line, floor((time() - strtotime($staff_value['birthday']))/60/60/24/365));// '年龄');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(37, $line, $staff_value['gender']==1?'男':'女');// '性别');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(38, $line, $staff_value['shifoudangyuan']);// '是否党员');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(39, $line, $staff_value['shebaohao']);// '社保号');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(40, $line, $staff_value['education']);// '学历');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(41, $line, $staff_value['hometown']);// '籍贯');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(42, $line, $staff_value['ethnicity']);// '民族');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(43, $line, $staff_value['shenfenzhengdizhi']);// '身份证地址');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(44, $line, $staff_value['address']);// '居住地址');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(45, $line, $staff_value['room']);// '宿舍号');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(46, $line, $staff_value['gongjuxianghao']);// '工具箱号');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(47, $line, $staff_value['daishouji']);// '是否能带手机');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(48, $line, $staff_value['chouyan']);// '是否能抽烟');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(49, $line, $staff_value['shifouqiandinghetong']);// '是否签订合同');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(50, $line, $staff_value['hetongbianhao']);// '合同编号');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(51, $line, $staff_value['contract_from']);// '合同签订日期');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(52, $line, $staff_value['hetongqixian']);// '合同期限');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(53, $line, date('Y-m-d', strtotime("+".$staff_value['hetongqixian']." months", strtotime($staff_value['contract_from']))));// '合同到期日');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(54, $line, floor((strtotime("+".$staff_value['hetongqixian']." months", strtotime($staff_value['contract_from']))-time())/60/60/24));// '合同到期到计时');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(55, $line, $staff_value['zhuanzhengriqi']);// '转正日期');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(56, $line, $staff_value['shiyongqigongzi']);// '试用期工资');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(57, $line, $staff_value['zhuanzhenggongzi']);// '转正后工资');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(58, $line, $staff_value['emergency']);// '紧急联系人');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(59, $line, $staff_value['emergency_phone']);// '紧急联系方式');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(60, $line, $staff_value['yinhangkahao']);// '银行卡号');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(61, $line, $staff_value['kaihuhang']);// '开户行');
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(62, $line, $staff_value['zhihang']);// '支行');
            $line++;
        }
        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="员工名册_'.time().'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}