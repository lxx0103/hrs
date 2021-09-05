<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <form>
                                <input type="text" class="form-control span1" name="staff_code" placeholder="工号"<?=$filters['staff_code']?' value="'.$filters['staff_code'].'"':''?>>
                                <input type="text" class="form-control span1 form_datetime3" style="width: 100px;" name="month" placeholder="2000-01-01"<?=$filters['month']?' value="'.$filters['month'].'"':''?>>
                                <input type="submit" class="form-control btn btn-success" style="margin-bottom: 10px;" value="搜索">
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
                                    <th>ID</th>
                                    <th>员工工号</th>
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
                                    <td class="center"><?=$row['staff_code']?></td>
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
                    <div class="dataTables_paginate" style="padding-bottom: 5px;">
                        <button class="pull-left" style="margin-left: 10px;">总计：<?=$total?>个</button>
                        <button class="pull-left" style="margin-left: 10px;" id="set_page_size">每页<?=$filters['page_size']?>行（点击修改）</button>
                        <span> 
                            <?php if($filters['page']>=3): ?>
                            <a tabindex="0" class="first fg-button ui-button ui-state-default" href="<?=$query_str.'page=1'?>">第一页</a>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']-2)?>"><?=$filters['page']-2?></a>
                            <?php endif;?>
                            <?php if($filters['page']>=2): ?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']-1)?>"><?=$filters['page']-1?></a>
                            <?php endif;?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default ui-state-disabled"><?=$filters['page']?></a>
                            <?php if($total/$filters['page_size']>=$filters['page']+0): ?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']+1)?>"><?=$filters['page']+1?></a>
                            <?php endif;?>
                            <?php if($total/$filters['page_size']>=$filters['page']+1): ?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']+2)?>"><?=$filters['page']+2?></a>
                            <?php endif;?>
                        </span>
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
                    <label class="control-label">工号 :</label>
                    <div class="controls">
                        <input type="text" id="staff_code" name="staff_code" placeholder="工号" />
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
<div class="modal fade" id="page_zise_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">请设置每页行数 :</label>
                    <div class="controls">
                        <input type="text" id="page_size" name="page_size" placeholder="每页行数" />
                    </div>
                </div>
                <div class="form-actions">
                    <a class="btn btn-success" id="save_page_zise" style="float: right;">保存</a>
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
    $('#schedule_edit_form').find('#staff_code').val('');
    $('#schedule_edit_form').find('#start_date').val('');
    $('#schedule_edit_form').find('#end_date').val('');
    $('#schedule_edit_form').find('#start_time').val('');
    $('#schedule_edit_form').find('#is_enable').val(1);
    $('#schedule_edit_form').modal('show');
})
$('.edit_rule').on('click', function(){
    var rule_id = $(this).val();
    $.ajax({ 
        url: "/checkin/setsche/onestaff",
        data: {"rule_id":rule_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#schedule_edit_form').find('h5').text('修改');
                $('#schedule_edit_form').find('#rule_id').val(result.data.id);
                $('#schedule_edit_form').find('#staff_code').val(result.data.staff_code);
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
})

$('#set_page_size').on('click', function(){
    $('#page_zise_form').modal('show');
})
$('#save_page_zise').on('click', function(){
    $.ajax({ 
        url: "/privilege/privilege/pagesize",
        data: {"page_size":$("#page_size").val()},
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
$(".form_datetime3").datetimepicker({
    format: 'yyyy-mm',    
    todayBtn:  1,
    autoclose: 1,
    startView: 4,
    minView: 3
});
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>