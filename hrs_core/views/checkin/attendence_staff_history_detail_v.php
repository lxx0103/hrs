<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <a class="btn btn-warning" href="/checkin/attendence/exphistorydetail?month=<?=$_GET['month']?>&staff_code=<?=$_GET['staff_code']?>">导出</a>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($staff as $key =>$value):?>
                                <tr>
                                    <td class="center"><?=$value['name']?></td>
                                    <td class="center"><?=$value['department']?></td>
                                    <td class="center"><?=$value['staff_code']?></td>
                                    <td class="center"><?=$key?></td>
                                    <td class="center"><?=$value['work_day']?>天</td>
                                    <td class="center"><?=$value['check_count']?></td>
                                    <td class="center"><?=str_replace(',', '<br />', $value['check_in'])?></td>
                                    <td class="center"><?=$value['legal_work_time']?>小时</td>
                                    <td class="center"><?=$value['work_time']?>小时</td>
                                    <td class="center"><?=$value['over_time']?>小时</td>
                                    <td class="center"><?=$value['off_time']?>小时</td>
                                    <td class="center"><?=$value['leave_time']?>小时</td>
                                    <td class="center"><?=$value['holiday_time']?>小时</td>
                                    <td class="center"><?=$value['error_time']?>小时</td>
                                    <td class="center"><?=$value['late_time']?>分钟</td>
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
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>

</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>