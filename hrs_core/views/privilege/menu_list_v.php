<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>菜单名称</th>
                                    <th>目录</th>
                                    <th>控制器</th>
                                    <th>方法</th>
                                    <th>是否隐藏</th>
                                    <th>是否启用</th>
                                    <th>更新时间</th>
                                    <th>更新人</th>
                                    <th>操作</th>
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
                                    <td class="center"><?=$row['update_time']?></td>
                                    <td class="center"><?=$row['update_user']?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_menu" value="<?=$row['id']?>">编辑</button>
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
                                    <td class="center"><?=$child['update_time']?></td>
                                    <td class="center"><?=$child['update_user']?></td>
                                    <td class="center">
                                        <button class="btn btn-warning edit_menu" value="<?=$child['id']?>">编辑</button>
                                    </td>
                                </tr>
                                <?php endforeach?>
                                <?php endif?>
                                <?php endforeach?>
                                <tr>
                                    <td class="center" colspan="9"></td>
                                    <td class="center">
                                        <button class="btn btn-success add_menu">新增</button>
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

<div class="modal fade" id="menu_edit_form" tabindex="-1" role="dialog" style="top: 10%; display: none;">
    <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
            <h5></h5>
        </div>
        <div class="widget-content nopadding">
            <form action="#" method="get" class="form-horizontal">
                <div class="control-group">
                    <label class="control-label">菜单名称 :</label>
                    <div class="controls">
                        <input type="text" id="name" name="name"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">目录 :</label>
                    <div class="controls">
                        <input type="text" id="dir" name="dir"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">控制器 :</label>
                    <div class="controls">
                        <input type="text" id="controller" name="controller"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">方法 :</label>
                    <div class="controls">
                        <input type="text" id="method" name="method"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">父级菜单 :</label>
                    <div class="controls">
                        <select name="parent_id" id="parent_id" class="form-control">
                            <option value="0">顶级菜单</option>
                            <?php foreach($all_menus as $one_menu):?>
                            <option value="<?=$one_menu['id']?>"><?=$one_menu['name']?></option>
                            <?php endforeach?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">是否隐藏 :</label>
                    <div class="controls">
                        <select name="is_hidden" id="is_hidden" class="form-control">
                            <option value="1">是</option>
                            <option value="0">否</option>
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
                <input type="hidden" name="menu_id" id="menu_id" value="">
                <div class="form-actions">
                    <a class="btn btn-success" id="save_menu" style="float: right;">保存</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('.add_menu').on('click', function(){
    $('#menu_edit_form').find('h5').text('新增菜单');
    $('#menu_edit_form').find('#menu_id').val(0);
    $('#menu_edit_form').find('#name').val('');
    $('#menu_edit_form').find('#dir').val('');
    $('#menu_edit_form').find('#controller').val('');
    $('#menu_edit_form').find('#method').val('');
    $('#menu_edit_form').find('#parent_id').val(0);
    $('#menu_edit_form').find('#is_hidden').val(1);
    $('#menu_edit_form').find('#is_enable').val(1);
    $('#menu_edit_form').modal('show');
})
$('.edit_menu').on('click', function(){
    var menu_id = $(this).val();
    $.ajax({ 
        url: "/privilege/menu/one",
        data: {"menu_id":menu_id},
        dataType: 'json',
        type: 'POST',
        success: function(result){
            if(result.status == 1){
                $('#menu_edit_form').find('h5').text('修改菜单');
                $('#menu_edit_form').find('#menu_id').val(result.data.id);
                $('#menu_edit_form').find('#name').val(result.data.name);
                $('#menu_edit_form').find('#dir').val(result.data.dir);
                $('#menu_edit_form').find('#controller').val(result.data.controller);
                $('#menu_edit_form').find('#method').val(result.data.method);
                $('#menu_edit_form').find('#parent_id').val(result.data.parent_id);
                $('#menu_edit_form').find('#is_hidden').val(result.data.is_hidden);
                $('#menu_edit_form').find('#is_enable').val(result.data.is_enable);
                $('#menu_edit_form').modal('show');
            }else{
                layer.alert(result.msg);
            }
        }
    });
})
$('#save_menu').on('click', function(){
    $.ajax({ 
        url: "/privilege/menu/save",
        data: {"name":$("#name").val(), "dir":$("#dir").val(), "controller":$("#controller").val(), "method":$("#method").val(), 'parent_id':$('#parent_id').val(), "is_hidden":$("#is_hidden").val(), "is_enable":$("#is_enable").val(), "menu_id":$("#menu_id").val()},
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
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>