<?php require_once(VIEWPATH.'common/head_v.php');?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-content">
                        <div>
                            <?php if($act=='edit'): ?>                            
                            <form>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />工号: 
                                            <input type="text" class="form-control " name="staff_code" id="staff_code"  value="<?=$staff['staff_code']?>" readonly>
                                        </label>
                                        <label class="form-inline" />姓名:                                         
                                            <input type="text" class="form-control " name="name" id="name"  value="<?=$staff['name']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />性别:                         
                                            <select name="gender" id="gender">
                                                <option value="0">请选择性别</option>
                                                <option value="1"<?=$staff['gender']==1?' selected':''?>>男</option>
                                                <option value="2"<?=$staff['gender']==2?' selected':''?>>女</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />部门:                                         
                                            <select name="dept_id" id="dept_id">
                                                <option value="0">请选择部门</option>
                                                <?php foreach($depts as $dept):?>
                                                <option value="<?=$dept['id']?>"<?=$dept['id']==$staff['dept_id']?' selected':''?>><?=$dept['dept_name']?></option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />电话号码: 
                                            <input type="text" class="form-control " name="phone" id="phone"  value="<?=$staff['phone']?>">
                                        </label>
                                        <label class="form-inline" />手机号码:                                         
                                            <input type="text" class="form-control " name="mobile" id="mobile"  value="<?=$staff['mobile']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />生日: 
                                            <input type="text" class="form-control form_datetime" name="birthday" id="birthday"  value="<?=$staff['birthday']?>">
                                        </label>
                                        <label class="form-inline" />地址:                                         
                                            <input type="text" class="form-control " name="address" id="address"  value="<?=$staff['address']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date"  value="<?=$staff['in_date']?>">
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date"  value="<?=$staff['out_date']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />所属楼层: 
                                            <input type="text" class="form-control " name="floor" id="floor"  value="<?=$staff['floor']?>">
                                        </label>
                                        <label class="form-inline" />教育程度:                                         
                                            <input type="text" class="form-control " name="education" id="education"  value="<?=$staff['education']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />生日类型: 
                                            <input type="text" class="form-control " name="birthday_type" id="birthday_type"  value="<?=$staff['birthday_type']?>">
                                        </label>
                                        <label class="form-inline" />过生日日期:                                         
                                            <input type="text" class="form-control form_datetime" name="birthday_date" id="birthday_date"  value="<?=$staff['birthday_date']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />紧急联系人: 
                                            <input type="text" class="form-control " name="emergency" id="emergency"  value="<?=$staff['emergency']?>">
                                        </label>
                                        <label class="form-inline" />紧急联系人电话:                                         
                                            <input type="text" class="form-control " name="emergency_phone" id="emergency_phone"  value="<?=$staff['emergency_phone']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />身份证号: 
                                            <input type="text" class="form-control " name="identification" id="identification"  value="<?=$staff['identification']?>">
                                        </label>
                                        <label class="form-inline" />有效日期:                                         
                                            <input type="text" class="form-control" name="valid_date" id="valid_date"  value="<?=$staff['valid_date']?>">
                                        </label>
                                        <label class="form-inline" />发证部门:                                         
                                            <input type="text" class="form-control " name="id_by" id="id_by"  value="<?=$staff['id_by']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />账套: 
                                            <input type="text" class="form-control " name="salary_type" id="salary_type"  value="<?=$staff['salary_type']?>">
                                        </label>
                                        <label class="form-inline" />籍贯:                                         
                                            <input type="text" class="form-control " name="hometown" id="hometown"  value="<?=$staff['hometown']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />婚否: 
                                            <input type="text" class="form-control " name="marrige" id="marrige"  value="<?=$staff['marrige']?>">
                                        </label>
                                        <label class="form-inline" />工箱柜:                                         
                                            <input type="text" class="form-control " name="box" id="box"  value="<?=$staff['box']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />民族: 
                                            <input type="text" class="form-control " name="ethnicity" id="ethnicity"  value="<?=$staff['ethnicity']?>">
                                        </label>
                                        <label class="form-inline" />宿舍号:                                         
                                            <input type="text" class="form-control " name="room" id="room"  value="<?=$staff['room']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />合同签订日: 
                                            <input type="text" class="form-control form_datetime" name="contract_from" id="contract_from"  value="<?=$staff['contract_from']?>">
                                        </label>
                                        <label class="form-inline" />合同终止日:                                         
                                            <input type="text" class="form-control form_datetime" name="contract_to" id="contract_to"  value="<?=$staff['contract_to']?>">
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="staff_id" id="staff_id" value="<?=$staff['id']?>">
                                <input type="button" class="form-control btn btn-success" id="save_staff" style="margin-bottom: 10px;" value="保存">
                            </form>
                            <?php endif;?>
                            <?php if($act=='new'): ?>                            
                            <form>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />工号: 
                                            <input type="text" class="form-control " name="staff_code" id="staff_code"  >
                                        </label>
                                        <label class="form-inline" />姓名:                                         
                                            <input type="text" class="form-control " name="name" id="name" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />性别:                         
                                            <select name="gender" id="gender">
                                                <option value="0">请选择性别</option>
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />部门:                                         
                                            <select name="dept_id" id="dept_id">
                                                <option value="0">请选择部门</option>
                                                <?php foreach($depts as $dept):?>
                                                <option value="<?=$dept['id']?>"><?=$dept['dept_name']?></option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />电话号码: 
                                            <input type="text" class="form-control " name="phone" id="phone" >
                                        </label>
                                        <label class="form-inline" />手机号码:                                         
                                            <input type="text" class="form-control " name="mobile" id="mobile" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />生日: 
                                            <input type="text" class="form-control form_datetime" name="birthday" id="birthday" >
                                        </label>
                                        <label class="form-inline" />地址:                                         
                                            <input type="text" class="form-control " name="address" id="address" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date" >
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />所属楼层: 
                                            <input type="text" class="form-control " name="floor" id="floor" >
                                        </label>
                                        <label class="form-inline" />教育程度:                                         
                                            <input type="text" class="form-control " name="education" id="education" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />生日类型: 
                                            <input type="text" class="form-control " name="birthday_type" id="birthday_type" >
                                        </label>
                                        <label class="form-inline" />过生日日期:                                         
                                            <input type="text" class="form-control form_datetime" name="birthday_date" id="birthday_date" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />紧急联系人: 
                                            <input type="text" class="form-control " name="emergency" id="emergency" >
                                        </label>
                                        <label class="form-inline" />紧急联系人电话:                                         
                                            <input type="text" class="form-control " name="emergency_phone" id="emergency_phone" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />身份证号: 
                                            <input type="text" class="form-control " name="identification" id="identification" >
                                        </label>
                                        <label class="form-inline" />有效日期:                                         
                                            <input type="text" class="form-control" name="valid_date" id="valid_date" >
                                        </label>
                                        <label class="form-inline" />发证部门:                                         
                                            <input type="text" class="form-control " name="id_by" id="id_by" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />账套: 
                                            <input type="text" class="form-control " name="salary_type" id="salary_type" >
                                        </label>
                                        <label class="form-inline" />籍贯:                                         
                                            <input type="text" class="form-control " name="hometown" id="hometown" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />婚否: 
                                            <input type="text" class="form-control " name="marrige" id="marrige" >
                                        </label>
                                        <label class="form-inline" />工箱柜:                                         
                                            <input type="text" class="form-control " name="box" id="box" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />民族: 
                                            <input type="text" class="form-control " name="ethnicity" id="ethnicity" >
                                        </label>
                                        <label class="form-inline" />宿舍号:                                         
                                            <input type="text" class="form-control " name="room" id="room" >
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />合同签订日: 
                                            <input type="text" class="form-control form_datetime" name="contract_from" id="contract_from" >
                                        </label>
                                        <label class="form-inline" />合同终止日:                                         
                                            <input type="text" class="form-control form_datetime" name="contract_to" id="contract_to" >
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="staff_id" id="staff_id" value="0">
                                <input type="button" class="form-control btn btn-success" id="save_staff" style="margin-bottom: 10px;" value="保存">
                            </form>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once(VIEWPATH.'common/footer_v.php');?>

