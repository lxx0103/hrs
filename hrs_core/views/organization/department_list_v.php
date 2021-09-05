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
                                    <th>是否有加班工时</th>
                                    <th>午休</th>
                                    <th>晚休</th>
                                    <th>是否启用</th>
                                    <th>更新时间</th>
                                    <th>更新人</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($depts as $row):?>
                                <tr>
                                    <td class="center"><?=$row['id']?></td>
                                    <td class="center"><?=$row['dept_name']?></td>
                                    <td class="center"><?=$row['has_overtime']==1?'是':'否'?></td>
                                    <td class="center"><?=$row['noon_break_start']?> - <?=$row['noon_break_end']?></td>
                                    <td class="center"><?=$row['night_break_start']?> - <?=$row['night_break_end']?></td>
                                    <td class="center"><?=$row['is_enable']==1?'是':'否'?></td>
                                    <td class="center"><?=$row['update_time']?></td>
                                    <td class="center"><?=$row['update_user']?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_dept" value="<?=$row['id']?>">编辑</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <tr>
                                    <td class="center" colspan="5"></td>
                                    <td class="center">
                                        <button class="btn btn-success add_dept">新增</button>
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

<div class="modal fade" id="dept_edit_form" tabindex="-1" role="dialog" style="top: 30%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">部门名称 :</label>
                    <div class="controls">
                        <input type="text" id="dept_name" name="dept_name" placeholder="部门名称" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否有加班工时 :</label>
                    <div class="controls">
                        <select name="has_overtime" id="has_overtime" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">午休时间 :</label>
                    <div class="controls">
                        <input type="text" id="noon_break_start" name="noon_break_start" placeholder="从" value="12:00:00" style="width: 90px;" /> -
                        <input type="text" id="noon_break_end" name="noon_break_end" placeholder="到"  value="13:00:00"  style="width: 90px;" />    
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">午休时间 :</label>
                    <div class="controls">
                        <input type="text" id="night_break_start" name="night_break_start" placeholder="从"  value="17:30:00" style="width: 90px;" /> -
                        <input type="text" id="night_break_end" name="night_break_end" placeholder="到"  value="18:00:00" style="width: 90px;" />
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
                <input type="hidden" name="dept_id" id="dept_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_dept" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('.add_dept').on('click', function(){
    $('#dept_edit_form').find('h5').text('新增');
    $('#dept_edit_form').find('#dept_id').val(0);
    $('#dept_edit_form').find('#dept_name').val('');
    $('#dept_edit_form').find('#has_overtime').val(1);
    $('#dept_edit_form').find('#noon_break_start').val('12:00:00');
    $('#dept_edit_form').find('#noon_break_end').val("13:00:00");
    $('#dept_edit_form').find('#night_break_start').val("17:30:00");
    $('#dept_edit_form').find('#night_break_end').val("18:00:00");
    $('#dept_edit_form').find('#is_enable').val(1);
    $('#dept_edit_form').modal('show');
})
$('.edit_dept').on('click', function(){
    var dept_id = $(this).val();
    $.ajax({ 
        url: "/organization/department/one",
        data: {"dept_id":dept_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#dept_edit_form').find('h5').text('修改');
                $('#dept_edit_form').find('#dept_id').val(result.data.id);
                $('#dept_edit_form').find('#dept_name').val(result.data.dept_name);
                $('#dept_edit_form').find('#has_overtime').val(result.data.has_overtime);
                $('#dept_edit_form').find('#is_enable').val(result.data.is_enable);
                $('#dept_edit_form').find('#noon_break_start').val(result.data.noon_break_start);
                $('#dept_edit_form').find('#noon_break_end').val(result.data.noon_break_end);
                $('#dept_edit_form').find('#night_break_start').val(result.data.night_break_start);
                $('#dept_edit_form').find('#night_break_end').val(result.data.night_break_end);
                $('#dept_edit_form').modal('show');
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#save_dept').on('click', function(){
    $.ajax({ 
        url: "/organization/department/save",
        data: {"dept_name":$("#dept_name").val(),"noon_break_start":$("#noon_break_start").val(),"noon_break_end":$("#noon_break_end").val(),"night_break_start":$("#night_break_start").val(),"night_break_end":$("#night_break_end").val(), "has_overtime":$("#has_overtime").val(), "is_enable":$("#is_enable").val(), "dept_id":$("#dept_id").val()},
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                layer.alert(result.msg, function(){
                    window.location.reload();
                });
            }else{
                layer.alert(result.msg, function(){
                    //关闭后的操作
                });
            }
        }
    });
})
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>