<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <form>
                                <input type="text" class="form-control span1" name="staff_code" placeholder="工号"<?=$filters['staff_code']?' value="'.$filters['staff_code'].'"':''?>>
                                <input type="text" class="form-control span1 form_datetime2" name="month" placeholder="月份"<?=$filters['month']?' value="'.$filters['month'].'"':''?>>  
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
                                    <th>工号</th>
                                    <th>日期</th>
                                    <th>是否启用</th>
                                    <th>更新时间</th>
                                    <th>更新人</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dutys as $row):?>
                                <tr>
                                    <td class="center"><?=$row['id']?></td>
                                    <td class="center"><?=$row['staff_code']?></td>
                                    <td class="center"><?=$row['duty']?></td>
                                    <td class="center"><?=$row['is_enable']==1?'是':'否'?></td>
                                    <td class="center"><?=$row['update_time']?></td>
                                    <td class="center"><?=$row['update_user']?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_duty" value="<?=$row['id']?>">编辑</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <tr>
                                    <td class="center" colspan="6"></td>
                                    <td class="center">
                                        <button class="btn btn-success add_duty">新增</button>
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
                            <?php if($total/$filters['page_size']>=$filters['page']+1): ?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']+1)?>"><?=$filters['page']+1?></a>
                            <?php endif;?>
                            <?php if($total/$filters['page_size']>=$filters['page']+2): ?>
                            <a tabindex="0" class="fg-button ui-button ui-state-default" href="<?=$query_str.'page='.($filters['page']+2)?>"><?=$filters['page']+2?></a>
                            <?php endif;?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="duty_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
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
                    <label class="control-label">日期 :</label>
                    <div class="controls">
                        <input type="text" id="duty" name="duty" class="form_datetime" />
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
                <input type="hidden" name="duty_id" id="duty_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_duty" style="float: right;">保存</a>
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
$('.add_duty').on('click', function(){
    $('#duty_edit_form').find('h5').text('新增');
    $('#duty_edit_form').find('#duty_id').val(0);
    $('#duty_edit_form').find('#staff_code').val('');
    $('#duty_edit_form').find('#duty').val('');
    $('#duty_edit_form').find('#is_enable').val(1);
    $('#duty_edit_form').modal('show');
})
$('.edit_duty').on('click', function(){
    var duty_id = $(this).val();
    $.ajax({ 
        url: "/checkin/duty/one",
        data: {"duty_id":duty_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#duty_edit_form').find('h5').text('修改');
                $('#duty_edit_form').find('#duty_id').val(result.data.id);
                $('#duty_edit_form').find('#staff_code').val(result.data.staff_code);
                $('#duty_edit_form').find('#duty').val(result.data.duty);
                $('#duty_edit_form').find('#is_enable').val(result.data.is_enable);
                $('#duty_edit_form').modal('show');
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#save_duty').on('click', function(){
    $.ajax({ 
        url: "/checkin/duty/save",
        data: {"staff_code":$("#staff_code").val(), "duty":$("#duty").val(), "is_enable":$("#is_enable").val(), "duty_id":$("#duty_id").val()},
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
$(".form_datetime").datetimepicker({
    format: 'yyyy-mm-dd',    
    todayBtn:  1,
    autoclose: 1,
    startView: 4,
    minView: 2
});
$(".form_datetime2").datetimepicker({
    format: 'yyyy-mm',    
    todayBtn:  1,
    autoclose: 1,
    startView: 4,
    minView: 3
});
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>