<script>
$('#save_staff').on('click', function(){
    console.log('save');
    $.ajax({ 
        url: "/organization/staff/savestaff",
        data: {
            'staff_code':$('#staff_code').val(),
            'name':$('#name').val(),
            'gender':$('#gender').val(),
            'dept_id':$('#dept_id').val(),
            'phone':$('#phone').val(),
            'mobile':$('#mobile').val(),
            'birthday':$('#birthday').val(),
            'address':$('#address').val(),
            'in_date':$('#in_date').val(),
            'out_date':$('#out_date').val(),
            'floor':$('#floor').val(),
            'education':$('#education').val(),
            'birthday_type':$('#birthday_type').val(),
            'birthday_date':$('#birthday_date').val(),
            'emergency':$('#emergency').val(),
            'emergency_phone':$('#emergency_phone').val(),
            'identification':$('#identification').val(),
            'valid_date':$('#valid_date').val(),
            'id_by':$('#id_by').val(),
            'salary_type':$('#salary_type').val(),
            'hometown':$('#hometown').val(),
            'marrige':$('#marrige').val(),
            'box':$('#box').val(),
            'ethnicity':$('#ethnicity').val(),
            'room':$('#room').val(),
            'contract_from':$('#contract_from').val(),
            'contract_to':$('#contract_to').val(),
            'id':$('#staff_id').val(),
            'type':'<?=$act?>',
        },
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
$('.form_datetime').datepicker({    
    format: 'yyyy-mm-dd',    
    todayBtn:  1,
    startView: 2,
    minView: 2
});
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>