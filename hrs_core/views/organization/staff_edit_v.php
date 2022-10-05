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
                                            <select name="zhiweizhuangtai" id="zhiweizhuangtai">
                                                <option value=""<?=$staff['zhiweizhuangtai']==''?' selected':''?>>请选择职位状态</option>
                                                <option value="劳务工"<?=$staff['zhiweizhuangtai']=='劳务工'?' selected':''?>>劳务工</option>
                                                <option value="沈阳"<?=$staff['zhiweizhuangtai']=='沈阳'?' selected':''?>>沈阳</option>
                                                <option value="临时工在职"<?=$staff['zhiweizhuangtai']=='临时工在职'?' selected':''?>>临时工在职</option>
                                                <option value="临时工离职"<?=$staff['zhiweizhuangtai']=='临时工离职'?' selected':''?>>临时工离职</option>
                                                <option value="正式工在职"<?=$staff['zhiweizhuangtai']=='正式工在职'?' selected':''?>>正式工在职</option>
                                                <option value="正式工离职"<?=$staff['zhiweizhuangtai']=='正式工离职'?' selected':''?>>正式工离职</option>
                                            </select>
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
                                            <select name="leibie" id="leibie">
                                                <option value=""<?=$staff['leibie']==''?' selected':''?>>请选择类别</option>
                                                <option value="计件"<?=$staff['leibie']=='计件'?' selected':''?>>计件</option>
                                                <option value="计时"<?=$staff['leibie']=='计时'?' selected':''?>>计时</option>
                                                <option value="固定"<?=$staff['leibie']=='固定'?' selected':''?>>固定</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />临时工工价/时:                                         
                                            <input type="text" class="form-control " name="linshigonggongjia" id="linshigonggongjia"  value="<?=$staff['linshigonggongjia']?>">
                                        </label>
                                        <label class="form-inline" />所属公司:                                    
                                            <select name="suoshugongsi" id="suoshugongsi">
                                                <option value=""<?=$staff['suoshugongsi']==''?' selected':''?>>请选择所属公司</option>
                                                <option value="潮尊"<?=$staff['suoshugongsi']=='潮尊'?' selected':''?>>潮尊</option>
                                                <option value="潮品"<?=$staff['suoshugongsi']=='潮品'?' selected':''?>>潮品</option>
                                                <option value="诗可丽"<?=$staff['suoshugongsi']=='诗可丽'?' selected':''?>>诗可丽</option>
                                                <option value="潮宝"<?=$staff['suoshugongsi']=='潮宝'?' selected':''?>>潮宝</option>
                                                <option value="宝丽莎"<?=$staff['suoshugongsi']=='宝丽莎'?' selected':''?>>宝丽莎</option>
                                                <option value="潮小金"<?=$staff['suoshugongsi']=='潮小金'?' selected':''?>>潮小金</option>
                                                <option value="馨淼"<?=$staff['suoshugongsi']=='馨淼'?' selected':''?>>馨淼</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />购买社保档次:                                                                               
                                            <select name="goumaishebaodangci" id="goumaishebaodangci">
                                                <option value=""<?=$staff['goumaishebaodangci']==''?' selected':''?>>请选择购买社保档次</option>
                                                <option value="一档"<?=$staff['goumaishebaodangci']=='一档'?' selected':''?>>一档</option>
                                                <option value="二档"<?=$staff['goumaishebaodangci']=='二档'?' selected':''?>>二档</option>
                                                <option value="三档"<?=$staff['goumaishebaodangci']=='三档'?' selected':''?>>三档</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date"  value="<?=$staff['in_date']?>">
                                        </label>
                                        <label class="form-inline" />是否二次入职:                                                                                                   
                                            <select name="shifouerciruzhi" id="shifouerciruzhi">
                                                <option value=""<?=$staff['shifouerciruzhi']==''?' selected':''?>>请选择是否二次入职</option>
                                                <option value="是"<?=$staff['shifouerciruzhi']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['shifouerciruzhi']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date"  value="<?=$staff['out_date']?>">
                                        </label>
                                        <label class="form-inline" />是否自离:                                                                                       
                                            <select name="shifouzili" id="shifouzili">
                                                <option value=""<?=$staff['shifouzili']==''?' selected':''?>>请选择是否自离</option>
                                                <option value="是"<?=$staff['shifouzili']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['shifouzili']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />本期工资是否已结算:                                                                         
                                            <select name="gongziyijiesuan" id="gongziyijiesuan">
                                                <option value=""<?=$staff['gongziyijiesuan']==''?' selected':''?>>请选择本期工资是否已结算</option>
                                                <option value="是"<?=$staff['gongziyijiesuan']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['gongziyijiesuan']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />线别:                                         
                                            <input type="text" class="form-control " name="xianbie" id="xianbie"  value="<?=$staff['xianbie']?>" disabled="disable">
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
                                            <input type="text" class="form-control " name="floor" id="floor"  value="<?=$staff['floor']?>" disabled="disable">
                                        </label>
                                        <label class="form-inline" />人工类别:                                         
                                            <input type="text" class="form-control" name="rengongleibie" id="rengongleibie"  value="<?=$staff['rengongleibie']?>" disabled="disable">
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
                                            <select name="shifouxuetu" id="shifouxuetu">
                                                <option value=""<?=$staff['shifouxuetu']==''?' selected':''?>>请选择是否学徒</option>
                                                <option value="是"<?=$staff['shifouxuetu']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['shifouxuetu']=='否'?' selected':''?>>否</option>
                                            </select>
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
                                            <select name="miankouhuoshifei" id="miankouhuoshifei">
                                                <option value=""<?=$staff['miankouhuoshifei']==''?' selected':''?>>请选择是否免扣伙食费</option>
                                                <option value="是"<?=$staff['miankouhuoshifei']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['miankouhuoshifei']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />工资归属费用: 
                                            <input type="text" class="form-control" name="gongziguishufeiyong" id="gongziguishufeiyong"  value="<?=$staff['gongziguishufeiyong']?>" disabled="disable">
                                        </label>
                                        <label class="form-inline" />出生日期:                                         
                                            <input type="text" class="form-control" name="birthday" id="birthday"  value="<?=$staff['birthday']?>" disabled="disable">
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
                                            <select name="marrige" id="marrige">
                                                <option value=""<?=$staff['marrige']==''?' selected':''?>>请选择婚否</option>
                                                <option value="是"<?=$staff['marrige']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['marrige']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />年龄:
                                            <input type="text" class="form-control " name="age" id="age"  value="<?=floor((time() - strtotime($staff['birthday']))/60/60/24/365)?>" readonly>
                                        </label>
                                        <label class="form-inline" />性别:                         
                                            <select name="gender" id="gender" disabled="disable">
                                                <option value="0">请选择性别</option>
                                                <option value="1"<?=$staff['gender']==1?' selected':''?>>男</option>
                                                <option value="2"<?=$staff['gender']==2?' selected':''?>>女</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />是否党员:                                                                                                                               
                                            <select name="shifoudangyuan" id="shifoudangyuan">
                                                <option value=""<?=$staff['shifoudangyuan']==''?' selected':''?>>请选择是否党员</option>
                                                <option value="是"<?=$staff['shifoudangyuan']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['shifoudangyuan']=='否'?' selected':''?>>否</option>
                                            </select>
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
                                        <label class="form-inline" />居住地址:                                         
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
                                            <select name="daishouji" id="daishouji">
                                                <option value=""<?=$staff['daishouji']==''?' selected':''?>>请选择是否能带手机</option>
                                                <option value="是"<?=$staff['daishouji']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['daishouji']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />是否能吸烟:                                                                                                                                                                                                         
                                            <select name="chouyan" id="chouyan">
                                                <option value=""<?=$staff['chouyan']==''?' selected':''?>>请选择是否能吸烟</option>
                                                <option value="是"<?=$staff['chouyan']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['chouyan']=='否'?' selected':''?>>否</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否签订合同:                                                                                                                                                                                                    
                                            <select name="shifouqiandinghetong" id="shifouqiandinghetong">
                                                <option value=""<?=$staff['shifouqiandinghetong']==''?' selected':''?>>请选择是否签订合同</option>
                                                <option value="是"<?=$staff['shifouqiandinghetong']=='是'?' selected':''?>>是</option>
                                                <option value="否"<?=$staff['shifouqiandinghetong']=='否'?' selected':''?>>否</option>
                                            </select>
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
                                            <select name="zhiweizhuangtai" id="zhiweizhuangtai">
                                                <option value="">请选择职位状态</option>
                                                <option value="劳务工">劳务工</option>
                                                <option value="沈阳">沈阳</option>
                                                <option value="临时工在职">临时工在职</option>
                                                <option value="临时工离职">临时工离职</option>
                                                <option value="正式工在职">正式工在职</option>
                                                <option value="正式工离职">正式工离职</option>
                                            </select>
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
                                            <select name="leibie" id="leibie">
                                                <option value="">请选择类别</option>
                                                <option value="计件">计件</option>
                                                <option value="计时">计时</option>
                                                <option value="固定">固定</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />临时工工价/时:                                         
                                            <input type="text" class="form-control " name="linshigonggongjia" id="linshigonggongjia">
                                        </label>
                                        <label class="form-inline" />所属公司:                                         
                                            <select name="suoshugongsi" id="suoshugongsi">
                                                <option value="">请选择所属公司</option>
                                                <option value="潮尊">潮尊</option>
                                                <option value="潮品">潮品</option>
                                                <option value="诗可丽">诗可丽</option>
                                                <option value="潮宝">潮宝</option>
                                                <option value="宝丽莎">宝丽莎</option>
                                                <option value="潮小金">潮小金</option>
                                                <option value="馨淼">馨淼</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />购买社保档次:                                         
                                            <select name="goumaishebaodangci" id="goumaishebaodangci">
                                                <option value="">请选择购买社保档次</option>
                                                <option value="一档">一档</option>
                                                <option value="二档">二档</option>
                                                <option value="三档">三档</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />入职时间: 
                                            <input type="text" class="form-control form_datetime" name="in_date" id="in_date">
                                        </label>
                                        <label class="form-inline" />是否二次入职:                                                                
                                            <select name="shifouerciruzhi" id="shifouerciruzhi">
                                                <option value="">请选择是否二次入职</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />离职时间:                                         
                                            <input type="text" class="form-control form_datetime" name="out_date" id="out_date">
                                        </label>
                                        <label class="form-inline" />是否自离:                                            
                                            <select name="shifouzili" id="shifouzili">
                                                <option value="">请选择是否自离</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />本期工资是否已结算:                           
                                            <select name="gongziyijiesuan" id="gongziyijiesuan">
                                                <option value="">请选择本期工资是否已结算</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />线别:                                         
                                            <input type="text" class="form-control " name="xianbie" id="xianbie" disabled="disable">
                                        </label>
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
                                        <label class="form-inline" />所属楼层: 
                                            <input type="text" class="form-control " name="floor" id="floor" disabled="disable">
                                        </label>
                                        <label class="form-inline" />人工类别:                                         
                                            <input type="text" class="form-control" name="rengongleibie" id="rengongleibie" disabled="disable">
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
                                            <select name="shifouxuetu" id="shifouxuetu">
                                                <option value="">请选择是否学徒</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
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
                                            <select name="miankouhuoshifei" id="miankouhuoshifei">
                                                <option value="">请选择是否免扣伙食费</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />工资归属费用: 
                                            <input type="text" class="form-control" name="gongziguishufeiyong" id="gongziguishufeiyong" disabled="disable">
                                        </label>
                                        <label class="form-inline" />出生日期:                                         
                                            <input type="text" class="form-control" name="birthday" id="birthday" disabled="disable">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />婚否:                    
                                            <select name="marrige" id="marrige">
                                                <option value="">请选择婚否</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />性别:                         
                                            <select name="gender" id="gender" disabled="disable">
                                                <option value="0">请选择性别</option>
                                                <option value="1">男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />是否党员:                                               
                                            <select name="shifoudangyuan" id="shifoudangyuan">
                                                <option value="">请选择是否党员</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
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
                                        <label class="form-inline" />居住地址:                                         
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
                                            <select name="daishouji" id="daishouji">
                                                <option value="">请选择是否能带手机</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                        <label class="form-inline" />是否能吸烟:                                                                                                      
                                            <select name="chouyan" id="chouyan">
                                                <option value="">请选择是否能吸烟</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div>
                                        <label class="form-inline" />是否签订合同:                                                                                                
                                            <select name="shifouqiandinghetong" id="shifouqiandinghetong">
                                                <option value="">请选择是否签订合同</option>
                                                <option value="是">是</option>
                                                <option value="否">否</option>
                                            </select>
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
            'xianbie': $('#xianbie').val(),
            'dept_id': $('#dept_id').val(),
            'gangwei': $('#gangwei').val(),
            'floor': $('#floor').val(),
            'rengongleibie': $('#rengongleibie').val(),
            'legal_work_hour': $('#legal_work_hour').val(),
            'jiabanfeibiaozhun': $('#jiabanfeibiaozhun').val(),
            'shifouxuetu': $('#shifouxuetu').val(),
            'jieshaoren': $('#jieshaoren').val(),
            'xinzhibaodi': $('#xinzhibaodi').val(),
            'miankouhuoshifei': $('#miankouhuoshifei').val(),
            'gongziguishufeiyong': $('#gongziguishufeiyong').val(),
            'birthday': $('#birthday').val(),
            'marrige': $('#marrige').val(),
            'gender': $('#gender').val(),
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
});
$('#identification').on('change', function(){
    let res = IdCodeValid($('#identification').val());
    if(!res.pass) {
        layer.alert('身份证验证失败');
        $('#identification').val("");
    } else {
        $('#birthday').val($('#identification').val().substring(6,14))
        $('#chushengyuefen').val($('#identification').val().substring(10,12))
        let age = getAge($('#identification').val().substring(6,10)+"-"+$('#identification').val().substring(10,12)+"-"+$('#identification').val().substring(12,14))
        $('#age').val(age)
        if ($('#identification').val().substring(16,17)%2==1){
            $('#gender').val(1)
        } else {
            $('#gender').val(2)
        }
    }
})
$('#dept_id').on('change', function(){
    $.ajax({ 
        url: "/organization/department/one",
        data: {
            'dept_id':$('#dept_id').val()
        },
        dataType: 'json',
        type: 'POST',
        success: function(result){            
            if(result.status == 1){
                $('#xianbie').val(result.data.xianbie)
                $('#floor').val(result.data.floor)
                $('#rengongleibie').val(result.data.rengongleibie)
                $('#gongziguishufeiyong').val(result.data.gongziguishufeiyong)
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
function IdCodeValid(code){
    var city={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江 ",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北 ",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏 ",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外 "};
    var row={
        'pass':true,
        'msg':'验证成功'
    };
    if(!code || !/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/.test(code)){
        row={
            'pass':false,
            'msg':'身份证号格式错误'
        };
    }else if(!city[code.substr(0,2)]){
        row={
            'pass':false,
            'msg':'身份证号地址编码错误'
        };
    }else{
        //18位身份证需要验证最后一位校验位
        if(code.length == 18){
            code = code.split('');
            //∑(ai×Wi)(mod 11)
            //加权因子
            var factor = [ 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ];
            //校验位
            var parity = [ 1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2 ];
            var sum = 0;
            var ai = 0;
            var wi = 0;
            for (var i = 0; i < 17; i++)
            {
                ai = code[i];
                wi = factor[i];
                sum += ai * wi;
            }
            if(parity[sum % 11] != code[17].toUpperCase()){
                row={
                    'pass':false,
                    'msg':'身份证号校验位错误'
                };
            }
        }
    }
    return row;
}
function getAge(birthday, isSameDay = false) {
  const nowDate = new Date();
  const userDate = new Date(birthday);
  if (userDate.toString() === "Invalid Date") {
    return userDate;
  }
  const nowDateYear = nowDate.getFullYear();
  const nowDateMonth = nowDate.getMonth() + 1;
  const nowDateDay = nowDate.getDate();
  const userDateYear = userDate.getFullYear();
  const userDateMonth = userDate.getMonth() + 1;
  const userDateDay = userDate.getDate();
  let diffDate = nowDateYear - userDateYear;
  /**
   * 判断出生日期是否大于当前日期
   * 判断是否是同年
   */
  if (diffDate <= 0) return 0;
  /**
   * 大于一年；判断月份；
   * 当月大于用户月；月份已过，年份正确
   */
  if (nowDateMonth > userDateMonth) return diffDate;
  /**
   * 大于一年；判断月份；
   * 当月小于用户月；月份不满，总年份不足；年份 -1
   */
  if (nowDateMonth < userDateMonth) return diffDate - 1;
  /**
   * 大于一年；判断月份；
   * 当月等于用户月；
   * 判断天数；当前天数 小于 用户天数；天数不足；年份 -1；
   */
  if (nowDateDay < userDateDay) return diffDate - 1;
  /**
   * 大于一年；判断月份；
   * 当月等于用户月；
   * 判断天数；当前天数 大于 用户天数；年份正确；
   */
  if (nowDateDay > userDateDay) return diffDate;
  /**
   * 大于一年；判断月份；
   * 当月等于用户月；
   * 判断天数；当前天数 等于 用户天数；判断是否计算当天；
   */
  return isSameDay ? diffDate : diffDate - 1;
}
</script>
<?php require_once(VIEWPATH.'common/foot_v.php');?>