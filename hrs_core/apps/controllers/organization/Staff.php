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
        $staff_data['xianbie'] = $this->input->post('xianbie');
        $staff_data['dept_id'] = $this->input->post('dept_id');
        $staff_data['gangwei'] = $this->input->post('gangwei');
        $staff_data['floor'] = $this->input->post('floor');
        $staff_data['rengongleibie'] = $this->input->post('rengongleibie');
        $staff_data['legal_work_hour'] = $this->input->post('legal_work_hour');
        $staff_data['jiabanfeibiaozhun'] = $this->input->post('jiabanfeibiaozhun');
        $staff_data['shifouxuetu'] = $this->input->post('shifouxuetu');
        $staff_data['jieshaoren'] = $this->input->post('jieshaoren');
        $staff_data['xinzhibaodi'] = $this->input->post('xinzhibaodi');
        $staff_data['miankouhuoshifei'] = $this->input->post('miankouhuoshifei');
        $staff_data['gongziguishufeiyong'] = $this->input->post('gongziguishufeiyong');
        $staff_data['birthday'] = $this->input->post('birthday');
        $staff_data['marrige'] = $this->input->post('marrige');
        $staff_data['gender'] = $this->input->post('gender');
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
        if($staff_data['staff_code'] == ''){
            $error_message .= '缺少工号,';
        }
        if($staff_data['name'] == ''){
            $error_message .= '缺少姓名,';
        }
        if($staff_data['dept_id'] == 0){
            $error_message .= '部门错误,';
        }
        if($staff_data['gender'] == 0){
            $error_message .= '性别错误,';
        }
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
            $currentSheet = $PHPExcel->getSheet(0);
            $allColumn = $currentSheet->getHighestColumn();
            $allRow = $currentSheet->getHighestRow();
            $all_error = '';
            for($currentRow=2; $currentRow <= $allRow; $currentRow ++)
            {
                $staff_data = array();
                $staff_data['name'] = $currentSheet->getCell('A'. $currentRow)->getValue();
                $staff_data['staff_code'] = $currentSheet->getCell('B'. $currentRow)->getValue();
                $staff_data['zhiweizhuangtai'] = $currentSheet->getCell('c'. $currentRow)->getValue();
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
                $staff_data['xianbie'] = $currentSheet->getCell('O'. $currentRow)->getValue();
                $staff_data['dept_id'] = $currentSheet->getCell('P'. $currentRow)->getValue();
                $staff_data['gangwei'] = $currentSheet->getCell('Q'. $currentRow)->getValue();
                $staff_data['floor'] = $currentSheet->getCell('R'. $currentRow)->getValue();
                $staff_data['rengongleibie'] = $currentSheet->getCell('S'. $currentRow)->getValue();
                $staff_data['legal_work_hour'] = $currentSheet->getCell('T' . $currentRow)->getValue();
                $staff_data['jiabanfeibiaozhun'] = $currentSheet->getCell('U'. $currentRow)->getValue();
                $staff_data['shifouxuetu'] = $currentSheet->getCell('V'. $currentRow)->getValue();
                $staff_data['jieshaoren'] = $currentSheet->getCell('W'. $currentRow)->getValue();
                $staff_data['xinzhibaodi'] = $currentSheet->getCell('X'. $currentRow)->getValue();
                $staff_data['miankouhuoshifei'] = $currentSheet->getCell('Y'. $currentRow)->getValue();
                $staff_data['gongziguishufeiyong'] = $currentSheet->getCell('Z'. $currentRow)->getValue();
                $staff_data['birthday'] = gmdate('Y-m-d', ($currentSheet->getCell('AA'. $currentRow)->getValue()- 25569) * 24 * 60 * 60);
                $staff_data['marrige'] = $currentSheet->getCell('AB'. $currentRow)->getValue();
                $staff_data['gender'] = $currentSheet->getCell('AC'. $currentRow)->getValue();
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
                    }
                }
                if($error_message != '')
                {
                    $error_message .= '出错';
                    $all_error .= '第' . $currentRow . '行' . $error_message;
                }else{
                    $staff_data['gender'] = $staff_data['gender'] == '男'?'1':'2';
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

    // public function save()
    // {
    //     $staff_id = trim($this->input->post('staff_id'));
    //     $out_date = trim($this->input->post('out_date'));
    //     $staff_data['id'] = $staff_id;
    //     $staff_data['out_date'] = $out_date;
    //     $save = $this->Staff_m->save($staff_data, $this->session->username);
    //     echo json_encode($save);
    // }

}