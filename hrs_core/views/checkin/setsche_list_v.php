<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>部门名称</th>
                                    <th>上班时间</th>
                                    <th>开始日期</th>
                                    <th>结束日期</th>
                                    <th>是否启用</th>
                                    <th>更新时间</th>
                                    <th>更新人</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($rules as $row):?>
                                <tr>
                                    <td class="center"><?=$row['id']?></td>
                                    <td class="center"><?=$sorted_depts[$row['dept_id']]['dept_name']?></td>
                                    <td class="center"><?=$row['start_time']?></td>
                                    <td class="center"><?=$row['start_date']?></td>
                                    <td class="center"><?=$row['end_date']?></td>
                                    <td class="center"><?=$row['is_enable']==1?'是':'否'?></td>
                                    <td class="center"><?=$row['update_time']?></td>
                                    <td class="center"><?=$row['update_user']?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_rule" value="<?=$row['id']?>">编辑</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <tr>
                                    <td class="center" colspan="8"></td>
                                    <td class="center">
                                        <button class="btn btn-success add_rule">新增</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="schedule_edit_form" tabindex="-1" role="dialog" style="top: 30%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">                
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
                    <label class="control-label">上班时间 :</label>
                    <div class="controls">
                        <input type="text" id="start_time" name="start_time" class="form_datetime1" placeholder="09:00" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">开始日期 :</label>
                    <div class="controls">
                        <input type="text" id="start_date" name="start_date" class="form_datetime2" placeholder="1999-01-01" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">结束日期 :</label>
                    <div class="controls">
                        <input type="text" id="end_date" name="end_date" class="form_datetime2" placeholder="2000-01-01" />
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
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('.add_rule').on('click', function(){
    $('#schedule_edit_form').find('h5').text('新增');
    $('#schedule_edit_form').find('#rule_id').val(0);
    $('#schedule_edit_form').find('#dept_id').val(0);
    $('#schedule_edit_form').find('#sche_id').val(0);
    $('#schedule_edit_form').find('#start_date').val('');
    $('#schedule_edit_form').find('#end_date').val('');
    $('#schedule_edit_form').find('#start_time').val('');
    $('#schedule_edit_form').find('#is_enable').val(1);
    $('#schedule_edit_form').modal('show');
})
$('.edit_rule').on('click', function(){
    var rule_id = $(this).val();
    $.ajax({ 
        url: "/checkin/setsche/one",
        data: {"rule_id":rule_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#schedule_edit_form').find('h5').text('修改');
                $('#schedule_edit_form').find('#rule_id').val(result.data.id);
                $('#schedule_edit_form').find('#dept_id').val(result.data.dept_id);
                $('#schedule_edit_form').find('#sche_id').val(result.data.sche_id);
                $('#schedule_edit_form').find('#start_date').val(result.data.start_date);
                $('#schedule_edit_form').find('#end_date').val(result.data.end_date);
                $('#schedule_edit_form').find('#start_time').val(result.data.start_time);
                $('#schedule_edit_form').find('#is_enable').val(result.data.is_enable);
                $('#schedule_edit_form').modal('show');
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#save_rule').on('click', function(){
    $.ajax({ 
        url: "/checkin/setsche/save",
        data: {"dept_id":$("#dept_id").val(), "sche_id":$("#sche_id").val(), "start_date":$("#start_date").val(), "end_date":$("#end_date").val(), "start_time":$("#start_time").val(), "is_enable":$("#is_enable").val(), "rule_id":$("#rule_id").val()},
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
    startView: 4,
    minView: 2
});
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>