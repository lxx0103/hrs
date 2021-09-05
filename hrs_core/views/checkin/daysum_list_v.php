<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <form id="form_search" name="search_form" action>
                                <select id="dept_select" class="span2" multiple="multiple" >
                                    <?php foreach($depts as $dept):?>
                                    <option value="<?=$dept['id']?>"<?=in_array($dept['id'], explode(',', $filters['dept_ids']))?' selected':''?>><?=$dept['dept_name']?></option>
                                    <?php endforeach?>
                                </select>
                                <input type="text" class="form-control span1" name="staff_code" placeholder="工号"<?=$filters['staff_code']?' value="'.$filters['staff_code'].'"':''?>>
                                <input type="text" class="form-control span1" name="name" placeholder="姓名"<?=$filters['name']?' value="'.$filters['name'].'"':''?>>
                                <input type="text" class="form-control span2 form_datetime2" name="date" placeholder="日期"<?=$filters['date']?' value="'.$filters['date'].'"':''?>>
                                <input type="hidden" name="dept_ids" value="" id="dept_ids">
                                <input type="button" class="form-control btn btn-success" style="margin-bottom: 10px;" id="sub_btn" value="搜索">
                                <!-- <input type="button" class="form-control btn btn-warning" style="margin-bottom: 10px;" value="导出" id="expdata"> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="center"><input type="checkbox" id="check_all"></th>
                                    <th class="center">姓名</th>
                                    <th class="center">部门</th>
                                    <th class="center">工号</th>
                                    <th class="center">日期</th>
                                    <th class="center">出勤天数</th>
                                    <th class="center">打卡次数</th>
                                    <th class="center">前日打卡</th>
                                    <th class="center">打卡时间</th>
                                    <th class="center">次日打卡</th>
                                    <th class="center">应上班</th>
                                    <th class="center">正班</th>
                                    <th class="center">加班</th>
                                    <th class="center">缺勤</th>
                                    <th class="center">请假</th>
                                    <th class="center">放假</th>
                                    <th class="center">旷工</th>
                                    <th class="center">迟到</th>
                                    <th class="center">班次</th>
                                    <th> 
                                        <button class="btn btn-small btn-warning check_in_all">补卡</button>
                                        <button class="btn btn-small btn-warning add_rule_all">班次</button><br/>
                                        <button class="btn btn-small btn-warning add_holiday_all">请假</button>
                                        <button class="btn btn-small btn-warning add_addition_all">连班</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($staff_checkins as $key =>$value):?>
                                <tr>
                                    <td class="center"><input type="checkbox" name="staff_checkbox" class="check_box_staff" value="<?=$value['staff_code']?>"></td>
                                    <td class="center"><?=$value['name']?></td>
                                    <td class="center"><?=$value['dept_name']?></td>
                                    <td class="center"><?=$value['staff_code']?></td>
                                    <td class="center"><?=$value['date']?></td>
                                    <td class="center"><?=$value['checkday']?>天</td>
                                    <td class="center"><?=$value['check_count']?></td>
                                    <td class="center">
                                    <?php 
                                    foreach($value['prev_check_detail_array'] as $prev_check_detail_key => $prev_check_detail_value)
                                    {
                                        echo '<div';
                                        if(!in_array($prev_check_detail_value['create_user'], array('SYSTEM','MIGRATE'))){
                                            echo ' style="color: blue;font-weight: bold;"';
                                        }
                                        echo '>';
                                        echo $prev_check_detail_value['check_time'].'<br/>';
                                        // if(substr($prev_check_detail_value['check_time'], 0, 10) == $value['date']){
                                        //     echo '<button class="btn btn-success set_check_date" value="'.$prev_check_detail_value['id'].'">前日卡</button>';
                                        // }else{
                                        //     echo '<button class="btn btn-success set_check_date1" value="'.$prev_check_detail_value['id'].'">当日卡</button>';
                                        // }
                                        echo '</div>';
                                    }
                                    ?>
                                    </td>
                                    <td class="center">
                                    <?php 
                                    foreach($value['check_detail_array'] as $check_detail_key => $check_detail_value)
                                    {
                                        echo '<div';
                                        if(!in_array($check_detail_value['create_user'], array('SYSTEM','MIGRATE'))){
                                            echo ' style="color: blue;font-weight: bold;"';
                                        }
                                        echo '>';
                                        echo $check_detail_value['check_time'].'<br/>';
                                        if(substr($check_detail_value['check_time'], 0, 10) == $value['date']){
                                            echo '<button class="btn btn-success set_check_date" value="'.$check_detail_value['id'].'">前日卡</button>';

                                        }else{
                                            echo '<button class="btn btn-success set_check_date1" value="'.$check_detail_value['id'].'">当日卡</button>';
                                        }
                                        echo '<button class="btn btn-warning del_check_in" value="'.$check_detail_value['id'].'">删除卡</button>';
                                        echo '</div>';
                                    }
                                    ?>
                                    </td>
                                    <td class="center">
                                    <?php 
                                    foreach($value['next_check_detail_array'] as $next_check_detail_key => $next_check_detail_value)
                                    {
                                        echo '<div';
                                        if(!in_array($next_check_detail_value['create_user'], array('SYSTEM','MIGRATE'))){
                                            echo ' style="color: blue;font-weight: bold;"';
                                        }
                                        echo '>';
                                        echo $next_check_detail_value['check_time'].'<br/>';
                                        if(substr($next_check_detail_value['check_time'], 0, 10) != $value['date']){
                                            echo '<button class="btn btn-success set_check_date" value="'.$next_check_detail_value['id'].'">前日卡</button>';
                                        }else{
                                            echo '<button class="btn btn-success set_check_date1" value="'.$next_check_detail_value['id'].'">当日卡</button>';
                                        }
                                        echo '<button class="btn btn-warning del_check_in" value="'.$check_detail_value['id'].'">删除卡</button>';
                                        echo '</div>';
                                    }
                                    ?>
                                    </td>
                                    <td class="center"><?=$value['legal_work_time']?>小时</td>
                                    <td class="center"><?=$value['work_time']?>小时</td>
                                    <td class="center"><?=$value['over_time']?>小时</td>
                                    <td class="center"><?=$value['off_time']?>小时</td>
                                    <td class="center"><?=$value['leave_time']?>小时</td>
                                    <td class="center"><?=$value['holiday_time']?>小时</td>
                                    <td class="center"><?=$value['error_time']?>小时</td>
                                    <td class="center"><?=$value['late_time']?>分钟</td>
                                    <td class="center">
                                    <?php 
                                    foreach($value['in_time'] as $in_time_key => $in_time_value)
                                    {
                                        echo '<div>';
                                        echo $in_time_value.'<br/>';
                                        echo '</div>';
                                    }
                                    ?>
                                    </td>
                                    <td class="center">
                                        <button class="btn btn-small btn-warning check_in" value="<?=$value['machine_id']?>">补卡</button>
                                        <button class="btn btn-small btn-warning add_rule" value="<?=$value['staff_code']?>">班次</button><br/>
                                        <button class="btn btn-small btn-warning add_holiday" value="<?=$value['staff_code']?>">请假</button>
                                        <button class="btn btn-small btn-warning add_addition" value="<?=$value['staff_code']?>">连班</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                            </tbody>
                            <input type="hidden" id="current_date" value="<?=$filters['date']?>">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="check_in_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">补卡时间 :</label>
                    <div class="controls">
                        <input type="text" id="check_time" name="check_time" class="form_datetime" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">设为前日卡 :</label>
                    <div class="controls">
                        <select name="check_type" id="check_type" class="form-control">
                            <option value="1">是</option>
                            <option value="0" selected="selected">否</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="machine_id" id="machine_id" value="">
                <input type="hidden" name="check_date" id="check_date" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_check_in" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="schedule_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">工号 :</label>
                    <div class="controls">
                        <input type="text" id="staff_code_sche" name="staff_code_sche" value="" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">上班时间 :</label>
                    <div class="controls">
                        <input type="text" id="start_time" name="start_time" class="form_datetime1" placeholder="09:00" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">开始日期 :</label>
                    <div class="controls">
                        <input type="text" id="start_date" name="start_date" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">结束日期 :</label>
                    <div class="controls">
                        <input type="text" id="end_date" name="end_date" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="is_enable" id="is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="rule_id" id="rule_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_rule" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addition_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">对象 :</label>
                    <div class="controls">
                        <select name="target" id="target" class="form-control">
                            <option value="2">员工</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">部门 :</label>
                    <div class="controls">
                        <select name="dept_id_addition" id="dept_id_addition" class="form-control">
                            <option value="0">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">工号 :</label>
                    <div class="controls">
                        <input type="text" id="staff_code_addition" name="staff_code_addition" value=""  />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">日期 :</label>
                    <div class="controls">
                        <input type="text" id="addition" name="addition" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">时长 :</label>
                    <div class="controls">
                        <input type="text" id="hours" name="hours" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型 :</label>
                    <div class="controls">
                        <select name="type" id="type" class="form-control">
                            <option value="0">请选择</option>
                            <option value="1">中午</option>
                            <option value="2">晚上</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="is_enable" id="is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="addition_id" id="addition_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_addition" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="holiday_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">放假对象 :</label>
                    <div class="controls">
                        <select name="target" id="target" class="form-control">
                            <option value="0">请选择</option>
                            <option value="1">部门</option>
                            <option value="2" selected="selected">员工</option>
                            <option value="3">全公司</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">部门 :</label>
                    <div class="controls">
                        <select name="dept_id" id="dept_id" class="form-control">
                            <option value="0">请选择</option>
                            <?php foreach($depts as $dept):?>
                            <option value="<?=$dept['id']?>"><?=$dept['dept_name']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">工号 :</label>
                    <div class="controls">
                        <input type="text" id="staff_code_holiday" name="staff_code_holiday" value="" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">日期 :</label>
                    <div class="controls">
                        <input type="text" id="holiday" name="holiday" readonly="readonly" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">时长 :</label>
                    <div class="controls">
                        <input type="text" id="hours_holiday" name="hours_holiday" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型 :</label>
                    <div class="controls">
                        <select name="type_holiday" id="type_holiday" class="form-control">
                            <option value="0">请选择</option>
                            <option value="1">放假</option>
                            <option value="2">事假</option>
                            <option value="3">病假</option>
                            <option value="4">旷工</option>
                            <option value="5">其他</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="is_enable" id="is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="holiday_id" id="holiday_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_holiday" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="mul_check_in_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">补卡时间 :</label>
                    <div class="controls">
                        <input type="text" id="mul_check_time" name="mul_check_time" class="form_datetime" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">设为前日卡 :</label>
                    <div class="controls">
                        <select name="mul_check_type" id="mul_check_type" class="form-control">
                            <option value="1">是</option>
                            <option value="0" selected="selected">否</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-success" id="mul_save_check_in" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="mul_schedule_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">上班时间 :</label>
                    <div class="controls">
                        <input type="text" id="mul_start_time" name="mul_start_time" class="form_datetime1" placeholder="09:00" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="is_enable" id="is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-success" id="mul_save_rule" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="mul_addition_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">时长 :</label>
                    <div class="controls">
                        <input type="text" id="mul_addition_hours" name="mul_addition_hours" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型 :</label>
                    <div class="controls">
                        <select name="mul_addition_type" id="mul_addition_type" class="form-control">
                            <option value="1">中午</option>
                            <option value="2">晚上</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="mul_addition_is_enable" id="mul_addition_is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-success" id="mul_save_addition" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="mul_holiday_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">时长 :</label>
                    <div class="controls">
                        <input type="text" id="mul_hours_holiday" name="mul_hours_holiday" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型 :</label>
                    <div class="controls">
                        <select name="mul_type_holiday" id="mul_type_holiday" class="form-control">
                            <option value="0">请选择</option>
                            <option value="1">放假</option>
                            <option value="2">事假</option>
                            <option value="3">病假</option>
                            <option value="4">旷工</option>
                            <option value="5">其他</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否启用 :</label>
                    <div class="controls">
                        <select name="mul_holiday_is_enable" id="mul_holiday_is_enable" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-success" id="mul_save_holiday" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('.check_in').on('click', function(){
    var check_date = $('#current_date').val();
    var machine_id = $(this).val();
    $('#check_in_form').find('h5').text('补卡');
    $('#check_in_form').find('#check_date').val(check_date);
    $('#check_in_form').find('#machine_id').val(machine_id);
    $('#check_in_form').modal('show');
})
$('#save_check_in').on('click', function(){
    $.ajax({ 
        url: "/checkin/attendence/checkin",
        data: {"machine_id":$("#machine_id").val(), "check_date":$("#check_date").val(), "check_time":$("#check_time").val(), "check_type":$("#check_type").val()},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$(".form_datetime").datetimepicker({
    format: 'hh:ii',    
    todayBtn:  1,
    autoclose: 1,
    startView: 1,
    minView: 0
});
$('.add_rule').on('click', function(){
    var staff_code = $(this).val();
    var the_date = $('#current_date').val();
    $('#schedule_edit_form').find('h5').text('新增');
    $('#schedule_edit_form').find('#rule_id').val(0);
    $('#schedule_edit_form').find('#start_time').val('');
    $('#schedule_edit_form').find('#staff_code_sche').val(staff_code);
    $('#schedule_edit_form').find('#start_date').val(the_date);
    $('#schedule_edit_form').find('#end_date').val(the_date);
    $('#schedule_edit_form').find('#is_enable').val(1);
    $('#schedule_edit_form').modal('show');
});
$('#save_rule').on('click', function(){
    $.ajax({ 
        url: "/checkin/setsche/savestaff",
        data: {"staff_code":$("#staff_code_sche").val(), "start_date":$("#start_date").val(), "end_date":$("#end_date").val(), "start_time":$("#start_time").val(), "is_enable":$("#is_enable").val(), "rule_id":$("#rule_id").val()},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
});
$('.add_holiday').on('click', function(){
    var staff_code = $(this).val();
    var the_date = $('#current_date').val();
    $('#holiday_edit_form').find('h5').text('新增');
    $('#holiday_edit_form').find('#holiday_id').val(0);
    $('#holiday_edit_form').find('#dept_id').val(0);
    $('#holiday_edit_form').find('#holiday').val(the_date);
    $('#holiday_edit_form').find('#staff_code_holiday').val(staff_code);
    $('#holiday_edit_form').find('#hours_holiday').val('');
    $('#holiday_edit_form').find('#type_holiday').val(0);
    $('#holiday_edit_form').find('#is_enable').val(1);
    $('#holiday_edit_form').modal('show');
})
$('#save_holiday').on('click', function(){
    $.ajax({ 
        url: "/checkin/holiday/save",
        data: {"target":$("#target").val(), "dept_id":$("#dept_id").val(), "staff_code":$("#staff_code_holiday").val(), "holiday":$("#holiday").val(), "holiday_end":$("#holiday").val(), "hours":$("#hours_holiday").val(), "type":$("#type_holiday").val(), "is_enable":$("#is_enable").val(), "holiday_id":$("#holiday_id").val()},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('.add_addition').on('click', function(){
    var staff_code = $(this).val();
    var the_date = $('#current_date').val();
    $('#addition_edit_form').find('h5').text('新增');
    $('#addition_edit_form').find('#addition_id').val(0);
    $('#addition_edit_form').find('#dept_id_addition').val(0);
    $('#addition_edit_form').find('#addition').val(the_date);
    $('#addition_edit_form').find('#staff_code_addition').val(staff_code);
    $('#addition_edit_form').find('#hours').val('');
    $('#addition_edit_form').find('#type').val(0);
    $('#addition_edit_form').find('#is_enable').val(1);
    $('#addition_edit_form').modal('show');
})
$('#save_addition').on('click', function(){
    $.ajax({ 
        url: "/checkin/addition/save",
        data: {"target":$("#target").val(), "dept_id":$("#dept_id").val(), "staff_code":$("#staff_code_addition").val(), "addition":$("#addition").val(), "hours":$("#hours").val(), "type":$("#type").val(), "is_enable":$("#is_enable").val(), "addition_id":$("#addition_id").val()},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$(".form_datetime1").datetimepicker({
    format: 'hh:ii',    
    todayBtn:  1,
    autoclose: 1,
    startView: 1,
    minView: 0
});
$(".form_datetime2").datetimepicker({
    format: 'yyyy-mm-dd',    
    todayBtn:  1,
    autoclose: 1,
    startView: 2,
    minView: 2
});
$('.set_check_date').on('click', function(){
    var check_id = $(this).val();
    $.ajax({ 
        url: "/checkin/attendence/setcheckdate",
        data: {"check_id": check_id, type: 2},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('.set_check_date1').on('click', function(){
    var check_id = $(this).val();
    console.log(check_id);
    $.ajax({ 
        url: "/checkin/attendence/setcheckdate",
        data: {"check_id": check_id, type: 1},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#check_all').click(function(){
    var is_check_all = $('#check_all').attr('checked');
    if(is_check_all == 'checked'){
        $('.check_box_staff').attr('checked', 'checked');
    }else{
        $('.check_box_staff').removeAttr('checked');
    }
});
$('.check_in_all').click(function(){
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        var check_date = $('#current_date').val();
        $('#mul_check_in_form').find('h5').text('集体补卡');
        $('#mul_check_in_form').find('#check_date').val(check_date);
        $('#mul_check_in_form').modal('show');
    }
})
$('#mul_save_check_in').on('click', function(){
    var the_date = $('#current_date').val();
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        $.ajax({ 
            url: "/checkin/attendence/checkinall",
            data: {"check_date":the_date, "check_time":$("#mul_check_time").val(), "check_type":$("#mul_check_type").val(), "check_codes":check_codes},
            dataType: 'json',
            type: 'POST',
            success: function(result){            
                if(result.status == 1){
                    layer.alert(result.msg, function(){
                        window.location.reload();
                    });
                }else{
                    layer.alert(result.msg);
                }
            }
        });
    }
})
$('.add_rule_all').click(function(){
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        var check_date = $('#current_date').val();
        $('#mul_schedule_edit_form').find('h5').text('集体设置班次');
        $('#mul_schedule_edit_form').find('#mul_start_time').val('');
        $('#mul_schedule_edit_form').modal('show');
    }
})
$('#mul_save_rule').on('click', function(){
    var the_date = $('#current_date').val();
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        $.ajax({ 
            url: "/checkin/setsche/savestaffall",
            data: {"staff_code":check_codes, "start_date":the_date, "end_date":the_date, "start_time":$("#mul_start_time").val(), "is_enable":$("#is_enable").val()},
            dataType: 'json',
            type: 'POST',
            success: function(result){            
                if(result.status == 1){
                    layer.alert(result.msg, function(){
                        window.location.reload();
                    });
                }else{
                    layer.alert(result.msg);
                }
            }
        });
    }
})
$('.add_addition_all').click(function(){
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        var check_date = $('#current_date').val();
        $('#mul_addition_edit_form').find('h5').text('集体设置连班');
        $('#mul_addition_edit_form').find('#mul_addition_hours').val('');
        $('#mul_addition_edit_form').find('#mul_addition_type').val(1);
        $('#mul_addition_edit_form').modal('show');
    }
})
$('#mul_save_addition').on('click', function(){
    var the_date = $('#current_date').val();
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        $.ajax({ 
            url: "/checkin/addition/saveall",
            data: {"staff_code":check_codes, "addition":the_date, "hours":$("#mul_addition_hours").val(), "type":$("#mul_addition_type").val(), "is_enable":$("#mul_addition_is_enable").val()},
            dataType: 'json',
            type: 'POST',
            success: function(result){            
                if(result.status == 1){
                    layer.alert(result.msg, function(){
                        window.location.reload();
                    });
                }else{
                    layer.alert(result.msg);
                }
            }
        });
    }
})
$('.add_holiday_all').click(function(){
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        var check_date = $('#current_date').val();
        $('#mul_holiday_edit_form').find('h5').text('集体设置假期');
        $('#mul_holiday_edit_form').find('#mul_hours_holiday').val('');
        $('#mul_holiday_edit_form').find('#mul_type_holiday').val(0);
        $('#mul_holiday_edit_form').modal('show');
    }
})
$('#mul_save_holiday').on('click', function(){
    var the_date = $('#current_date').val();
    var check_codes = [];
    $("input[name='staff_checkbox']:checked").each(function(i){
        check_codes[i] = $(this).val();
    })
    if(check_codes.length == 0){
        layer.alert('请至少选中1个');
    }else{
        $.ajax({ 
            url: "/checkin/holiday/saveall",
            data: { "staff_code":check_codes, "holiday":the_date, "holiday_end":the_date, "hours":$("#mul_hours_holiday").val(), "type":$("#mul_type_holiday").val(), "is_enable":$("#mul_holiday_is_enable").val()},
            dataType: 'json',
            type: 'POST',
            success: function(result){            
                if(result.status == 1){
                    layer.alert(result.msg, function(){
                        window.location.reload();
                    });
                }else{
                    layer.alert(result.msg);
                }
            }
        });
    }
})
$('.del_check_in').on('click', function(){
    var check_id = $(this).val();
    layer.confirm('确定删除？', function(){
        $.ajax({ 
            url: "/checkin/attendence/delcheck",
            data: {"check_id": check_id},
            dataType: 'json',
            type: 'POST',
            success: function(result){            
                if(result.status == 1){
                    layer.alert(result.msg, function(){
                        window.location.reload();
                    });
                }else{
                    layer.alert(result.msg);
                }
            }
        })
    });
    
})
$(document).ready(function() {
    $('#dept_select').multiselect();
});

$("#sub_btn").on("click", function(){
    var checked_depts = [];
    $(".multiselect-container input[type='checkbox']:checked").each(function(i){
        checked_depts[i] = $(this).val();
    })
    $("#dept_ids").val(checked_depts);
    // $('#form_search').attr("action", "/checkin/attendence/exphistory");
    $('#form_search').submit();
})
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>