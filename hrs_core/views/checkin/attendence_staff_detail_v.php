<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th>部门</th>
                                    <th>工号</th>
                                    <th>日期</th>
                                    <th>出勤天数</th>
                                    <th>打卡次数</th>
                                    <th>打卡时间</th>
                                    <th>应上班时间</th>
                                    <th>正班时间</th>
                                    <th>加班时间</th>
                                    <th>缺勤时间</th>
                                    <th>请假时间</th>
                                    <th>放假时间</th>
                                    <th>旷工时间</th>
                                    <th>迟到时间</th>
                                    <th>班次</th>
                                    <th><a class="btn btn-warning" href="/checkin/attendence/expdetail?month=<?=$_GET['month']?>&month_to=<?=$_GET['month_to']?>&staff_code=<?=$_GET['staff_code']?>">导出</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($attendences as $key =>$value):?>
                                <tr>
                                    <td class="center"><?=$value['name']?></td>
                                    <td class="center"><?=$value['department']?></td>
                                    <td class="center"><?=$value['staff_code']?></td>
                                    <td class="center"><?=$key?></td>
                                    <td class="center"><?=$value['work_day']?>天</td>
                                    <td class="center"><?=$value['check_count']?></td>
                                    <td class="center">
                                    <?php 
                                    foreach($value['check_detail_array'] as $check_detail_key => $check_detail_value)
                                    {
                                        echo '<div';
                                        if($check_detail_key == $value['check_count'] -1 && strtotime($check_detail_value['check_time']) >= strtotime($key . ' 03:30:00') + 86400)
                                        {
                                            echo ' style="color:red;"';
                                        }
                                        echo '>';
                                        echo $check_detail_value['check_time'].'<br/>';
                                        if(substr($check_detail_value['check_time'], 0, 10) == $key){
                                            echo '<button class="btn btn-success set_check_date" value="'.$check_detail_value['id'].'">前日卡</button>';
                                        }else{
                                            echo '<button class="btn btn-success set_check_date1" value="'.$check_detail_value['id'].'">当日卡</button>';
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
                                        <button class="btn btn-small btn-warning check_in" value="<?=$key?>">补卡</button>
                                        <button class="btn btn-small btn-warning add_rule" value="<?=$key?>">班次</button><br/>
                                        <button class="btn btn-small btn-warning add_holiday" value="<?=$key?>">请假</button>
                                        <button class="btn btn-small btn-warning add_addition" value="<?=$key?>">连班</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <tr>
                                    <td class="center">总计：</td>
                                    <td class="center" colspan="3"></td>
                                    <td class="center"><?=$sum['work_day']?>天</td>
                                    <td class="center" colspan="2"></td>
                                    <td class="center"><?=$sum['legal_work_time']?>小时</td>
                                    <td class="center"><?=$sum['work_time']?>小时</td>
                                    <td class="center"><?=$sum['over_time']?>小时</td>
                                    <td class="center"><?=$sum['off_time']?>小时</td>
                                    <td class="center"><?=$sum['leave_time']?>小时</td>
                                    <td class="center"><?=$sum['holiday_time']?>小时</td>
                                    <td class="center"><?=$sum['error_time']?>小时</td>
                                    <td class="center"><?=$sum['late_time']?>分钟</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
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
                <input type="hidden" name="machine_id" id="machine_id" value="<?=$staff['machine_id']?>">
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
                        <input type="text" id="staff_code" name="staff_code" value="<?=$staff['staff_code']?>" readonly="readonly" />
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
                        <select name="dept_id" id="dept_id" class="form-control">
                            <option value="0">请选择</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">工号 :</label>
                    <div class="controls">
                        <input type="text" id="staff_code" name="staff_code" value="<?=$staff['staff_code']?>"  />
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
                        <select name="holiday_target" id="holiday_target" class="form-control">
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
                        <select name="holiday_dept_id" id="holiday_dept_id" class="form-control">
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
                        <input type="text" id="holiday_staff_code" name="holiday_staff_code" value="<?=$staff['staff_code']?>" />
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
                        <input type="text" id="holiday_hours" name="holiday_hours" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">类型 :</label>
                    <div class="controls">
                        <select name="holiday_type" id="holiday_type" class="form-control">
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
                        <select name="holiday_is_enable" id="holiday_is_enable" class="form-control">
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
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('.check_in').on('click', function(){
    var check_date = $(this).val();
    $('#check_in_form').find('h5').text('补卡');
    $('#check_in_form').find('#check_date').val(check_date);
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
    var the_date = $(this).val();
    $('#schedule_edit_form').find('h5').text('新增');
    $('#schedule_edit_form').find('#rule_id').val(0);
    $('#schedule_edit_form').find('#start_time').val('');
    $('#schedule_edit_form').find('#start_date').val(the_date);
    $('#schedule_edit_form').find('#end_date').val(the_date);
    $('#schedule_edit_form').find('#is_enable').val(1);
    $('#schedule_edit_form').modal('show');
});
$('#save_rule').on('click', function(){
    $.ajax({ 
        url: "/checkin/setsche/savestaff",
        data: {"staff_code":$("#staff_code").val(), "start_date":$("#start_date").val(), "end_date":$("#end_date").val(), "start_time":$("#start_time").val(), "is_enable":$("#is_enable").val(), "rule_id":$("#rule_id").val()},
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
    var the_date = $(this).val();
    $('#holiday_edit_form').find('h5').text('新增');
    $('#holiday_edit_form').find('#holiday_id').val(0);
    $('#holiday_edit_form').find('#dept_id').val(0);
    $('#holiday_edit_form').find('#holiday').val(the_date);
    $('#holiday_edit_form').find('#hours').val('');
    $('#holiday_edit_form').find('#type').val(0);
    $('#holiday_edit_form').find('#is_enable').val(1);
    $('#holiday_edit_form').modal('show');
})
$('.add_addition').on('click', function(){
    var the_date = $(this).val();
    $('#addition_edit_form').find('h5').text('新增');
    $('#addition_edit_form').find('#addition_id').val(0);
    $('#addition_edit_form').find('#dept_id').val(0);
    $('#addition_edit_form').find('#addition').val(the_date);
    $('#addition_edit_form').find('#hours').val('');
    $('#addition_edit_form').find('#type').val(0);
    $('#addition_edit_form').find('#is_enable').val(1);
    $('#addition_edit_form').modal('show');
})
$('#save_holiday').on('click', function(){
    $.ajax({ 
        url: "/checkin/holiday/save",
        data: {"target":$("#holiday_target").val(), "dept_id":$("#holiday_dept_id").val(), "staff_code":$("#holiday_staff_code").val(), "holiday":$("#holiday").val(), "hours":$("#holiday_hours").val(), "type":$("#holiday_type").val(), "is_enable":$("#holiday_is_enable").val(), "holiday_id":$("#holiday_id").val()},
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
$('#save_addition').on('click', function(){
    $.ajax({ 
        url: "/checkin/addition/save",
        data: {"target":$("#target").val(), "dept_id":$("#dept_id").val(), "staff_code":$("#staff_code").val(), "addition":$("#addition").val(), "hours":$("#hours").val(), "type":$("#type").val(), "is_enable":$("#is_enable").val(), "addition_id":$("#addition_id").val()},
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
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>