webpackJsonp([1],{127:function(t,a){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a["default"]={data:function(){return{firstOut:!1,secondIn:!1,secondOut:!1,thirdIn:!1,thirdOut:!1,fourthIn:!1,fourthOut:!1,warning:!1,warningTips:"",success:!1,loadingLabel:"提交中...",roomBind:{area:"",building:"",roomname:"",warnpush:!0},buildingList:{ly:["风槐斋","红榴斋","海桐斋","聚翰斋","凌霄斋","米兰斋","木棉斋","蓬莱公寓","山茶斋","桃李斋","银桦斋","雨鹃斋"],qy:["乔木阁","乔林阁","乔森阁","乔相阁","乔梧阁"],xy:["丹枫轩","丁香阁","杜衡阁","海棠阁","木犀轩","石楠轩","疏影阁","苏铁轩","文杏阁","辛夷阁","云杉轩","芸香阁","韵竹阁","紫檀轩","紫藤轩"],ny:["春笛","夏筝","秋瑟","冬筑"]}}},ready:function(){var t=this;this.$http.get("http://www.wacxt.cn/powerusage/action.php",{a:"getUser"}).then(function(a){if(a.data.status)return void t.$router.go("/")}),document.title="欢迎使用用电查询2.0 - 深大百科"},methods:{to2:function(){this.firstOut=this.secondIn=!0},checkArea:function(t){this.roomBind.area=t,this.secondIn=!1,this.secondOut=this.thirdIn=!0},backTo2:function(){this.secondIn=!0,this.secondOut=this.thirdIn=!1},warnpushswitch:function(){this.roomBind.warnpush=!this.roomBind.warnpush},pushData:function(){var t=this;return this.roomBind.roomname&&this.roomBind.building?(this.thirdIn=!1,this.thirdOut=this.fourthIn=!0,void this.$http.post("http://www.wacxt.cn/powerusage/action.php?a=bind",this.roomBind).then(function(a){200===a.status&&(a.data.status?(t.loadingLabel="绑定成功！点击下面的按钮开始体验吧！",t.success=!t.success):a.data.status||1!==a.data.errcode?(t.thirdIn=!0,t.thirdOut=t.fourthIn=!1,t.warningTips="黑人问号？？？",t.warning=!0,setTimeout(function(){t.warning=!1},2e3)):(t.thirdIn=!0,t.thirdOut=t.fourthIn=!1,t.warningTips="宿舍号不存在哦！看看是不是填错了~",t.warning=!0,setTimeout(function(){t.warning=!1},2e3)))},function(){t.thirdIn=!0,t.thirdOut=t.fourthIn=!1,t.warningTips="服务器错误或网络有问题！稍后重试吧！",t.warning=!0,setTimeout(function(){t.warning=!1},2e3)})):(this.warningTips="宿舍楼要选，宿舍号要填哦！",this.warning=!0,void setTimeout(function(){t.warning=!1},2e3))}},computed:{inputHidden:function(){return this.roomBind.roomname}}}},128:function(t,a,i){a=t.exports=i(129)(),a.push([t.id,".introPage[_v-47a653da]{background:#dcf4fd}.introPage .page[_v-47a653da],.introPage[_v-47a653da]{position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden}.introPage .page[_v-47a653da]{padding:20px}.introPage .first[_v-47a653da]{color:#224b5a}.introPage .first h1[_v-47a653da]{margin-top:50px;font-size:42px;text-align:center}.introPage .first p[_v-47a653da]{margin-top:10px;text-indent:2em;text-align:justify}.introPage .first button[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .first button[_v-47a653da]:active{color:#fff;background:#224b5a}.introPage .second[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .second h2[_v-47a653da]{font-size:28px;text-align:center}.introPage .second button[_v-47a653da]{margin-top:20px;width:100%;height:60px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:4px}.introPage .second button[_v-47a653da]:active{color:#fff;background:#224b5a}.introPage .third[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .third .warn[_v-47a653da]{position:absolute;left:0;top:0;width:100%;height:40px;background:#f45757;color:#fff;text-align:center;-webkit-transition:.3s ease;transition:.3s ease;-webkit-transform:translateY(-100%);transform:translateY(-100%)}.introPage .third .warn p[_v-47a653da]{font-size:14px;font-weight:700;line-height:40px}.introPage .third .warning[_v-47a653da]{-webkit-transform:translateY(0);transform:translateY(0)}.introPage .third .backBtn[_v-47a653da]{position:absolute;top:40px;left:20px}.introPage .third h2[_v-47a653da]{font-size:28px;text-align:center}.introPage .third label[_v-47a653da]{margin-top:10px;line-height:30px}.introPage .third input[_v-47a653da],.introPage .third select[_v-47a653da]{margin-top:10px;margin-bottom:10px;padding-left:10px;width:100%;height:40px;color:#224b5a;font-size:16px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:4px}.introPage .third .switch[_v-47a653da]{float:right;width:54px;height:30px;background:#ccc;border-radius:15px;-webkit-transition:.2s ease;transition:.2s ease}.introPage .third .switch[_v-47a653da]:after{position:relative;left:2px;top:2px;content:'';width:26px;height:26px;background:#fff;border-radius:13px;-webkit-transition:.2s ease;transition:.2s ease;display:block}.introPage .third .switchOn[_v-47a653da]{background:#4be396}.introPage .third .switchOn[_v-47a653da]:after{-webkit-transform:translateX(24px);transform:translateX(24px)}.introPage .third .submit[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .third .submit[_v-47a653da]:active{color:#fff;background:#224b5a}.introPage .fourth[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .fourth .loadingContainer[_v-47a653da]{position:absolute;top:100px;left:50%;width:100px;height:100px;margin-left:-50px;border-radius:50px;background:#224b5a}.introPage .fourth .loadingContainer .loading[_v-47a653da]{position:absolute;top:10px;left:50px;width:1px;height:80px;background:transparent;-webkit-animation:rotate 1s linear infinite;animation:rotate 1s linear infinite}.introPage .fourth .loadingContainer .loading[_v-47a653da]:before{content:'';position:absolute;left:-5px;width:12px;height:12px;border-radius:6px;background:#fff;display:block}.introPage .fourth .loadingContainer .s[_v-47a653da]{position:absolute;top:0;left:0;width:100px;height:100px;border-radius:50px;background:#65e67d;-webkit-transition:.5s ease;transition:.5s ease;-webkit-transform:scale(0);transform:scale(0);z-index:10}.introPage .fourth .loadingContainer .s .gou[_v-47a653da]{position:absolute;left:25px;top:35px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.introPage .fourth .loadingContainer .s .gou .left[_v-47a653da]{width:4px;height:20px;background:#fff;-webkit-transition:.2s ease .3s;transition:.2s ease .3s;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scaleY(0);transform:scaleY(0)}.introPage .fourth .loadingContainer .s .gou .right[_v-47a653da]{width:50px;height:4px;background:#fff;-webkit-transition:.3s ease .5s;transition:.3s ease .5s;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scaleX(0);transform:scaleX(0)}.introPage .fourth .loadingContainer .success .gou .left[_v-47a653da],.introPage .fourth .loadingContainer .success .gou .right[_v-47a653da],.introPage .fourth .loadingContainer .success[_v-47a653da]{-webkit-transform:scale(1);transform:scale(1)}.introPage .fourth .loadingLabel[_v-47a653da]{position:absolute;top:220px;left:0;width:100%}.introPage .fourth .loadingLabel p[_v-47a653da]{font-size:16px;text-align:center}.introPage .fourth .submit[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .fourth .submit[_v-47a653da]:active{color:#fff;background:#224b5a}.introPage .slideOut[_v-47a653da]{-webkit-transition:.5s ease;transition:.5s ease;-webkit-transform:translateX(-100%) translateZ(0);transform:translateX(-100%) translateZ(0)}.introPage .slideIn[_v-47a653da]{-webkit-transition:.5s ease;transition:.5s ease;-webkit-transform:translateX(0) translateZ(0);transform:translateX(0) translateZ(0)}.introPage .footer[_v-47a653da]{position:absolute;left:0;bottom:5px;width:100%}.introPage .footer p[_v-47a653da]{color:#b0d3e5;font-size:12px;text-align:center}.fade-transition[_v-47a653da]{-webkit-transition:all .7s ease .5s;transition:all .7s ease .5s}.fade-enter[_v-47a653da],.fade-leave[_v-47a653da]{opacity:0}@-webkit-keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}","",{version:3,sources:["/./src/views/intro.vue"],names:[],mappings:"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",file:"intro.vue",sourcesContent:[".introPage[_v-47a653da]{position:absolute;top:0;left:0;width:100%;height:100%;background:#dcf4fd;overflow:hidden}.introPage .page[_v-47a653da]{position:absolute;top:0;left:0;width:100%;height:100%;padding:20px;overflow:hidden}.introPage .first[_v-47a653da]{color:#224b5a}.introPage .first h1[_v-47a653da]{margin-top:50px;font-size:42px;text-align:center}.introPage .first p[_v-47a653da]{margin-top:10px;text-indent:2em;text-align:justify}.introPage .first button[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .first button[_v-47a653da]:active{color:#FFF;background:#224b5a}.introPage .second[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .second h2[_v-47a653da]{font-size:28px;text-align:center}.introPage .second button[_v-47a653da]{margin-top:20px;width:100%;height:60px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:4px}.introPage .second button[_v-47a653da]:active{color:#FFF;background:#224b5a}.introPage .third[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .third .warn[_v-47a653da]{position:absolute;left:0;top:0;width:100%;height:40px;background:#F45757;color:#FFF;text-align:center;-webkit-transition:300ms ease;transition:300ms ease;-webkit-transform:translateY(-100%);transform:translateY(-100%)}.introPage .third .warn p[_v-47a653da]{font-size:14px;font-weight:bold;line-height:40px}.introPage .third .warning[_v-47a653da]{-webkit-transform:translateY(0);transform:translateY(0)}.introPage .third .backBtn[_v-47a653da]{position:absolute;top:40px;left:20px}.introPage .third h2[_v-47a653da]{font-size:28px;text-align:center}.introPage .third label[_v-47a653da]{margin-top:10px;line-height:30px}.introPage .third select[_v-47a653da]{margin-top:10px;margin-bottom:10px;padding-left:10px;width:100%;height:40px;color:#224b5a;font-size:16px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:4px}.introPage .third input[_v-47a653da]{margin-top:10px;margin-bottom:10px;padding-left:10px;width:100%;height:40px;color:#224b5a;font-size:16px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:4px}.introPage .third .switch[_v-47a653da]{float:right;width:54px;height:30px;background:#ccc;border-radius:15px;-webkit-transition:200ms ease;transition:200ms ease}.introPage .third .switch[_v-47a653da]:after{position:relative;left:2px;top:2px;content:'';width:26px;height:26px;background:#FFF;border-radius:13px;-webkit-transition:200ms ease;transition:200ms ease;display:block}.introPage .third .switchOn[_v-47a653da]{background:#4be396}.introPage .third .switchOn[_v-47a653da]:after{-webkit-transform:translateX(24px);transform:translateX(24px)}.introPage .third .submit[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .third .submit[_v-47a653da]:active{color:#FFF;background:#224b5a}.introPage .fourth[_v-47a653da]{padding:20px 40px;color:#224b5a;-webkit-transform:translateX(100%);transform:translateX(100%)}.introPage .fourth .loadingContainer[_v-47a653da]{position:absolute;top:100px;left:50%;width:100px;height:100px;margin-left:-50px;border-radius:50px;background:#224b5a}.introPage .fourth .loadingContainer .loading[_v-47a653da]{position:absolute;top:10px;left:50px;width:1px;height:80px;background:transparent;-webkit-animation:rotate 1s linear infinite;animation:rotate 1s linear infinite}.introPage .fourth .loadingContainer .loading[_v-47a653da]:before{content:'';position:absolute;left:-5px;width:12px;height:12px;border-radius:6px;background:#FFF;display:block}.introPage .fourth .loadingContainer .s[_v-47a653da]{position:absolute;top:0;left:0;width:100px;height:100px;border-radius:50px;background:#65e67d;-webkit-transition:500ms ease;transition:500ms ease;-webkit-transform:scale(0);transform:scale(0);z-index:10}.introPage .fourth .loadingContainer .s .gou[_v-47a653da]{position:absolute;left:25px;top:35px;-webkit-transform:rotate(-45deg);transform:rotate(-45deg)}.introPage .fourth .loadingContainer .s .gou .left[_v-47a653da]{width:4px;height:20px;background:#FFF;-webkit-transition:200ms ease 300ms;transition:200ms ease 300ms;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scale(1, 0);transform:scale(1, 0)}.introPage .fourth .loadingContainer .s .gou .right[_v-47a653da]{width:50px;height:4px;background:#FFF;-webkit-transition:300ms ease 500ms;transition:300ms ease 500ms;-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:scale(0, 1);transform:scale(0, 1)}.introPage .fourth .loadingContainer .success[_v-47a653da]{-webkit-transform:scale(1);transform:scale(1)}.introPage .fourth .loadingContainer .success .gou .left[_v-47a653da]{-webkit-transform:scale(1, 1);transform:scale(1, 1)}.introPage .fourth .loadingContainer .success .gou .right[_v-47a653da]{-webkit-transform:scale(1, 1);transform:scale(1, 1)}.introPage .fourth .loadingLabel[_v-47a653da]{position:absolute;top:220px;left:0;width:100%}.introPage .fourth .loadingLabel p[_v-47a653da]{font-size:16px;text-align:center}.introPage .fourth .submit[_v-47a653da]{position:absolute;left:50%;bottom:40px;margin-left:-100px;width:200px;height:40px;color:#224b5a;font-size:18px;line-height:36px;background:#dcf4fd;border:1px solid #224b5a;border-radius:20px}.introPage .fourth .submit[_v-47a653da]:active{color:#FFF;background:#224b5a}.introPage .slideOut[_v-47a653da]{-webkit-transition:500ms ease;transition:500ms ease;-webkit-transform:translateX(-100%) translateZ(0);transform:translateX(-100%) translateZ(0)}.introPage .slideIn[_v-47a653da]{-webkit-transition:500ms ease;transition:500ms ease;-webkit-transform:translateX(0) translateZ(0);transform:translateX(0) translateZ(0)}.introPage .footer[_v-47a653da]{position:absolute;left:0;bottom:5px;width:100%}.introPage .footer p[_v-47a653da]{color:#b0d3e5;font-size:12px;text-align:center}.fade-transition[_v-47a653da]{-webkit-transition:all 700ms ease 500ms;transition:all 700ms ease 500ms}.fade-enter[_v-47a653da],.fade-leave[_v-47a653da]{opacity:0}@-webkit-keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}@keyframes rotate{0%{-webkit-transform:rotate(0);transform:rotate(0)}100%{-webkit-transform:rotate(360deg);transform:rotate(360deg)}}"],sourceRoot:"webpack://"}])},354:function(t,a,i){var o=i(128);"string"==typeof o&&(o=[[t.id,o,""]]);i(366)(o,{});o.locals&&(t.exports=o.locals)},359:function(t,a){t.exports=' <div class=introPage _v-47a653da=""> <section class="page first" :class="{ slideOut: firstOut }" _v-47a653da=""> <h1 _v-47a653da="">Hello!</h1> <p _v-47a653da="">用电查询上线一年来，提供查询的次数已经突破2万，感谢您长久以来的使用。</p> <p _v-47a653da="">今天，我们为您带来了用电查询2.0版本，新版本将会比旧版本更加的稳定。我们可能需要你绑定微信号和宿舍，保证低电费提醒可用。</p> <p _v-47a653da="">点击下面的“开始”按钮，开始体验用电查询2.0！</p> <button @click=to2() _v-47a653da="">开 始</button> </section> <section class="page second" :class="{ slideIn: secondIn, slideOut: secondOut }" _v-47a653da=""> <h2 _v-47a653da="">选择宿舍区</h2> <button @click="checkArea(\'ly\')" _v-47a653da="">荔苑社区</button> <button @click="checkArea(\'qy\')" _v-47a653da="">乔苑社区</button> <button @click="checkArea(\'xy\')" _v-47a653da="">西苑社区</button> <button @click="checkArea(\'ny\')" _v-47a653da="">南苑社区</button> </section> <section class="page third" :class="{ slideIn: thirdIn, slideOut: thirdOut }" _v-47a653da=""> <div class=warn :class="{ warning: warning }" _v-47a653da=""> <p _v-47a653da="">{{ warningTips }}</p> </div> <div class=backBtn @click=backTo2() _v-47a653da=""> <svg width=30 height=30 viewBox="0 0 24 24" _v-47a653da=""> <path fill=#224b5a d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" _v-47a653da=""></path> </svg> </div> <h2 _v-47a653da="">选择宿舍</h2> <label _v-47a653da="">选择宿舍楼：</label> <select v-model=roomBind.building _v-47a653da=""> <option v-for="(index, building) in buildingList[roomBind.area]" :value=building :selected="index === 1" _v-47a653da="">{{building}}</option> </select> <label _v-47a653da="">填写宿舍号：</label> <input type=text v-model=roomBind.roomname debounce=300 _v-47a653da=""> <label _v-47a653da="">低电量提醒：</label> <div class=switch :class="{ switchOn: roomBind.warnpush }" @click=warnpushswitch() _v-47a653da=""></div> <button @click=pushData() class=submit v-show=inputHidden _v-47a653da="">继续</button> </section> <section class="page fourth" :class="{ slideIn: fourthIn, slideOut: fourthOut }" _v-47a653da=""> <div class=loadingContainer _v-47a653da=""> <div class=loading _v-47a653da=""></div> <div class=s :class="{ success: success }" _v-47a653da=""> <div class=gou _v-47a653da=""> <div class=left _v-47a653da=""></div> <div class=right _v-47a653da=""></div> </div> </div> </div> <div class=loadingLabel _v-47a653da=""> <p _v-47a653da="">{{ loadingLabel }}</p> </div> <button v-link="\'/\'" class=submit v-if=success transition=fade _v-47a653da="">开始体验</button> </section> <div class=footer _v-47a653da=""> <p _v-47a653da="">© 2016 深大百科. Jason Presented.</p> </div> </div> '},363:function(t,a,i){var o,e;i(354),o=i(127),e=i(359),t.exports=o||{},t.exports.__esModule&&(t.exports=t.exports["default"]),e&&(("function"==typeof t.exports?t.exports.options||(t.exports.options={}):t.exports).template=e)}});
//# sourceMappingURL=1.77631663fa9a7fb1f0d6.js.map