
<link rel="stylesheet" type="text/css" href="../zjtrain/styles/pc/global.min.css?v=201908261112" media="screen and (min-width: 768px)"/>
<link rel="stylesheet" type="text/css" href="../zjtrain/styles/pc/pages/Integral_calculation.min.css?v=201908261112" media="screen and (min-width: 768px)"/>
<link rel="stylesheet" type="text/css" href="../zjtrain/styles/m/global.min.css?v=201908261112" media="screen and (max-width: 768px)"/>
<link rel="stylesheet" type="text/css" href="../zjtrain/styles/m/pages/mCalc.min.css?v=201908261133" media="screen and (max-width: 768px)">
<style type="text/css">
    [v-cloak] { display: none }
    #nav,#kong,#ft{
        height: 0;
    }
    .mask{
        position: fixed;
        width: 100%;
        height: 100%;
        background:rgba(0,0,0,.5);
        top:0;
        left: 0;
    }
    em{
        font-style: normal;
    }
</style>

@verbatim
<div id="calculation" class="subject-main" v-cloak>
    <!-- 面包屑 -->
    <div class="w crumbs">
        <h4>
            <a href="{{ route('home') }}">上海积分网 ></a>
            <a class="blue">上海市居住证积分模拟评测</a>
        </h4>
    </div>
    <div class="calculation-box content-box">
        <div class="section1 clearfix" v-if="!beginShow">
            <p class="img fl"><img src="../zjtrain/images/pc/new-calc-img1.jpg"></p>
            <div class="area fr">
                <p class="info">本站积分计算根据《上海市居住证积分管理办法》进行，用于帮助境内来沪人员准确计算个人当前居住证积分分值，用户完成测分后将获得准确积分结果。</p>
                <div class="section-btn" style="text-align: center;">
                    <p class="btn" style="margin-left: 0;" @click="beginBtn">系统自动测分</p>
                    <!-- <p class="btn clickTalk" @click="renBtn">人工精准算分</p> -->
                    <!-- <p class="btn clickTalk">人工精准算分</p> -->
                </div>
            </div>
        </div>
        <div class="ren-box" v-if="renShow">
            <p class="xx-iconfont icon-close" @click="renShow = !renShow"></p>
            <p class="xx-iconfont icon-tijiaochenggong"></p>
            <p class="info">您已成功申请人工计算积分服务</p>
            <p class="desc">请在右下角对话框中输入“算分”，<br/>专业积分老师为您提供精准算分服务。</p>
        </div>
        <div class="calculation-warp" :class="subjectShow?'calculation-warp-show':''">
            <div class="progress-box clearfix" v-if="isStep">
                <div class="progress-step fl" v-for="item in stepData" :class="item == step ? 'progress-step-show':''" v-if="item <= step">
                    <p class="line"></p>
                    <div class="progress-num">
                        <em class="num">{{item < 10 ? '0'+item : item}}</em>/11
                    </div>
                </div>
            </div>
            <div class="calculation-warp-bd clearfix" :style="{height:stepHeight+'px'}">
                <div class="calc-border fl"></div>
                <div class="step step1" :class="[calcData.step1.isShow?'step-show':'',step>1?'step-hide':'']" id="calc-step1" @click="calcData.step1.yearDrop = false;calcData.step1.monthDrop = false">
                    <p class="subject-tit tc">年龄：请根据您身份证显示选择您的出生年月</p>
                    <div class="age-main">
                        <p class="age-text">您的身份证显示您生于</p>
                        <div class="age-box clearfix selete-box year-selete">
                            <div class="selete-box-hd" @click.stop="yearFun">
                                <em class="selete-text">{{calcData.step1.yearText}}</em>
                                <p class="text fr">年<em class="xx-iconfont icon-xialajiantou"></em></p>
                            </div>
                            <div class="selete-box-bd" :class="calcData.step1.yearDrop?'year-selete-show':'year-selete-hide'">
                                <ul id="yearScroll">
                                    <li v-for="item in calcData.step1.yearData" :class="item == calcData.step1.yearText ? 'is-seleted':''" @click="yearSelete(item)">{{item}}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="age-box clearfix selete-box month-selete" style="z-index: 2;">
                            <div class="selete-box-hd" @click.stop="calcData.step1.monthDrop = !calcData.step1.monthDrop;calcData.step1.yearDrop = false;errorShow = false;timer = 2;clearInterval(errorClean);">
                                <em class="selete-text">{{calcData.step1.monthText}}</em>
                                <p class="text fr">月<em class="xx-iconfont icon-xialajiantou"></em></p>
                            </div>
                            <div class="selete-box-bd" v-if="calcData.step1.monthDrop">
                                <ul>
                                    <li v-for="item in calcData.step1.monthData" :class="item == calcData.step1.monthText ? 'is-seleted':''" @click="monthSelete(item)">{{item}}月</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="step-trip" style="position: relative;" :style="calcData.step1.yearDrop?'z-index:0':'z-index:1'">
                        <em class="xx-iconfont icon-tishi"></em>温馨提示：
                        年龄不满18周岁或超过60周岁（1959年前或2001年后出生），无法申请积分。
                    </p>
                    <p class="btn" @click="subject1">下一题</p>
                </div>
                <div class="step step2" :class="[calcData.step2.isShow?'step-show':'',step>2?'step-hide':'']" @click="calcData.step2.drop = false;" id="calc-step2">
                    <p class="subject-tit tc">教育背景</p>
                    <div class="education-box">
                        <div class="education-box-bd clearfix">
                            <div class="education-box-list fl radio-list" :class="item.key == point.education ? 'selete-radio-list':''" v-for="item in calcData.step2.data">
                                <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.education" @change="radioChange"></strong>{{item.value}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="record-box">
                        <div class="record-box-bd clearfix">
                            <p class="record-text fl">学历形式</p>
                            <div class="selete-box fl">
                                <div class="selete-box-hd" @click.stop="calcData.step2.drop = !calcData.step2.drop;errorShow = false;timer = 2;clearInterval(errorClean);">
                                    <em class="selete-text">{{calcData.step2.seleteTit}}</em>
                                    <p class="text fr"><em class="xx-iconfont icon-xialajiantou"></em></p>
                                </div>
                                <div class="selete-box-bd" v-if="calcData.step2.drop">
                                    <ul>
                                        <li v-for="item in calcData.step2.record" :class="item.key == calcData.step2.seleteRecord ? 'is-seleted':''" @click="recordSelete(item.key,item.value)">{{item.value}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up2">上一题</p>
                        <p class="btn" @click="subject2">下一题</p>
                    </div>
                </div>
                <div class="step step3" :class="[calcData.step3.isShow?'step-show':'',step>3?'step-hide':'']" id="calc-step3">
                    <p class="subject-tit tc">专业技术职称和技能等级</p>
                    <div class="skills-box clearfix">
                        <div class="skills-box-list fl radio-list" :class="item.key == calcData.step3.level ? 'selete-radio-list':''" v-for="item in calcData.step3.data">
                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="calcData.step3.level"  @change="stepHeight = document.getElementById('calc-step3').offsetHeight;errorShow = false;timer = 2;clearInterval(errorClean);calcData.step3.level_4_5_needed = undefined;"></strong>{{item.value}}</label>
                        </div>
                    </div>
                    <div class="professional-box clearfix" v-if="calcData.step3.level == 'level_2' || calcData.step3.level == 'level_1'">
                        <div class="professional-box-hd fl">是否是大专及以上学历，近1年累计6个月每月个人<br/>社保达到<strong>756</strong>元，个税缴纳金额达到<strong>66</strong>元</div>
                        <div class="professional-box-bd fr">
                            <div class="fl radio-list" :class="calcData.step3.level_4_5_needed==1 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step3.level_4_5_needed"  @change="stepHeight = document.getElementById('calc-step3').offsetHeight;errorShow = false;timer = 2;clearInterval(errorClean);"></strong>是</label>
                            </div>
                            <div class="fl radio-list" :class="calcData.step3.level_4_5_needed==0 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step3.level_4_5_needed"  @change="stepHeight = document.getElementById('calc-step3').offsetHeight;errorShow = false;timer = 2;clearInterval(errorClean);"></strong>否</label>
                            </div>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up3">上一题</p>
                        <p class="btn" @click="subject3">下一题</p>
                    </div>
                </div>
                <div class="step step4" :class="[calcData.step4.isShow?'step-show':'',step>4?'step-hide':'']" id="calc-step4">
                    <p class="subject-tit tc">在上海连续缴纳社保年限</p>
                    <div class="social-box">
                        <div class="radio-list" :class="calcData.step4.seleteRadio==1 ? 'selete-radio-list':''">
                            <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step4.seleteRadio"  @change="radioChange"></strong>在上海连续缴纳社保<input type="text" v-model="calcData.step4.year" @focus="calcData.step4.seleteRadio = 1;errorShow = false;timer = 2;clearInterval(errorClean);" class="input">年</label>
                        </div>
                        <div class="radio-list" :class="calcData.step4.seleteRadio==0 ? 'selete-radio-list':''">
                            <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step4.seleteRadio" @change="calcData.step4.year = '';errorShow = false;timer = 2;clearInterval(errorClean);"></strong>未缴纳社保</label>
                        </div>
                    </div>
                    <p class="step-trip">
                        <em class="xx-iconfont icon-tishi"></em>提示：本积分项中的社保缴纳不能出现断缴、补缴，否则必须重头计算。
                    </p>
                    <div class="btn-main">
                        <p class="btn" @click="up4">上一题</p>
                        <p class="btn" @click="subject4">下一题</p>
                    </div>
                </div>
                <div class="step step5" :class="[calcData.step5.isShow?'step-show':'',step>5?'step-hide':'']" id="calc-step5">
                    <p class="subject-tit tc">在职员工<strong>每月个人</strong>缴纳社保金额</p>
                    <div class="high-social-box">
                        <div class="radio-list" :class="item.key == point.hign_social_security ? 'selete-radio-list':''" v-for="item in calcData.step5.data">
                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.hign_social_security"  @change="radioChange"></strong>{{item.value}}</label>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up5">上一题</p>
                        <p class="btn" @click="subject5">下一题</p>
                    </div>
                </div>
                <div class="step step6" :class="[calcData.step6.isShow?'step-show':'',step>6?'step-hide':'']" id="calc-step6">
                    <p class="subject-tit tc">表彰奖励</p>
                    <div class="reward-box clearfix">
                        <div class="radio-list fl" :class="item.key == point.reward ? 'selete-radio-list':''" v-for="item in calcData.step6.data">
                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.reward"  @change="radioChange"></strong>{{item.value}}</label>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up6">上一题</p>
                        <p class="btn" @click="subject6">下一题</p>
                    </div>
                </div>
                <div class="step step7" :class="[calcData.step7.isShow?'step-show':'',step>7?'step-hide':'']" id="calc-step7">
                    <p class="subject-tit tc">是否在上海投资创办企业？</p>
                    <div class="business-box">
                        <div class="business-box-hd">
                            <div class="radio-list" :class="calcData.step7.seleteRadio==0 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step7.seleteRadio" @change="calcData.step7.share_ratio ='';calcData.step7.tax_amount='';calcData.step7.employees_num='';errorShow = false;timer = 2;clearInterval(errorClean);"></strong>否</label>
                            </div>
                            <div class="radio-list" :class="calcData.step7.seleteRadio==1 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step7.seleteRadio" @change="radioChange"></strong>是</label>
                            </div>
                        </div>
                        <div class="business-box-bd" v-if="calcData.step7.seleteRadio==1">
                            在企业内持股<input type="text" class="input" v-model="calcData.step7.share_ratio" @focus="errorShow = false;timer = 2;clearInterval(errorClean);">%，最近3年内平均每年纳税<input class="input" type="text" v-model="calcData.step7.tax_amount" @focus="errorShow = false;timer = 2;clearInterval(errorClean);">万元，每年雇上海户籍员工<input type="text" class="input" v-model="calcData.step7.employees_num" @focus="errorShow = false;timer = 2;clearInterval(errorClean);">人。
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up7">上一题</p>
                        <p class="btn" @click="subject7">下一题</p>
                    </div>
                </div>
                <div class="step step8" :class="[calcData.step8.isShow?'step-show':'',step>8?'step-hide':'']" id="calc-step8">
                    <p class="subject-tit tc">创新创业（中介）人才</p>
                    <div class="interface-box">
                        <div class="radio-list" :class="item.key == calcData.step8.seleteRadio ? 'selete-radio-list':''" v-for="item in calcData.step8.data">
                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="calcData.step8.seleteRadio"  @change="radioChange"></strong>{{item.value}}</label>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up8">上一题</p>
                        <p class="btn" @click="subject8">下一题</p>
                    </div>
                </div>
                <div class="step step9" :class="[calcData.step9.isShow?'step-show':'',step>9?'step-hide':'']" id="calc-step9">
                    <p class="subject-tit tc">是否符合下列项目<strong>（符合条件可多选）</strong></p>
                    <div class="needed-box">
                        <div class="needed-box-bd">
                            <div class="check-list" :class="[item.checked?'selete-check-list':'',item.disabled?'disabled-check-list':'']" v-for="item in calcData.step9.data">
                                <label><strong class="check-strong"><input type="checkbox" :value="item.key" :checked = "item.checked" :disabled="item.disabled" @change="neededFun(item)"></strong>{{item.value}}</label>
                            </div>
                        </div>
                        <p class="step-trip" v-if="calcData.step9.data[0].disabled || calcData.step9.data[1].disabled">
                            <em class="xx-iconfont icon-tishi"></em>大专以下学历或非全日制学历，选项1不可选。<br/>紧缺急需专业仅存在于全日制大专，故非全日制大专学历，选项2不可选。
                        </p>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up9">上一题</p>
                        <p class="btn" @click="subject9">下一题</p>
                    </div>
                </div>
                <div class="step step7" :class="[calcData.step10.isShow?'step-show':'',step>10?'step-hide':'']" id="calc-step10">
                    <p class="subject-tit tc">是否在特定公共领域服务或远郊重点区域？</p>
                    <div class="business-box">
                        <div class="business-box-hd">
                            <div class="radio-list" :class="calcData.step10.seleteRadio==0 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step10.seleteRadio" @change="calcData.step10.port_work ='';calcData.step10.sanitation_work=''; errorShow = false;timer = 2;clearInterval(errorClean);"></strong>否</label>
                            </div>
                            <div class="radio-list" :class="calcData.step10.seleteRadio==1 ? 'selete-radio-list':''">
                                <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step10.seleteRadio"  @change="radioChange"></strong>是</label>
                            </div>
                        </div>
                        <div class="business-box-bd" v-if="calcData.step10.seleteRadio==1">
                            在临港地区工作并居住，满<input type="text" class="input" v-model="calcData.step10.port_work" @focus="errorShow = false;timer = 2;clearInterval(errorClean);">年，在上海市环卫领域服务，满<input type="text" class="input" v-model="calcData.step10.sanitation_work" @focus="errorShow = false;timer = 2;clearInterval(errorClean);">年。
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up10">上一题</p>
                        <p class="btn" @click="subject10">下一题</p>
                    </div>
                </div>
                <div class="step step11" :class="calcData.step11.isShow?'step-show':''" id="calc-step11">
                    <p class="subject-tit tc">是否有以下情况（可多选）</p>
                    <div class="violation-box">
                        <div class="check-list" :class="item.checked?'selete-check-list':''" v-for="item in calcData.step11.data">
                            <label><strong class="check-strong"><input type="checkbox" :value="item.key" :checked = "item.checked" @change="violationFun(item)"></strong>{{item.value}}<input v-if="item.isShow" v-model="item.text" @focus="item.checked = true;calcData.step11.data[2].checked = false;errorShow = false;timer = 2;clearInterval(errorClean);" type="text" class="input">{{item.value1}}</label>
                        </div>
                    </div>
                    <div class="btn-main">
                        <p class="btn" @click="up11">上一题</p>
                        <p class="btn" @click="subject11">提交</p>
                    </div>
                </div>
                <div class="calc-border fr"></div>
                <div class="error" :class="errorShow?'error-show':'error-hide'">
                    <p class="info">{{errorText}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mask" v-if="successInfo.maskShow || renShow"></div>
    <div class="calc-success" v-if="successInfo.maskShow">
        <div class="calc-success-con1" v-if="successInfo.successShow1">
            <p class="close" @click="successInfo.maskShow = false ; successInfo.successShow1 = false;successInfo.name = '';successInfo.phone ='';"><em class="xx-iconfont icon-close"></em></p>
            <div class="success-info tc">
                <p class="info"><em class="xx-iconfont icon-tijiaochenggong"></em>提交成功</p>
                <p class="desc">请留下您的联系方式用于获取积分结果通知。</p>
            </div>
            <div class="contact-tel clearfix">
                <p class="text fl">您的称呼</p>
                <div class="tel fl">
                    <input type="text" v-model="successInfo.name" @focus="successInfo.nameErrorShow = false;timer = 2;clearInterval(errorClean);successInfo.nameError = '';">
                    <p class="error" v-if="successInfo.nameErrorShow">{{successInfo.nameError}}</p>
                </div>
            </div>
            <div class="contact-tel clearfix">
                <p class="text fl">联系电话</p>
                <div class="tel fl">
                    <input type="text" v-model="successInfo.phone" @focus="successInfo.phoneErrorShow = false;timer = 2;clearInterval(errorClean);successInfo.phoneError = '';" @blur="phoneBlur">
                    <p class="error" v-if="successInfo.phoneErrorShow">{{successInfo.phoneError}}</p>
                </div>
                <div class="img-code" v-if="successInfo.imgShow">
                    <strong class="code-i" v-html="img_yzm" @click="yzmFun"></strong>
                    <input type="text" class="code-in" placeholder="请输入验证码" v-model="seleteCalc.sub12.img_code">
                </div>
            </div>
            <p class="btn" @click="submit1">确认</p>
            <p class="trip tc">*为了您的利益和我们的口碑，您的信息将被我们严格保密！</p>
        </div>
        <div class="calc-success-con2 tc" v-if="successInfo.successShow2">
            <p class="close" @click="successClose"><em class="xx-iconfont icon-close"></em></p>
            <p class="img"><img src="../zjtrain/images/pc/new-calc-img.png"></p>
            <p class="info">您的积分已进入核实程序<br/>我们将在2个工作日内电话告知您准确积分结果</p>
            <a href="javascript:void(0)" @click="window.location.reload();" class="btn">关闭&nbsp;&nbsp;&nbsp;&nbsp;{{successInfo.time >0 ?'0'+successInfo.time:successInfo.time}}s</a>
        </div>
    </div>
</div>
<div class="mcalculation">
    <div id="nav"></div>
    <div id="kong"></div>
    <div id="ft"></div>
    <div id="mCalculation" v-cloak>
        <div class="calclation-box" :class="isBegin ? 'calclation-box-auto' : ''" :style={height:isHeight?boxHeight+'px':calcHeight+'px'}>
            <div class="calc-box" :class="[!openId ? '':'calc-box-wei',isHeight || isBegin?'calc-box-rela':'']">
                <div class="section1" v-if="!beginShow">
                    <div class="area">
                        <div class="floor1">
                            <p class="trip">温馨提示</p>
                        </div>
                        <div class="floor2">
                            本站积分计算根据《上海市居住证积分管理办法》进行，用于帮助境内来沪人员准确计算个人当前居住证积分分值，用户完成测分后将获得准确积分结果。
                        </div>
                    </div>
                    <div class="section-btn">
                        <!-- <p class="btn clickTalk">人工精准算分</p> -->
                        <p class="btn" style="left: 50%;margin-left: -2.2rem;" @click="beginFun">系统自动测分</p>
                    </div>
                </div>
                <div class="calculation-warp" :class="subjectShow?'':'calculation-warp-hide'">
                    <div class="progress-box">
                        <div class="progress-box-bd clearfix">
                            <p class="progress-step fl" v-for="item in stepData" :class="item == step ? 'progress-step-show':''" v-if="item <= step"></p>
                        </div>
                        <div class="progress-num">
                            <em class="num">{{step < 10 ? '0'+step : step}}</em>/11
                        </div>
                    </div>
                    <div class="calculation-warp-bd">
                        <div class="step-list" :class="[calcData.step1.isShow?'step-show':'',step>1?'step-hide':'']">
                            <div class="step step1" id="step1">
                                <p class="subject-tit"><em class="num">01</em>年龄</p>
                                <div class="subject-con">
                                    <div class="selete-box" :class="calcData.step1.text !='请选择' ? 'selete-box-have':''">
                                        <p class="selete-box-text">请选择您身份证上的出生年月</p>
                                        <div class="selete-box-bd" @click="agePicker" id="age">
                                            <p class="picker-text">请选择</p>
                                            <p class="text">
                                                <em class="xx-iconfont icon-xialasanjiao"></em>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="calc-trip">
                                        <p class="trip"><em class="xx-iconfont icon-tishi"></em>温馨提示：</p>
                                        <p class="info">年龄不满18周岁或超过60周岁（1959年前或2001年后出生），无法申请积分。</p>
                                    </div>
                                </div>
                            </div>
                            <p class="btn" @click="subject1">下一题</p>
                        </div>
                        <div class="step-list" :class="[calcData.step2.isShow?'step-show':'',step>2?'step-hide':'']">
                            <div class="step step2" id="step2">
                                <p class="subject-tit"><em class="num">02</em>教育背景</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="item.key == point.education ? 'selete-radio-list':''" v-for="item in calcData.step2.data">
                                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.education" @change="radioChange"></strong>{{item.value}}</label>
                                        </div>
                                    </div>
                                    <div class="record-box">
                                        <div class="selete-box" :class="calcData.step2.seleteTit !='请选择' ? 'selete-box-have':''">
                                            <p class="selete-box-text">学历形式</p>
                                            <div class="selete-box-bd" @click="recordPicker" id="record">
                                                <p class="picker-text">{{calcData.step2.seleteTit}}</p>
                                                <p class="text">
                                                    <em class="xx-iconfont icon-xialasanjiao"></em>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up2">上一题</p>
                                <p class="btn" @click="subject2">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step3.isShow?'step-show':'',step>3?'step-hide':'']">
                            <div class="step step3" id="step3">
                                <p class="subject-tit"><em class="num">03</em>专业技术职称和技能等级</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="item.key == calcData.step3.level ? 'selete-radio-list':''" v-for="item in calcData.step3.data">
                                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="calcData.step3.level" @change="radioC('step3')"></strong>{{item.value}}</label>
                                        </div>
                                    </div>
                                    <div class="professional-box" v-if="calcData.step3.level == 'level_2' || calcData.step3.level == 'level_1'">
                                        <div class="selete-box" :class="calcData.step3.seleteTit !='请选择' ? 'selete-box-have':''">
                                            <p class="selete-box-text">是否满足以下条件</p>
                                            <div class="selete-box-bd" @click="professionalPicker" id="professional">
                                                <p class="picker-text">{{calcData.step3.seleteTit}}</p>
                                                <p class="text">
                                                    <em class="xx-iconfont icon-xialasanjiao"></em>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="professional-box-bd">
                                            <strong class="label">大专及以上学历</strong>
                                            <strong class="label">每月个税达到66元</strong>
                                            <strong class="label">近1年累计6个月每月个人社保达到756元</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up3">上一题</p>
                                <p class="btn" @click="subject3">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step4.isShow?'step-show':'',step>4?'step-hide':'']">
                            <div class="step step4" id="step4">
                                <p class="subject-tit"><em class="num">04</em>在上海连续缴纳社保年限</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="calcData.step4.seleteRadio==1 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step4.seleteRadio" @change="radioChange"></strong>在上海连续缴纳社保<input type="number" v-model="calcData.step4.year" @focus="calcData.step4.seleteRadio = 1;errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;" class="input">年</label>
                                        </div>
                                        <div class="radio-list" :class="calcData.step4.seleteRadio==0 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step4.seleteRadio" @change="calcData.step4.year = '';errorShow = false;timer = 2;clearInterval(errorClean);"></strong>未缴纳社保</label>
                                        </div>
                                    </div>
                                    <div class="calc-trip">
                                        <em class="xx-iconfont icon-tishi"></em>
                                        <div class="calc-trip-bd">
                                            提示：本积分项中的社保缴纳不能出现断缴、补缴，否则必须重头计算。
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up4">上一题</p>
                                <p class="btn" @click="subject4">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step5.isShow?'step-show':'',step>5?'step-hide':'']">
                            <div class="step step5" id="step5">
                                <p class="subject-tit"><em class="num">05</em>在职员工<strong>每月个人</strong>缴纳社保金额</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="item.key == point.hign_social_security ? 'selete-radio-list':''" v-for="item in calcData.step5.data">
                                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.hign_social_security" @change="radioChange"></strong>{{item.value}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up5">上一题</p>
                                <p class="btn" @click="subject5">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step6.isShow?'step-show':'',step>6?'step-hide':'']">
                            <div class="step step6" id="step6">
                                <p class="subject-tit"><em class="num">06</em>表彰奖励</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="item.key == point.reward ? 'selete-radio-list':''" v-for="item in calcData.step6.data">
                                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="point.reward" @change="radioChange"></strong>{{item.value}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up6">上一题</p>
                                <p class="btn" @click="subject6">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step7.isShow?'step-show':'',step>7?'step-hide':'']">
                            <div class="step step7" id="step7">
                                <p class="subject-tit"><em class="num">07</em>是否在上海投资创办企业？</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="calcData.step7.seleteRadio==0 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step7.seleteRadio" @change="radioC('step7');calcData.step7.share_ratio ='';calcData.step7.tax_amount='';calcData.step7.employees_num='';errorShow = false;timer = 2;clearInterval(errorClean);"></strong>否</label>
                                        </div>
                                        <div class="radio-list" :class="calcData.step7.seleteRadio==1 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step7.seleteRadio" @change="radioC('step7')"></strong>是</label>
                                        </div>
                                    </div>
                                    <div class="business-box" v-if="calcData.step7.seleteRadio==1">
                                        <p>在企业内持股<input type="number" class="input" v-model="calcData.step7.share_ratio" @focus="errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">%，</p>
                                        <p>最近3年内平均每年纳税<input class="input" type="number" v-model="calcData.step7.tax_amount" @focus="errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">万元，</p>
                                        <p>每年雇上海户籍员工<input type="number" class="input" v-model="calcData.step7.employees_num" @focus="errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">人。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up7">上一题</p>
                                <p class="btn" @click="subject7">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step8.isShow?'step-show':'',step>8?'step-hide':'']">
                            <div class="step step8" id="step8">
                                <p class="subject-tit"><em class="num">08</em>是否在上海投资创办企业？</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="item.key == calcData.step8.seleteRadio ? 'selete-radio-list':''" v-for="item in calcData.step8.data">
                                            <label><strong class="radio-strong"><input type="radio" :value="item.key" v-model="calcData.step8.seleteRadio" @change="radioChange"></strong><p class="info">{{item.value}}</p></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up8">上一题</p>
                                <p class="btn" @click="subject8">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step9.isShow?'step-show':'',step>9?'step-hide':'']">
                            <div class="step step9" id="step9">
                                <p class="subject-tit"><em class="num">09</em>是否符合下列项目<strong>（符合条件可多选）</strong></p>
                                <div class="subject-con" :class="calcData.step9.data[0].disabled || calcData.step9.data[1].disabled?'subject-con-trip':''">
                                    <div class="check-box">
                                        <div class="check-list" :class="[item.checked?'selete-check-list':'',item.disabled?'disabled-check-list':'']" v-for="item in calcData.step9.data">
                                            <label><strong class="check-strong"><input type="checkbox" :value="item.key" :checked = "item.checked" :disabled="item.disabled" @change="neededFun(item)"></strong>{{item.value}}</label>
                                        </div>
                                    </div>
                                    <div class="calc-trip" v-if="calcData.step9.data[0].disabled || calcData.step9.data[1].disabled">
                                        <p class="trip"><em class="xx-iconfont icon-tishi"></em>温馨提示：</p>
                                        <p class="info">大专以下学历或非全日制学历，选项1不可选。<br/>紧缺急需专业仅存在于全日制大专，故非全日制大专学历，<br/>选项2不可选。</p>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up9">上一题</p>
                                <p class="btn" @click="subject9">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step10.isShow?'step-show':'',step>10?'step-hide':'']">
                            <div class="step step7 step10" id="step10">
                                <p class="subject-tit"><em class="num">10</em>是否在特定公共领域服务或远郊重点区域？</p>
                                <div class="subject-con">
                                    <div class="radio-box">
                                        <div class="radio-list" :class="calcData.step10.seleteRadio==0 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="0" v-model="calcData.step10.seleteRadio" @change="radioC('step10');calcData.step10.port_work ='';calcData.step10.sanitation_work='';errorShow = false;timer = 2;clearInterval(errorClean);"></strong>否</label>
                                        </div>
                                        <div class="radio-list" :class="calcData.step10.seleteRadio==1 ? 'selete-radio-list':''">
                                            <label><strong class="radio-strong"><input type="radio" :value="1" v-model="calcData.step10.seleteRadio" @change="radioC('step10')"></strong>是</label>
                                        </div>
                                    </div>
                                    <div class="business-box" v-if="calcData.step10.seleteRadio==1">
                                        <p>在临港地区工作并居住，满<input type="number" class="input" v-model="calcData.step10.port_work" @focus="errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">年，</p>
                                        <p>在上海市环卫领域服务，满<input type="number" class="input" v-model="calcData.step10.sanitation_work" @focus="errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">年。</p>

                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up10">上一题</p>
                                <p class="btn" @click="subject10">下一题</p>
                            </div>
                        </div>
                        <div class="step-list" :class="[calcData.step11.isShow?'step-show':'',step>11?'step-hide':'']">
                            <div class="step step11" id="step11">
                                <p class="subject-tit"><em class="num">11</em>是否有以下情况<strong>（可多选）</strong></p>
                                <div class="subject-con">
                                    <div class="check-box">
                                        <div class="check-list" :class="item.checked?'selete-check-list':''" v-for="item in calcData.step11.data">
                                            <label><strong class="check-strong"><input type="checkbox" :value="item.key" :checked = "item.checked" @change="violationFun(item)"></strong>{{item.value}}</label><input v-if="item.isShow" v-model="item.text" type="number" class="input" @focus="item.checked = true;calcData.step11.data[2].checked = false;errorShow = false;timer = 2;clearInterval(errorClean);isInput = true;" @blur="isInput = false;">{{item.value1}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-btn">
                                <p class="btn" @click="up11">上一题</p>
                                <p class="btn" @click="subject11">提 交</p>
                            </div>
                        </div>
                    </div>
                    <div class="error" :class="errorShow?'error-show':'error-hide'">
                        <p class="info">{{errorText}}</p>
                    </div>
                </div>
            </div>
            <div class="mask"  v-if="successInfo.maskShow"></div>
            <div class="calc-success"  v-if="successInfo.maskShow">
                <div class="calc-success-con1" v-if="successInfo.successShow1">
                    <p class="close" @click="successInfo.maskShow = false ; successInfo.successShow1 = false;successInfo.phone ='';"><em class="xx-iconfont icon-close"></em></p>
                    <div class="success-info tc">
                        <p class="info"><em class="xx-iconfont icon-tijiaochenggong"></em>提交成功</p>
                        <p class="desc">请留下您的联系方式用于获取积分结果通知</p>
                    </div>
                    <div class="contact-tel clearfix">
                        <div class="tel">
                            <input type="name" v-model="successInfo.name" placeholder="您的称呼" @focus="successInfo.nameErrorShow = false;successInfo.nameError = '';" @blur="phoneBlur">
                            <p class="error" v-if="successInfo.nameErrorShow">{{successInfo.nameError}}</p>
                        </div>
                        <div class="tel">
                            <input type="tel" v-model="successInfo.phone" placeholder="请输入手机号" @focus="successInfo.phoneErrorShow = false;successInfo.phoneError = '';" @blur="phoneBlur">
                            <p class="error" v-if="successInfo.phoneErrorShow">{{successInfo.phoneError}}</p>
                        </div>
                        <div class="img-code" v-if="successInfo.imgShow">
                            <input type="text" class="code-in" placeholder="请输入验证码" v-model="seleteCalc.sub12.img_code">
                            <strong class="code-i" v-html="img_yzm" @click="yzmFun"></strong>
                        </div>
                    </div>
                    <p class="btn" @click="submit1">确 认</p>
                    <p class="trip tc"></p>
                </div>
                <div class="calc-success-con2" v-if="successInfo.successShow2">
                    <p class="close" @click="successClose"><em class="xx-iconfont icon-close"></em></p>
                    <p class="img"><img src="../zjtrain/images/m/new-calc-img1.png"></p>
                    <p class="info tc">您的积分已进入核实程序<br/>我们将在2个工作日内电话告知您准确积分结果</p>
                    <a href="javascript:void(0)" class="btn" @click="window.location.reload();">关闭&nbsp;&nbsp;&nbsp;&nbsp;{{successInfo.time >0 ?'0'+successInfo.time:successInfo.time}}s</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endverbatim

<script src="../zjtrain/js/lib/jquery-1.7.2.min.js"></script>
<script src="../zjtrain/js/lib/vue.min.js"></script>
<script src="../zjtrain/js/lib/vue-resource.min.js"></script>
<script src="../zjtrain/js/lib/index.js"></script>
<script>
    function screenLoad(){
        if(screen.width<=768){
            document.write('<script src="../zjtrain/js/m/lib/lib-flexible-2.0/index.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/m/lib/picker.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/m/guiji.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/m/commonForm.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/m/calc.min.js?v=201903110931"><\/script>');
        }else{
            document.write('<script src="../zjtrain/js/pc/guiji.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/pc/commonForm.min.js"><\/script>');
            document.write('<script src="../zjtrain/js/pc/calcPopWrap.min.js?v=201903110931"><\/script>');
        }
    }
    screenLoad()
</script>

