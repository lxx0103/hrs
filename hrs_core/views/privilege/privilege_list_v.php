<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="center">ID</th>
                                    <th class="center">菜单名称</th>
                                    <th class="center">目录</th>
                                    <th class="center">控制器</th>
                                    <th class="center">方法</th>
                                    <th class="center">是否隐藏</th>
                                    <th class="center">是否启用</th>
                                    <th>
                                        <button class="btn btn-success" id="save_privilege">保存</button></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($all_menus as $row):?>
                                <tr style="background-color: #bbbbbb;">
                                    <td class="center"><?=$row['id']?></td>
                                    <td style="vertical-align: middle;"><?=$row['name']?></td>
                                    <td class="center"><?=$row['dir']?></td>
                                    <td class="center"><?=$row['controller']?></td>
                                    <td class="center"><?=$row['method']?></td>
                                    <td class="center"><?=$row['is_hidden']==1?'是':'否'?></td>
                                    <td class="center"><?=$row['is_enable']==1?'是':'否'?></td>
                                    <td class="center">
                                        <input type="checkbox" class="privilege" value="<?=$row['id']?>" <?=in_array($row['id'], $privileges)?' checked="checked"':''?> />
                                    </td>
                                </tr>
                                <?php if(isset($row['child'])):?>
                                <?php foreach($row['child'] as $child):?>                                    
                                <tr style="background-color: #ffffff">
                                    <td class="center"><?=$child['id']?></td>
                                    <td style="vertical-align: middle;"><i class="icon icon-chevron-right" style="margin-right: 10px;margin-left: 20px;"></i><?=$child['name']?></td>
                                    <td class="center"><?=$child['dir']?></td>
                                    <td class="center"><?=$child['controller']?></td>
                                    <td class="center"><?=$child['method']?></td>
                                    <td class="center"><?=$child['is_hidden']==1?'是':'否'?></td>
                                    <td class="center"><?=$child['is_enable']==1?'是':'否'?></td>
                                    <td class="center">
                                        <input type="checkbox" class="privilege" value="<?=$child['id']?>" <?=in_array($child['id'], $privileges)?' checked="checked"':''?> />
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <?php endif?>
                                <?php endforeach?>
                                <input type="hidden" id="role_id" value="<?=$role_id?>">
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
$('#save_privilege').on('click', function(){
    layer.confirm('确定保存权限吗？', function(index){
        layer.close(index);
        var checked_box = ',';
        $(".privilege").each(function() {  
            if ($(this).attr("checked")) {  
                checked_box += $(this).val()+',';  
            }  
        });  
        $.ajax({ 
            url: "/privilege/privilege/save",
            data: {"role_id":$("#role_id").val(), "menus":checked_box},
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
    });
    
})
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>