/**
 * main4.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2014, Codrops
 * http://www.codrops.com
 */
(function () {


    var layer = layui.layer;


    // URL
    var homePageUrl = "home.php"
        , selfInfoUrl = "user/selfInfo.php"
        , lendBikeUrl = "user/lendBike.php"
        , usingBikeUrl = "user/usingBike.php"
        , lendRecordUrl = "user/lendRecord.php"
        , chargeUrl = "user/charge.php"
        , bikeManagerUrl = "manage/bikeManage.php"
        , recordAllUrl = "manage/reocrd.php";


    var bodyEl = $('body'),
        content = $(".content-wrap"),
        openbtn = $("#open-button"),    // 开关sidebar 按钮
        subpage = $("#subpage"),        // 子页面
        hamburger = $(".hamburger"),    // 触发按钮
        isOpen = false;                 // 记录siderbar 是否打开


    // siderbar 菜单 连接DOM
    var jumpUserInfo = $('#jumpUserInfo')
        , jumpLend = $("#jumpLend")
        , jumpReturn = $("#jumpReturn")
        , jumpCharge = $("#jumpCharge")
        , jumpHome = $("#jumpHome")
        , jumpRecord = $('#jumpRecord');


    // 动画相关
    var morphEl = document.getElementById('morph-shape'),
        s = Snap(morphEl.querySelector('svg'));

    // snap parameter
    window.path = s.select('path');
    var initialPath = window.path.attr('d'),
        steps = morphEl.getAttribute('data-morph-open').split(';');
    var stepsTotal = steps.length;
    var isAnimating = false;        // 是否在动画中


    /**
     * 触发 开/关 sidebar动画
     */
    function toggleMenu() {
        // if (isAnimating) return false;  // 播放动画的时候不允许触发回收事件
        isAnimating = true;
        bodyEl.toggleClass('show-menu');
        if (isOpen) {
            // animate path
            setTimeout(function () {
                // reset path
                path.attr('d', initialPath);
                isAnimating = false;
            }, 300);
        }
        else {
            // animate path
            var pos = 0,
                nextStep = function (pos) {
                    if (pos > stepsTotal - 1) {
                        isAnimating = false;
                        return;
                    }
                    path.animate({'path': steps[pos]}, pos === 0 ? 400 : 500, pos === 0 ? mina.easein : mina.elastic, function () {
                        nextStep(pos);
                    });
                    pos++;
                };

            nextStep(pos);
        }
        isOpen = !isOpen;
    }

    /**
     * iframe load 时候对ifram 的事件注册
     */
    function iframeLoad() {
        // 点击关闭sidebar
        subpage.contents().find("html").on("click", function () {

            if (isOpen) {
                toggleMenu();
                hamburger.toggleClass("is-active");
            }
        });
    }

    /**
     * iframe 事件注册
     * @param url
     */
    function iframeChangeEvent(url) {
        // 子页面跳转
        subpage.attr("src", url);
        // 开启页面弹出
        hamburger.toggleClass("is-active");
        toggleMenu();

        // 注册子页面关闭事件
        subpage.off("load", iframeLoad);
        subpage.on("load", iframeLoad);
    }


    /**
     * 事件统一注册
     */
    function EventBind() {

        // ********************** 界面折叠菜单按钮 *******************
        openbtn.on('click', toggleMenu);
        // 汉堡button 控制
        hamburger.on('click', function () {
            hamburger.toggleClass("is-active");
        });


    }

    // ********************** 侧面菜单控制 **********************

    function normalUserTpl() {
        return ""
            + '<a id="jumpHome" class="curr"><i class=""></i><span>Home</span></a>'
            + '<a id="jumpUserInfo"><i class=""></i><span>我的信息</span></a>'
            + '<a id="jumpLend"><i class=""></i><span>借车</span></a>'
            + '<a id="jumpReturn"><i class=""></i><span>骑行中单车</span></a>'
            + '<a id="jumpCharge"><i class=""></i><span>账户</span></a>'
            + '<a id="jumpRecord"><i class=""></i><span>记录</span></a>'
            + '<a href="../controller/loginout.php"><i class=""></i><span>退出</span></a>'
    }

    function bikeManagerTpl() {
        return ""
            + '<a id="jumpHome" class="curr"><i class=""></i><span>Home</span></a>'
            + '<a id="jumpbikeManage"><i class=""></i><span>车辆管理</span></a>'
            + '<a id="jumpRecordAll"><i class=""></i><span>记录查询</span></a>'
            + '<a href="../controller/loginout.php"><i class=""></i><span>退出</span></a>'
    }


    /**
     * 普通用户菜单绑定
     */
    function normalUserEventBind() {


        $('#jumpUserInfo').on('click', function () {
            iframeChangeEvent(selfInfoUrl);
        });

        $("#jumpHome").on('click', function () {

            iframeChangeEvent(homePageUrl);
        });

        $("#jumpLend").on('click', function () {
            iframeChangeEvent(lendBikeUrl);
        });
        $("#jumpReturn").on('click', function () {
            iframeChangeEvent(usingBikeUrl);
        });
        $("#jumpCharge").on('click', function () {
            iframeChangeEvent(chargeUrl);
        });

        $('#jumpRecord').on('click', function () {
            iframeChangeEvent(lendRecordUrl);
        });
    }

    /**
     * 车辆管理用户菜单绑定
     */
    function bikeManagerEventBind() {
        $("#jumpRecordAll").on('click', function () {
            iframeChangeEvent(recordAllUrl);
        });
        $("#jumpHome").on('click', function () {
            iframeChangeEvent(homePageUrl);
        });
        $("#jumpbikeManage").on('click', function () {
            iframeChangeEvent(bikeManagerUrl);
        });


    }


    // 页面加载完成后事件
    $(function () {
        // 基本绑定
        EventBind();

        if (userType == 1) {
            $("#menuList").append(bikeManagerTpl());
            bikeManagerEventBind();
        } else {
            $("#menuList").append(normalUserTpl());
            normalUserEventBind();
        }

        // 路径追踪
        $('.icon-list a').on('click', function () {
            $('.icon-list a').removeClass('curr');
            $(this).addClass('curr');
        });
        // 跳转欢迎页面
        iframeChangeEvent(homePageUrl);
    });


})();
