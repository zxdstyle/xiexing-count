@verbatim
    <div id="calculation">
        <!-- 面包屑 -->
        <div class="w crumbs">
            <h4>
                <a href="{{ route('home') }}">沪客网 ></a>
                <a class="blue">上海市积分落户自动评测系统</a>
            </h4>
        </div>
        <div class="section0 content-box" v-if="step === 0">
            <div class="item-pic">
                <img class="img-full-size" src="../zjtrain/images/pc/bg.png" />
            </div>
            <div class="item-info">
                <p class="text">本套自测系统基于上海市居转户政策研发，旨在帮助用户快速判断自己是否符合居转户申请条件，请根据问题和自身实际情况认真答题。</p>
                <div class="operator" style="text-align: center;">
                    <button class="xx-button xx-button-danger" @click="startStep">系统自测</button>
                </div>
            </div>
        </div>
        <div id="section-step" class="calculation-box content-box" v-show="isStartStep" v-cloak>
            <div class="calculation-warp calculation-warp-show">
                <!--进度条-->
                <div class="progress-box clearfix">
                    <div class="progress-step fl progress-step-show" :style="{width: processWidth }">
                        <p class="line"></p>
                        <div class="progress-num">
                            <em class="num">{{step}}</em>/{{totalStep}}
                        </div>
                    </div>
                </div>
                <!--主题题目-->
                <div class="calculation-warp-bd clearfix">
                    <div class="calc-border fl"></div>
                    <!--第一题-->
                    <div class="step step1" :class="{'step-show': step === 1, 'step-hide': step > 1}">
                        <p class="subject-tit tc">是否持有有效期内《上海市居住证》？</p>
                        <my-radio v-model="step1.value" label="是" :key-value="1" ref="radioStep1">
                            是<em style="padding-left: 40px;">持有</em><input type="text" class="input" @focus="$refs.radioStep1.onInput()" v-model="step1.extra.value" />年
                        </my-radio>
                        <my-radio v-model="step1.value" label="否" :key-value="0"></my-radio>
                        <p class="btn" @click="nextStep">下一题</p>
                    </div>
                    <!--第二题-->
                    <div class="step step2" :class="{'step-show': step === 2, 'step-hide': step > 2}">
                        <p class="subject-tit tc">持证期间是否按规缴纳上海社保？</p>
                        <my-radio v-model="step2.value" label="是" :key-value="1"  ref="radioStep2">
                            是<em style="padding-left: 40px;">累计缴纳</em><input type="text" class="input" @focus="$refs.radioStep2.onInput()" v-model="step2.extra.value" />年
                        </my-radio>
                        <my-radio v-model="step2.value" label="否" :key-value="0"></my-radio>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p class="btn" @click="nextStep">下一题</p></div>
                    </div>
                    <!--第三题-->
                    <div class="step step3" :class="{'step-show': step === 3, 'step-hide': step > 3}">
                        <p class="subject-tit tc">最近连续3年社保缴纳是否超过2倍基数？</p>
                        <my-radio v-model="step3.value" label="是" :key-value="1"></my-radio>
                        <my-radio v-model="step3.value" label="否" :key-value="0"></my-radio>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第四题-->
                    <div class="step step4 step-two-col" :class="{'step-show': step === 4, 'step-hide': step > 4}">
                        <p class="subject-tit tc">持证期间依法缴纳个人所得税</p>
                        <div class="clearfix center-padding">
                            <my-radio v-model="step4.value" label="对应社保缴费基数比例" :key-value="0"></my-radio>
                            <my-radio v-model="step4.value" label="高于社保缴费基数比例" :key-value="1"></my-radio>
                            <my-radio v-model="step4.value" label="低于社保缴费基数比例" :key-value="2"></my-radio>
                            <my-radio v-model="step4.value" label="未正常缴纳个税（包括申报0个税）" :key-value="3"></my-radio>
                        </div>
                        <p class="step-trip" style="position: relative; z-index: 1;">
                            <em class="xx-iconfont icon-tishi"></em>个税计算公式：个税金额=（应发工资-社保个人部分-5000）×税率-速算扣除率
                        </p>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第五题-->
                    <div class="step step5 step-two-col" :class="{'step-show': step === 5, 'step-hide': step > 5}">
                        <p class="subject-tit tc">专业技术职称和技能等级</p>
                        <div class="clearfix center-padding">
                            <my-radio v-model="step5.value" label="持有二级技能等级证书" :key-value="0"></my-radio>
                            <my-radio v-model="step5.value" label="持有中级技术职称证书" :key-value="1"></my-radio>
                            <my-radio v-model="step5.value" label="持有一级技能等级证书" :key-value="2"></my-radio>
                            <my-radio v-model="step5.value" label="持有高级技术职称证书" :key-value="3"></my-radio>
                            <my-radio v-model="step5.value" label="以上皆无" :key-value="4"></my-radio>
                        </div>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第六题-->
                    <div class="step step6 step-two-col-long" :class="{'step-show': step === 6, 'step-hide': step > 6}">
                        <p class="subject-tit tc">是否有违反以下情况的记录？</p>
                        <div class="clearfix center-padding">
                            <my-radio v-model="step6.value" label="未婚先育、超生等违反计划生育情况" :key-value="0"></my-radio>
                            <my-radio v-model="step6.value" label="有行政处罚、违法犯罪记录" :key-value="1"></my-radio>
                            <my-radio v-model="step6.value" label="有未撤销的高等教育院校处分、党纪处分记录" :key-value="2"></my-radio>
                            <my-radio v-model="step6.value" label="持有高级技术职称证书" :key-value="3"></my-radio>
                            <my-radio v-model="step6.value" label="以上皆无" :key-value="4"></my-radio>
                        </div>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第七题-->
                    <div class="step step7 step-two-col" :class="{'step-show': step === 7, 'step-hide': step > 7}">
                        <p class="subject-tit tc">就职单位机构性质及资质</p>
                        <div class="clearfix center-padding">
                            <my-radio v-model="step7.value" label="普通民营企业" :key-value="0"></my-radio>
                            <my-radio v-model="step7.value" label="国有企业" :key-value="1"></my-radio>
                            <my-radio v-model="step7.value" label="外资企业" :key-value="2"></my-radio>
                            <my-radio v-model="step7.value" label="以上皆无" :key-value="3"></my-radio>
                        </div>
                        <my-select title="是否具备以下资质" :options="step7.options" @on-change="onSelectChange7" value></my-select>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第八题-->
                    <div class="step step8 step-two-col" :class="{'step-show': step === 8, 'step-hide': step > 8}">
                        <p class="subject-tit tc">是否符合以下条件？</p>
                        <div class="clearfix center-padding">
                            <my-radio v-model="step8.value" label="获重大贡献奖励" :key-value="0"></my-radio>
                            <my-radio v-model="step8.value" label="在远郊地区教育岗位工作满5年" :key-value="1"></my-radio>
                            <my-radio v-model="step8.value" label="在远郊地区卫生岗位工作满5年" :key-value="2"></my-radio>
                            <my-radio v-model="step8.value" label="以上皆无" :key-value="3"></my-radio>
                        </div>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第九题-->
                    <div class="step step9" :class="{'step-show': step === 9, 'step-hide': step > 9}">
                        <p class="subject-tit tc">是否最近3年计税薪酬收入高于上年同行业中级技术、技能或者管理岗位<br>年均薪酬收入水平的技术管理和关键岗位人员的收入？</p>
                        <div class="clearfix">
                            <my-radio v-model="step9.value" label="是" :key-value="0"></my-radio>
                            <my-radio v-model="step9.value" label="否" :key-value="1"></my-radio>
                        </div>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p @click="nextStep" class="btn">下一题</p></div>
                    </div>
                    <!--第十题-->
                    <div class="step step10" :class="{'step-show': step === 10, 'step-hide': step > 10}">
                        <p class="subject-tit tc">企业主在本市直接投资（或者投资份额），最近连续3个纳税年度累计缴纳<br>总额及每年最低缴纳额是否达到本市规定标准，或者连续3年聘用上海市员<br>工人数达到规定标准？</p>
                        <div class="clearfix">
                            <my-radio v-model="step10.value" label="是" :key-value="0"></my-radio>
                            <my-radio v-model="step10.value" label="否" :key-value="1"></my-radio>
                        </div>
                        <div class="btn-main"><p class="btn" @click="preStep">上一题</p> <p class="btn" @click="nextStep" id="submitForm">提交</p></div>
                    </div>
                    <div class="calc-border fr"></div>
                </div>
                <transition name="fade">
                    <div class="error error-show" v-if="isShowError">
                        <p class="info">{{errMsg}}</p>
                    </div>
                </transition>
            </div>
        </div>
    </div>
    <div class="chang-service service-change j-common-form pc-from">
        <div class="form form-edit j-form">
            <em class="xx-iconfont icon-icon-1 form-close"></em>
            <div class="service-tit tc">
                <div class="title-inner">
                    <p class="info"><em class="xx-iconfont icon-tijiaochenggong"></em>您的自测选项已提交成功！</p>
                    <p class="desc">请填写您的联系方式用于接收自测结果</p>
                </div>
            </div>
            <div class="form-bd">
                <div class="form-list clearfix">
                    <p class="form-list-bd fl">
                        <input type="text" autocomplete="off" name="name" class="name" placeholder="您的称呼"/><strong class="form-input-error"></strong>
                    </p>
                </div>
                <div class="form-list clearfix">
                    <p class="form-list-bd fl">
                        <input type="tel" autocomplete="off" name="phone" class="phone" placeholder="您的手机号码"/><strong class="form-input-error"></strong>
                    </p>
                </div>
                <div class="img-code">
                    <strong class="code-i">&nbsp;</strong><input type="text" name="code" class="code-in" placeholder="请输入验证码"/>
                </div>
                <p class="xx-button xx-button-primary xx-button-lg j-submit">
                    提 交
                </p>
            </div>
            <div class="form-ft tc">
                <p class="trip">
                    *为了您的利益和我们的口碑，您的信息将被我们严格保密！
                </p>
            </div>
        </div>
        <div class="success tc form-success j-form-success">
            <em class="xx-iconfont icon-icon-1 form-close"></em>
            <div class="success-intro">
                <p class="xx-iconfont icon-tijiaochenggong">
                    <br/>
                </p>
                <p class="desc">
                    提交成功
                </p>
            </div>
            <p class="info">
                您的服务申请已提交，<br/>服务站将在1个工作日内与你沟通服务细节。
            </p>
            <div class="j-form-footer form-success-footer">
                <div class="timer">
                    03s
                </div>
            </div>
        </div>
    </div>
    <div class="mcalculation">
        <div id="nav"></div>
        <div id="kong"></div>
        <div id="ft"></div>
        <div id="mCalculation" v-cloak>
            <div class="calclation-box" :style={height:isHeight?boxHeight+'px':calcHeight+'px'}>
                <div class="calc-box">
                    <div class="section1" v-if="step === 0">
                        <div class="area">
                            <div class="floor1"></div>
                            <div class="floor2">
                                本套自测系统基于上海市居转户政策研发，旨在帮助用户快速判断自己是否符合居转户申请条件，请根据问题和自身实际情况认真答题。
                            </div>
                        </div>
                        <div class="section-btn">
                            <p class="btn" @click="startStep" style="left: 50%;margin-left: -2.2rem;">开始自测</p>
                        </div>
                    </div>
                    <div class="calculation-warp" v-show="isStartStep">
                        <div class="progress-box">
                            <div class="progress-box-bd clearfix">
                                <p class="progress-step fl" :style="{width: processWidth }"></p>
                            </div>
                            <div class="progress-num">
                                <em class="num">{{step<10?('0'+ step):step}}</em>/10
                            </div>
                        </div>
                        <div class="calculation-warp-bd">
                            <!--第一题-->
                            <div class="step-list" :class="{'step-show': step === 1, 'step-hide': step > 1}">
                                <div class="step step1">
                                    <p class="subject-tit"><em class="num">01</em>是否持有有效期内《上海市居住证》？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step1.value" label="是" :key-value="1" ref="radioStep1">
                                                是<em style="padding-left: 40px;">持有</em><input type="text" class="input" @focus="$refs.radioStep1.onInput()" v-model="step1.extra.value" />年
                                            </my-radio>
                                            <my-radio v-model="step1.value" label="否" :key-value="0"></my-radio>
                                        </div>
                                    </div>
                                </div>
                                <p class="btn" @click="nextStep">下一题</p>
                            </div>
                            <!--第二题-->
                            <div class="step-list" :class="{'step-show': step === 2, 'step-hide': step > 2}">
                                <div class="step step2">
                                    <p class="subject-tit"><em class="num">02</em>持证期间是否按规缴纳上海社保？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step2.value" label="是" :key-value="1" ref="radioStep2">
                                                是<em style="padding-left: 40px;">累计缴纳</em><input type="text" class="input" @focus="$refs.radioStep2.onInput()" v-model="step2.extra.value" />年
                                            </my-radio>
                                            <my-radio v-model="step2.value" label="否" :key-value="0"></my-radio>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-btn">
                                    <p class="btn" @click="preStep">上一题</p>
                                    <p class="btn" @click="nextStep">下一题</p>
                                </div>
                            </div>
                            <!--第三题-->
                            <div class="step-list" :class="{'step-show': step === 3, 'step-hide': step > 3}">
                                <div class="step step2">
                                    <p class="subject-tit"><em class="num">03</em>最近连续3年社保缴纳是否超过2倍基数？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step3.value" label="是" :key-value="1"></my-radio>
                                            <my-radio v-model="step3.value" label="否" :key-value="0"></my-radio>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-btn">
                                    <p class="btn" @click="preStep">上一题</p>
                                    <p class="btn" @click="nextStep">下一题</p>
                                </div>
                            </div>
                            <!--第四题-->
                            <div class="step-list" :class="{'step-show': step === 4, 'step-hide': step > 4}">
                                <div class="step step4">
                                    <p class="subject-tit"><em class="num">04</em>最近连续3年社保缴纳是否超过2倍基数？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step4.value" label="对应社保缴费基数比例" :key-value="0"></my-radio>
                                            <my-radio v-model="step4.value" label="高于社保缴费基数比例" :key-value="1"></my-radio>
                                            <my-radio v-model="step4.value" label="低于社保缴费基数比例" :key-value="2"></my-radio>
                                            <my-radio v-model="step4.value" label="未正常缴纳个税（包括申报0个税）" :key-value="3"></my-radio>
                                        </div>
                                        <div class="calc-trip">
                                            <em class="xx-iconfont icon-tishi"></em>
                                            <div class="calc-trip-bd">
                                                个税计算公式：个税金额=<br>（应发工资-社保个人部分-5000）×税率-速算扣除率
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-btn">
                                    <p class="btn" @click="preStep">上一题</p>
                                    <p class="btn" @click="nextStep">下一题</p>
                                </div>
                            </div>
                            <!--第五题-->
                            <div class="step-list" :class="{'step-show': step === 5, 'step-hide': step > 5}">
                                <div class="step step5">
                                    <p class="subject-tit"><em class="num">05</em>专业技术职称和技能等级</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step5.value" label="持有二级技能等级证书" :key-value="0"></my-radio>
                                            <my-radio v-model="step5.value" label="持有中级技术职称证书" :key-value="1"></my-radio>
                                            <my-radio v-model="step5.value" label="持有一级技能等级证书" :key-value="2"></my-radio>
                                            <my-radio v-model="step5.value" label="持有高级技术职称证书" :key-value="3"></my-radio>
                                            <my-radio v-model="step5.value" label="以上皆无" :key-value="4"></my-radio>
                                        </div>
                                    </div>
                                </div>
                                <div class="step-btn">
                                    <p class="btn" @click="preStep">上一题</p>
                                    <p class="btn" @click="nextStep">下一题</p>
                                </div>
                            </div>
                            <!--第六题-->
                            <div class="step-list" :class="{'step-show': step === 6, 'step-hide': step > 6}">
                                <div class="step step6">
                                    <p class="subject-tit"><em class="num">06</em>是否有违反以下情况的记录？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step6.value" label="未婚先育、超生等违反计划生育情况" :key-value="0"></my-radio>
                                            <my-radio v-model="step6.value" label="有行政处罚、违法犯罪记录" :key-value="1"></my-radio>
                                            <my-radio v-model="step6.value" label="有未撤销的高等教育院校处分、党纪处分记录" :key-value="2"></my-radio>
                                            <my-radio v-model="step6.value" label="持有高级技术职称证书" :key-value="3"></my-radio>
                                            <my-radio v-model="step6.value" label="以上皆无" :key-value="4"></my-radio>
                                        </div>
                                    </div>
                                    <div class="step-btn">
                                        <p class="btn" @click="preStep">上一题</p>
                                        <p class="btn" @click="nextStep">下一题</p>
                                    </div>
                                </div>
                            </div>
                            <!--第七题-->
                            <div class="step-list" :class="{'step-show': step === 7, 'step-hide': step > 7}">
                                <div class="step step7">
                                    <p class="subject-tit"><em class="num">07</em>就职单位机构性质及资质</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step7.value" label="普通民营企业" :key-value="0"></my-radio>
                                            <my-radio v-model="step7.value" label="国有企业" :key-value="1"></my-radio>
                                            <my-radio v-model="step7.value" label="外资企业" :key-value="2"></my-radio>
                                            <my-radio v-model="step7.value" label="以上皆无" :key-value="3"></my-radio>
                                        </div>
                                        <div class="record-box">
                                            <div class="selete-box" :class="step7.extra.value !='请选择' ? 'selete-box-have':''">
                                                <p class="selete-box-text">是否具备以下资质</p>
                                                <div class="selete-box-bd" @click="onSelectChange7" id="record">
                                                    <p class="picker-text">{{step7.extra.value}}</p>
                                                    <p class="text">
                                                        <em class="xx-iconfont icon-xialasanjiao"></em>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="step-btn">
                                        <p class="btn" @click="preStep">上一题</p>
                                        <p class="btn" @click="nextStep">下一题</p>
                                    </div>
                                </div>
                            </div>
                            <!--第八题-->
                            <div class="step-list" :class="{'step-show': step === 8, 'step-hide': step > 8}">
                                <div class="step mstep8">
                                    <p class="subject-tit"><em class="num">08</em>是否符合以下条件？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step8.value" label="获重大贡献奖励" :key-value="0"></my-radio>
                                            <my-radio v-model="step8.value" label="在远郊地区教育岗位工作满5年" :key-value="1"></my-radio>
                                            <my-radio v-model="step8.value" label="在远郊地区卫生岗位工作满5年" :key-value="2"></my-radio>
                                            <my-radio v-model="step8.value" label="以上皆无" :key-value="3"></my-radio>
                                        </div>
                                    </div>
                                    <div class="step-btn">
                                        <p class="btn" @click="preStep">上一题</p>
                                        <p class="btn" @click="nextStep">下一题</p>
                                    </div>
                                </div>
                            </div>
                            <!--第九题-->
                            <div class="step-list" :class="{'step-show': step === 9, 'step-hide': step > 9}">
                                <div class="step step9">
                                    <p class="subject-tit"><em class="num">09</em>是否最近3年计税薪酬收入高于上年同行业中级技术、技能或者管理岗位年均薪酬收入水平的技术管理和关键岗位人员的收入？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step9.value" label="是" :key-value="0"></my-radio>
                                            <my-radio v-model="step9.value" label="否" :key-value="1"></my-radio>
                                        </div>
                                    </div>
                                    <div class="step-btn">
                                        <p class="btn" @click="preStep">上一题</p>
                                        <p class="btn" @click="nextStep">下一题</p>
                                    </div>
                                </div>
                            </div>
                            <!--第十题-->
                            <div class="step-list" :class="{'step-show': step === 10, 'step-hide': step > 10}">
                                <div class="step step10">
                                    <p class="subject-tit"><em class="num">10</em>企业主在本市直接投资（或者投资份额），最近连续3个纳税年度累计缴纳总额及每年最低缴纳额是否达到本市规定标准，或者连续3年聘用上海市员工人数达到规定标准？</p>
                                    <div class="subject-con">
                                        <div class="radio-box">
                                            <my-radio v-model="step10.value" label="是" :key-value="0"></my-radio>
                                            <my-radio v-model="step10.value" label="否" :key-value="1"></my-radio>
                                        </div>
                                    </div>
                                    <div class="step-btn">
                                        <p class="btn" @click="preStep">上一题</p>
                                        <p class="btn" @click="nextStep">提交</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <transition name="fade">
                            <div class="error error-show" v-if="isShowError">
                                <p class="info">{{errMsg}}</p>
                            </div>
                        </transition>
                    </div>
                </div>
            </div>
        </div>
        <div class="chang-service service-chang form-all m-j-common-form">
            <div class="form test-form j-form">
                <p class="xx-iconfont icon-icon-1 form-close">
                    <br/>
                </p>
                <div class="form-tit tc">
                    <div class="success-info">
                        <p class="info"><em class="xx-iconfont icon-tijiaochenggong"></em>提交成功</p>
                        <p class="desc">您的自测选项已提交成功！<br>请填写您的联系方式用于接收自测结果</p>
                    </div>
                </div>
                <div class="form-bd">
                    <div class="form-list clearfix">
                        <p class="form-list-hd fl">
                            您的称呼
                        </p>
                        <p class="form-list-bd fl">
                            <input type="text" autocomplete="off" name="name" class="name" placeholder=""/><strong class="form-input-error"></strong>
                        </p>
                    </div>
                    <div class="form-list clearfix">
                        <p class="form-list-hd fl">
                            您的手机号码
                        </p>
                        <p class="form-list-bd fl">
                            <input type="tel" autocomplete="off" name="phone" class="phone" placeholder=""/><strong class="form-input-error"></strong>
                        </p>
                    </div>
                    <div class="img-code">
                        <input type="text" autocomplete="off" name="code" class="code-in" placeholder="请输入验证码"/><strong class="code-i">&nbsp;</strong>
                    </div>
                </div>
                <div class="form-ft tc">
                    <p class="m_xn_btn submit j-submit">
                        提 交
                    </p>
                    <p class="trip">
                        *为了您的利益和我们的口碑，您的信息将被我们严格保密！
                    </p>
                </div>
            </div>
            <div class="success tc j-form-success">
                <p class="xx-iconfont icon-icon-1 form-close" @click="window.location.reload();">
                    <br/>
                </p>
                <div class="success-intro">
                    <em class="xx-iconfont icon-tijiaochenggong"></em>
                    <p class="info">
                        提交成功
                    </p>
                </div>
                <p class="desc">
                    您的服务申请已提交<br/>服务站将在1个工作日内与你沟通服务细节。
                </p>
                <p class="m_xn_btn timer">
                    关闭 03s
                </p>
            </div>
        </div>
    </div>
    <div class="mask"></div>
@endverbatim
