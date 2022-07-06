<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <form>
                                <select name="dept_id" class="span2">
                                    <option value="0">请选择部门</option>
                                    <?php foreach($depts as $dept):?>
                                    <option value="<?=$dept['id']?>"<?=$dept['id']==$filters['dept_id']?' selected':''?>><?=$dept['dept_name']?></option>
                                    <?php endforeach?>
                                </select>
                                <input type="text" class="form-control span1" name="name" placeholder="姓名"<?=$filters['name']?' value="'.$filters['name'].'"':''?>>
                                <input type="text" class="form-control span1" name="staff_code" placeholder="工号"<?=$filters['staff_code']?' value="'.$filters['staff_code'].'"':''?>>
                                <select name="is_working" class="span2">
                                    <option value="0">在职离职</option>
                                    <option value="1"<?=$filters['is_working']==1?' selected':''?>>在职</option>
                                    <option value="2"<?=$filters['is_working']==2?' selected':''?>>离职</option>
                                </select>
                                <input type="submit" class="form-control btn btn-success" style="margin-bottom: 10px;" value="搜索">
                            </form>
                            <form action="/organization/staff/uploadstaff" enctype="multipart/form-data" method="post">
                                <input type="file" name="staff_xls" id="staff_xls" style="display: none;">
                                <input type="text" id="btn_1" class="form-control input-large" style="margin-bottom: 10px;">
                                <a class="form-control btn" onclick="$('input[id=staff_xls]').click();" style="margin-bottom: 10px;">浏览</a>
                                <input type="submit" class="form-control btn btn-success" style="margin-bottom: 10px;" value="上传">
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
                                    <th>考勤机ID</th>
                                    <th>工号</th>
                                    <th>姓名</th>
                                    <th>部门</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <th>联系电话</th>
                                    <th>地址</th>
                                    <th>入职时间</th>
                                    <th>离职时间</th>
                                    <th>每月应出勤</th>
                                    <th>是否启用</th>
                                    <th><a class="btn btn-success" href="/organization/staff/edit">新增员工</a></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($staff as $row):?>
                                <tr>
                                    <td class="center"><?=$row['id']?></td>
                                    <td class="center"><?=$row['machine_id']?></td>
                                    <td class="center"><?=$row['staff_code']?></td>
                                    <td class="center"><?=$row['name']?></td>
                                    <td class="center"><?=$sorted_depts[$row['dept_id']]['dept_name']?></td>
                                    <td class="center"><?=$row['gender']==1?'男':'女'?></td>
                                    <td class="center"><?=$row['birthday']?></td>
                                    <td class="center"><?=$row['phone']?></td>
                                    <td class="center"><?=$row['address']?></td>
                                    <td class="center"><?=$row['in_date']?></td>
                                    <td class="center"><?=$row['out_date']?></td>
                                    <td class="center"><?=$row['legal_work_hour']?></td>
                                    <td class="center"><?=$row['is_enable']==1?'是':'否'?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_out_date" value="<?=$row['id']?>">离职</button>
                                        <a class="btn btn-warning" href="/organization/staff/edit?staff_code=<?=$row['staff_code']?>">编辑</a>
                                    </td>
                                </tr>
                                <?php endforeach?>
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

<div class="modal fade" id="staff_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">离职时间 :</label>
                    <div class="controls">
                        <input type="text" id="out_date" name="out_date" class="datepicker" placeholder="离职时间" />
                    </div>
                </div>
                <input type="hidden" name="staff_id" id="staff_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_out_date" style="float: right;">保存</a>
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
$('.edit_out_date').on('click', function(){
    var staff_id = $(this).val();
    $.ajax({ 
        url: "/organization/staff/one",
        data: {"staff_id":staff_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#staff_edit_form').find('h5').text('修改');
                $('#staff_edit_form').find('#staff_id').val(result.data.id);
                $('#staff_edit_form').find('#out_date').val(result.data.out_date);
                $('#staff_edit_form').modal('show');
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#save_out_date').on('click', function(){
    $.ajax({ 
        url: "/organization/staff/save",
        data: {"out_date":$("#out_date").val(), "staff_id":$("#staff_id").val()},
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
$('.datepicker').datepicker({
     format: 'yyyy-mm-dd',
});
$('input[id=staff_xls]').change(function(){
    $('#btn_1').val($(this).val());
})
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>