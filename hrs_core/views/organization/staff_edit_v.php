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
                                        <label class="form-inline" />职位状态:                                         
                                            <input type="text" class="form-control " name="zhiweizhuangtai" id="zhiweizhuangtai"  value="<?=$staff['zhiweizhuangtai']?>">
                                        </label>
                                        <label class="form-inline" />证件号码:
                                            <input type="text" class="form-control " name="identification" id="identification"  value="<?=$staff['identification']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />手机号码:                                         
                                            <input type="text" class="form-control " name="mobile" id="mobile"  value="<?=$staff['mobile']?>">
                                        </label>
                                        <label class="form-inline" />类别:                                         
                                            <input type="text" class="form-control " name="leibie" id="leibie"  value="<?=$staff['leibie']?>">
                                        </label>
                                        <label class="form-inline" />临时工工价/时:                                         
                                            <input type="text" class="form-control " name="linshigonggongjia" id="linshigonggongjia"  value="<?=$staff['linshigonggongjia']?>">
                                        </label>
                                        <label class="form-inline" />所属公司:
                                            <input type="text" class="form-control " name="suoshugongsi" id="suoshugongsi"  value="<?=$staff['suoshugongsi']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />购买社保档次:                                         
                                            <input type="text" class="form-control " name="goumaishebaodangci" id="goumaishebaodangci"  value="<?=$staff['goumaishebaodangci']?>">
                                        </label>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date"  value="<?=$staff['in_date']?>">
                                        </label>
                                        <label class="form-inline" />是否二次入职:                                         
                                            <input type="text" class="form-control " name="shifouerciruzhi" id="shifouerciruzhi"  value="<?=$staff['shifouerciruzhi']?>">
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date"  value="<?=$staff['out_date']?>">
                                        </label>
                                        <label class="form-inline" />是否自离:
                                            <input type="text" class="form-control " name="shifouzili" id="shifouzili"  value="<?=$staff['shifouzili']?>">
                                        </label>
                                        <label class="form-inline" />本期工资是否已结算:
                                            <input type="text" class="form-control " name="gongziyijiesuan" id="gongziyijiesuan"  value="<?=$staff['gongziyijiesuan']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />线别:                                         
                                            <input type="text" class="form-control " name="xianbie" id="xianbie" value="<?=$staff['xianbie']?>" readonly>
                                        </label>
                                        <label class="form-inline" />部门:                                         
                                            <select name="dept_id" id="dept_id">
                                                <option value="0">请选择部门</option>
                                                <?php foreach($depts as $dept):?>
                                                <option value="<?=$dept['id']?>"<?=$dept['id']==$staff['dept_id']?' selected':''?>><?=$dept['dept_name']?></option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                        <label class="form-inline" />岗位:                                         
                                            <input type="text" class="form-control " name="gangwei" id="gangwei"  value="<?=$staff['gangwei']?>">
                                        </label>
                                        <label class="form-inline" />所属楼层: 
                                            <input type="text" class="form-control " name="floor" id="floor"  value="<?=$staff['floor']?>" readonly>
                                        </label>
                                        <label class="form-inline" />人工类别:                                         
                                            <input type="text" class="form-control" name="rengongleibie" id="rengongleibie" value="<?=$staff['rengongleibie']?>" readonly>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />每月应出勤小时: 
                                            <input type="text" class="form-control" name="legal_work_hour" id="legal_work_hour" value="<?=$staff['legal_work_hour']?>" >
                                        </label>
                                        <label class="form-inline" />加班费标准: 
                                            <input type="text" class="form-control" name="jiabanfeibiaozhun" id="jiabanfeibiaozhun"  value="<?=$staff['jiabanfeibiaozhun']?>">
                                        </label>
                                        <label class="form-inline" />是否学徒:                                         
                                            <input type="text" class="form-control" name="shifouxuetu" id="shifouxuetu"  value="<?=$staff['shifouxuetu']?>">
                                        </label>
                                        <label class="form-inline" />介绍人:
                                            <input type="text" class="form-control " name="jieshaoren" id="jieshaoren"  value="<?=$staff['jieshaoren']?>">
                                        </label>
                                        <label class="form-inline" />性质保底:
                                            <input type="text" class="form-control " name="xinzhibaodi" id="xinzhibaodi"  value="<?=$staff['xinzhibaodi']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否免扣伙食费: 
                                            <input type="text" class="form-control" name="miankouhuoshifei" id="miankouhuoshifei" value="<?=$staff['miankouhuoshifei']?>" >
                                        </label>
                                        <label class="form-inline" />工资归属费用: 
                                            <input type="text" class="form-control" name="gongziguishufeiyong" id="gongziguishufeiyong"   value="<?=$staff['gongziguishufeiyong']?>" readonly>
                                        </label>
                                        <label class="form-inline" />出生日期:                                         
                                            <input type="text" class="form-control" name="birthday" id="birthday"  value="<?=$staff['birthday']?>" readonly>
                                        </label>
                                        <label class="form-inline" />出生月份:
                                            <input type="text" class="form-control" name="chushengyuefen" id="chushengyuefen"  value="<?=substr($staff['birthday'], 5, 2)?>" readonly>
                                        </label>
                                        <label class="form-inline" />工龄:
                                            <input type="text" class="form-control " name="gongling" id="gongling"  value="<?=floor((time() - strtotime($staff['in_date']))/60/60/24/30)?>" readonly>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />婚否: 
                                            <input type="text" class="form-control " name="marrige" id="marrige"  value="<?=$staff['marrige']?>">
                                        </label>
                                        <label class="form-inline" />年龄:
                                            <input type="text" class="form-control " name="gongling" id="gongling"  value="<?=floor((time() - strtotime($staff['birthday']))/60/60/24/365)?>" readonly>
                                        </label>
                                        <label class="form-inline" />性别:               
                                            <input type="text" class="form-control " name="gender" id="gender"  value="<?=$staff['gender']==1?'男':'女'?>" readonly>
                                        </label>
                                        <label class="form-inline" />是否党员:                                         
                                            <input type="text" class="form-control" name="shifoudangyuan" id="shifoudangyuan"  value="<?=$staff['shifoudangyuan']?>">
                                        </label>
                                        <label class="form-inline" />社保号:                                         
                                            <input type="text" class="form-control" name="shebaohao" id="shebaohao"  value="<?=$staff['shebaohao']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />教育程度:                                         
                                            <input type="text" class="form-control " name="education" id="education"  value="<?=$staff['education']?>">
                                        </label>
                                        <label class="form-inline" />籍贯:                                         
                                            <input type="text" class="form-control " name="hometown" id="hometown"  value="<?=$staff['hometown']?>">
                                        </label>
                                        <label class="form-inline" />民族: 
                                            <input type="text" class="form-control " name="ethnicity" id="ethnicity"  value="<?=$staff['ethnicity']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />身份证地址:                                         
                                            <input type="text" class="form-control " name="shenfenzhengdizhi" id="shenfenzhengdizhi"  value="<?=$staff['shenfenzhengdizhi']?>">
                                        </label>
                                        <label class="form-inline" />地址:                                         
                                            <input type="text" class="form-control " name="address" id="address"  value="<?=$staff['address']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />宿舍号:                                         
                                            <input type="text" class="form-control " name="room" id="room"  value="<?=$staff['room']?>">
                                        </label>
                                        <label class="form-inline" />工具箱号:                                         
                                            <input type="text" class="form-control " name="gongjuxianghao" id="gongjuxianghao"  value="<?=$staff['gongjuxianghao']?>">
                                        </label>
                                        <label class="form-inline" />是否能带手机:                                         
                                            <input type="text" class="form-control " name="daishouji" id="daishouji"  value="<?=$staff['daishouji']?>">
                                        </label>
                                        <label class="form-inline" />是否能吸烟:                                         
                                            <input type="text" class="form-control " name="chouyan" id="chouyan"  value="<?=$staff['chouyan']?>">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否签订合同: 
                                            <input type="text" class="form-control " name="shifouqiandinghetong" id="shifouqiandinghetong"  value="<?=$staff['shifouqiandinghetong']?>">
                                        </label>
                                        <label class="form-inline" />合同编号: 
                                            <input type="text" class="form-control " name="hetongbianhao" id="hetongbianhao"  value="<?=$staff['hetongbianhao']?>">
                                        </label>
                                        <label class="form-inline" />合同签订日: 
                                            <input type="text" class="form-control form_datetime" name="contract_from" id="contract_from"  value="<?=$staff['contract_from']?>">
                                        </label>
                                        <label class="form-inline" />合同期限: 
                                            <input type="text" class="form-control" name="hetongqixian" id="hetongqixian"  value="<?=$staff['hetongqixian']?>">
                                        </label>
                                        <label class="form-inline" />合同终止日:                                         
                                            <input type="text" class="form-control" name="contract_to" id="contract_to"  value="<?=date('Y-m-d', strtotime("+".$staff['hetongqixian']." months", strtotime($staff['contract_from'])))?>" readonly>
                                        </label>
                                        <label class="form-inline" />合同倒计时:                                         
                                            <input type="text" class="form-control" name="count_down" id="count_down"  value="<?=floor((strtotime("+".$staff['hetongqixian']." months", strtotime($staff['contract_from']))-time())/60/60/24)?>" readonly>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />转正日期: 
                                            <input type="text" class="form-control form_datetime" name="zhuanzhengriqi" id="zhuanzhengriqi"  value="<?=$staff['zhuanzhengriqi']?>">
                                        </label>
                                        <label class="form-inline" />试用期工资: 
                                            <input type="text" class="form-control" name="shiyongqigongzi" id="shiyongqigongzi"  value="<?=$staff['shiyongqigongzi']?>">
                                        </label>
                                        <label class="form-inline" />转正工资: 
                                            <input type="text" class="form-control" name="zhuanzhenggongzi" id="zhuanzhenggongzi"  value="<?=$staff['zhuanzhenggongzi']?>">
                                        </label>
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
                                        <label class="form-inline" />银行卡号:                                         
                                            <input type="text" class="form-control" name="yinhangkahao" id="yinhangkahao"  value="<?=$staff['yinhangkahao']?>">
                                        </label>
                                        <label class="form-inline" />开户行:                                         
                                            <input type="text" class="form-control " name="kaihuhang" id="kaihuhang"  value="<?=$staff['kaihuhang']?>">
                                        </label>
                                        <label class="form-inline" />支行:                                         
                                            <input type="text" class="form-control " name="zhihang" id="zhihang"  value="<?=$staff['zhihang']?>">
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
                                            <input type="text" class="form-control " name="staff_code" id="staff_code">
                                        </label>
                                        <label class="form-inline" />姓名:                                         
                                            <input type="text" class="form-control " name="name" id="name">
                                        </label>
                                        <label class="form-inline" />职位状态:                                         
                                            <input type="text" class="form-control " name="zhiweizhuangtai" id="zhiweizhuangtai">
                                        </label>
                                        <label class="form-inline" />证件号码:
                                            <input type="text" class="form-control " name="identification" id="identification">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />手机号码:                                         
                                            <input type="text" class="form-control " name="mobile" id="mobile">
                                        </label>
                                        <label class="form-inline" />类别:                                         
                                            <input type="text" class="form-control " name="leibie" id="leibie">
                                        </label>
                                        <label class="form-inline" />临时工工价/时:                                         
                                            <input type="text" class="form-control " name="linshigonggongjia" id="linshigonggongjia">
                                        </label>
                                        <label class="form-inline" />所属公司:
                                            <input type="text" class="form-control " name="suoshugongsi" id="suoshugongsi">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />购买社保档次:                                         
                                            <input type="text" class="form-control " name="goumaishebaodangci" id="goumaishebaodangci">
                                        </label>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date">
                                        </label>
                                        <label class="form-inline" />是否二次入职:                                         
                                            <input type="text" class="form-control " name="shifouerciruzhi" id="shifouerciruzhi">
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date">
                                        </label>
                                        <label class="form-inline" />是否自离:
                                            <input type="text" class="form-control " name="shifouzili" id="shifouzili">
                                        </label>
                                        <label class="form-inline" />本期工资是否已结算:
                                            <input type="text" class="form-control " name="gongziyijiesuan" id="gongziyijiesuan">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />部门:                                         
                                            <select name="dept_id" id="dept_id">
                                                <option value="0">请选择部门</option>
                                                <?php foreach($depts as $dept):?>
                                                <option value="<?=$dept['id']?>"><?=$dept['dept_name']?></option>
                                                <?php endforeach?>
                                            </select>
                                        </label>
                                        <label class="form-inline" />岗位:                                         
                                            <input type="text" class="form-control " name="gangwei" id="gangwei">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />每月应出勤小时: 
                                            <input type="text" class="form-control" name="legal_work_hour" id="legal_work_hour">
                                        </label>
                                        <label class="form-inline" />加班费标准: 
                                            <input type="text" class="form-control" name="jiabanfeibiaozhun" id="jiabanfeibiaozhun">
                                        </label>
                                        <label class="form-inline" />是否学徒:                                         
                                            <input type="text" class="form-control" name="shifouxuetu" id="shifouxuetu">
                                        </label>
                                        <label class="form-inline" />介绍人:
                                            <input type="text" class="form-control " name="jieshaoren" id="jieshaoren">
                                        </label>
                                        <label class="form-inline" />性质保底:
                                            <input type="text" class="form-control " name="xinzhibaodi" id="xinzhibaodi">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否免扣伙食费: 
                                            <input type="text" class="form-control" name="miankouhuoshifei" id="miankouhuoshifei">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />婚否: 
                                            <input type="text" class="form-control " name="marrige" id="marrige">
                                        </label>
                                        <label class="form-inline" />是否党员:                                         
                                            <input type="text" class="form-control" name="shifoudangyuan" id="shifoudangyuan">
                                        </label>
                                        <label class="form-inline" />社保号:                                         
                                            <input type="text" class="form-control" name="shebaohao" id="shebaohao">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />教育程度:                                         
                                            <input type="text" class="form-control " name="education" id="education">
                                        </label>
                                        <label class="form-inline" />籍贯:                                         
                                            <input type="text" class="form-control " name="hometown" id="hometown">
                                        </label>
                                        <label class="form-inline" />民族: 
                                            <input type="text" class="form-control " name="ethnicity" id="ethnicity">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />身份证地址:                                         
                                            <input type="text" class="form-control " name="shenfenzhengdizhi" id="shenfenzhengdizhi">
                                        </label>
                                        <label class="form-inline" />地址:                                         
                                            <input type="text" class="form-control " name="address" id="address">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />宿舍号:                                         
                                            <input type="text" class="form-control " name="room" id="room">
                                        </label>
                                        <label class="form-inline" />工具箱号:                                         
                                            <input type="text" class="form-control " name="gongjuxianghao" id="gongjuxianghao">
                                        </label>
                                        <label class="form-inline" />是否能带手机:                                         
                                            <input type="text" class="form-control " name="daishouji" id="daishouji">
                                        </label>
                                        <label class="form-inline" />是否能吸烟:                                         
                                            <input type="text" class="form-control " name="chouyan" id="chouyan">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否签订合同: 
                                            <input type="text" class="form-control " name="shifouqiandinghetong" id="shifouqiandinghetong">
                                        </label>
                                        <label class="form-inline" />合同编号: 
                                            <input type="text" class="form-control " name="hetongbianhao" id="hetongbianhao">
                                        </label>
                                        <label class="form-inline" />合同签订日: 
                                            <input type="text" class="form-control form_datetime" name="contract_from" id="contract_from">
                                        </label>
                                        <label class="form-inline" />合同期限: 
                                            <input type="text" class="form-control" name="hetongqixian" id="hetongqixian">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />转正日期: 
                                            <input type="text" class="form-control form_datetime" name="zhuanzhengriqi" id="zhuanzhengriqi">
                                        </label>
                                        <label class="form-inline" />试用期工资: 
                                            <input type="text" class="form-control" name="shiyongqigongzi" id="shiyongqigongzi">
                                        </label>
                                        <label class="form-inline" />转正工资: 
                                            <input type="text" class="form-control" name="zhuanzhenggongzi" id="zhuanzhenggongzi">
                                        </label>
                                        <label class="form-inline" />紧急联系人: 
                                            <input type="text" class="form-control " name="emergency" id="emergency">
                                        </label>
                                        <label class="form-inline" />紧急联系人电话:                                         
                                            <input type="text" class="form-control " name="emergency_phone" id="emergency_phone">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />银行卡号:                                         
                                            <input type="text" class="form-control" name="yinhangkahao" id="yinhangkahao">
                                        </label>
                                        <label class="form-inline" />开户行:                                         
                                            <input type="text" class="form-control " name="kaihuhang" id="kaihuhang">
                                        </label>
                                        <label class="form-inline" />支行:                                         
                                            <input type="text" class="form-control " name="zhihang" id="zhihang">
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
            'staff_code': $('#staff_code').val(),
            'name': $('#name').val(),
            'zhiweizhuangtai': $('#zhiweizhuangtai').val(),
            'identification': $('#identification').val(),
            'mobile': $('#mobile').val(),
            'leibie': $('#leibie').val(),
            'linshigonggongjia': $('#linshigonggongjia').val(),
            'suoshugongsi': $('#suoshugongsi').val(),
            'goumaishebaodangci': $('#goumaishebaodangci').val(),
            'in_date': $('#in_date').val(),
            'shifouerciruzhi': $('#shifouerciruzhi').val(),
            'out_date': $('#out_date').val(),
            'shifouzili': $('#shifouzili').val(),
            'gongziyijiesuan': $('#gongziyijiesuan').val(),
            'dept_id': $('#dept_id').val(),
            'gangwei': $('#gangwei').val(),
            'legal_work_hour': $('#legal_work_hour').val(),
            'jiabanfeibiaozhun': $('#jiabanfeibiaozhun').val(),
            'shifouxuetu': $('#shifouxuetu').val(),
            'jieshaoren': $('#jieshaoren').val(),
            'xinzhibaodi': $('#xinzhibaodi').val(),
            'miankouhuoshifei': $('#miankouhuoshifei').val(),
            'marrige': $('#marrige').val(),
            'shifoudangyuan': $('#shifoudangyuan').val(),
            'shebaohao': $('#shebaohao').val(),
            'education': $('#education').val(),
            'hometown': $('#hometown').val(),
            'ethnicity': $('#ethnicity').val(),
            'shenfenzhengdizhi': $('#shenfenzhengdizhi').val(),
            'address': $('#address').val(),
            'room': $('#room').val(),
            'gongjuxianghao': $('#gongjuxianghao').val(),
            'daishouji': $('#daishouji').val(),
            'chouyan': $('#chouyan').val(),
            'shifouqiandinghetong': $('#shifouqiandinghetong').val(),
            'hetongbianhao': $('#hetongbianhao').val(),
            'contract_from': $('#contract_from').val(),
            'hetongqixian': $('#hetongqixian').val(),
            'zhuanzhengriqi': $('#zhuanzhengriqi').val(),
            'shiyongqigongzi': $('#shiyongqigongzi').val(),
            'zhuanzhenggongzi': $('#zhuanzhenggongzi').val(),
            'emergency': $('#emergency').val(),
            'emergency_phone': $('#emergency_phone').val(),
            'yinhangkahao': $('#yinhangkahao').val(),
            'kaihuhang': $('#kaihuhang').val(),
            'zhihang': $('#zhihang').val(),
            'id': $('#staff_id').val(),
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