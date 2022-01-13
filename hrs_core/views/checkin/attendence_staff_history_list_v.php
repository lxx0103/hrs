<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <form id="form_search" name="search_form" action>
                                <select name="department" class="span2">
                                    <option value="">请选择部门</option>
                                    <?php
                                        for ($i=0; $i < count($depts); $i++) { 
                                            var_dump($depts);
                                            echo '<option value="';
                                            echo $depts[$i]['department'];
                                            echo '"';
                                            if($depts[$i]['department'] == $filters['department'])
                                            {
                                                echo ' selected';
                                            }
                                            echo '>';
                                            echo $depts[$i]['department'];
                                            echo '</option>';
                                        }
                                    ?>
                                </select>
                                <input type="text" class="form-control span1" name="staff_code" placeholder="工号"<?=$filters['staff_code']?' value="'.$filters['staff_code'].'"':''?>>
                                <input type="text" class="form-control span2 form_datetime" name="month" placeholder="月份"<?=$filters['month']?' value="'.$filters['month'].'"':''?>>
                                <input type="submit" class="form-control btn btn-success" style="margin-bottom: 10px;" value="搜索" id="search_btn">
                                <input type="button" class="form-control btn btn-warning" style="margin-bottom: 10px;" value="导出" id="expdata">
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
                                    <th>部门</th>
                                    <th>姓名</th>
                                    <th>工号</th>
                                    <th>出勤天数</th>
                                    <th>应上班时间</th>
                                    <th>正班时间</th>
                                    <th>加班时间</th>
                                    <th>缺勤时间</th>
                                    <th>请假时间</th>
                                    <th>放假时间</th>
                                    <th>旷工时间</th>
                                    <th>迟到时间</th>
                                    <th>第一次迟到</th>
                                    <!-- <th>第二类迟到</th> -->
                                    <th>其他迟到</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($staff as $row):?>
                                <tr>
                                    <td class="center"><?=$row['department']?></td>
                                    <td class="center"><?=$row['name']?></td>
                                    <td class="center"><?=$row['staff_code']?></td>
                                    <td class="center"><?=$row['work_day']?></td>
                                    <td class="center"><?=$row['legal_work_time']?></td>
                                    <td class="center"><?=$row['work_time']?></td>
                                    <td class="center"><?=$row['over_time']?></td>
                                    <td class="center"><?=$row['off_time']?></td>
                                    <td class="center"><?=$row['leave_time']?></td>
                                    <td class="center"><?=$row['holiday_time']?></td>
                                    <td class="center"><?=$row['error_time']?></td>
                                    <td class="center"><?=$row['late_time']?></td>
                                    <td class="center"><?=$row['first_late']?></td>
                                    <td class="center"><?=$row['other_late']?></td>
                                    <td class="center">
                                        <a class="btn btn-success" href="/checkin/attendence/detailhistory?staff_code=<?=$row['staff_code']?>&month=<?=$filters['month']?>">明细</button>
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
                            <?php if($total/$filters['page_size']>=$filters['page']): ?>
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
    format: 'yyyy-mm',    
    todayBtn:  1,
    autoclose: 1,
    startView: 4,
    minView: 3
});

$("#expdata").on("click", function(){
    $('#form_search').attr("action", "/checkin/attendence/exphistory");
    $('#form_search').submit();
})

$("#search_btn").on("click", function(){
    $('#form_search').attr("action", "/checkin/attendence/staffhistory");
    $('#form_search').submit();
})
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>