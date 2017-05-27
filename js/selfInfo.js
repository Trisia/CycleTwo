/**
 * Created by Cliven on 2017/5/14.
 */


layui.use(['layer'], function () {

    var modifyUrl = "../../controller/user/modify.php",
        getInfoUrl = "../../controller/user/getUserInfo.php",
        modifyPwdUrl = "../../controller/user/modifyPwd.php"
        , uploadUrl = "../../controller/upload.php";


    var modifytrigger = $('#modifybutton')
        , modifyPwdFrom = $('.modify-password-form')
        , modifypwd = $("#modifypwd")
        , baiscInfo = $("#baiscInfo")
        , mphoneChange = $('#mphoneChange')
        , emailChange = $("#emailChange")
        , motal = $('#motal')
        , avatar = $('#avatar')
        , uploadImg = $('#uploadImg')
        , gmotal = $('#gmotal')
        , tuples = $('.tuple')
        , alltupleInput = $('.tuple input')
        , mphonebox = $('#mphonebox')
        , emailebox = $('#emailebox');


    /**
     * 事件绑定
     */
    function EventBind() {

        /**
         * 头像点击触发上传时间
         */
        motal.on('click', function () {
            // 触发上传
            document.getElementById("uploadImg").click();
        });

        alltupleInput.on('focus', function () {
            utils.openMotal(gmotal);
            return false;
        });
        alltupleInput.on('blur', function () {
            utils.closeMotal(gmotal);
            return false;
        });


        // 切换修改密码点击
        modifytrigger.on('click', function () {
            animateModify();
        });

        // 修改密码点击
        modifypwd.on('click', function () {
            var str = $("#newpwd").val();
            var reg = /^\w{6,12}$/;
            if (!str.match(reg)) {
                utils.shakebox($("#modifyPassword"));
                utils.pterr("密码大于 6 小于12 不能包含特殊字符");
            } else if ($("#newpwd").val() !== $("#renewpwd").val()) {
                utils.shakebox($("#modifyPassword"));
                utils.pterr("两次密码不一致");
            } else {

                $.post(modifyPwdUrl, {
                    password: $("#password").val(),
                    newpwd: $("#newpwd").val(),
                    renewpwd: $("#renewpwd").val()
                }, function (response) {
                    try {
                        utils.doafterResponse(response);
                        layer.msg(response.message);
                        animateModify();
                    }
                    catch (err) {
                        utils.shakebox($("#modifyPassword"));
                        utils.pterr(err);
                    }
                });
            }
            return false;
        });

        // 手机号修改
        mphoneChange.on('click', function () {


            var str = $("#mphone").val();
            var reg = /^1\d{9}\d$/;

            if (!str.match(reg)) {
                utils.shakebox(mphonebox);
                utils.pterr("请输入正确的手机号");
            } else {
                $.post(modifyUrl, {
                    id: userid,
                    mphone: $("#mphone").val()
                }, function (response) {
                    try {
                        console.log(response);
                        var data = utils.doafterResponse(response);
                        layer.msg("修改成功");
                    } catch (err) {
                        utils.shakebox(mphonebox);
                        utils.pterr(err);
                    }
                });
            }
            return false;
        });

        // 邮箱修改
        emailChange.on('click', function () {

            var str = $(this).val();
            var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;

            if (!str.match(reg)) {
                utils.shakebox(emailebox);
                utils.pterr("请输入正确的邮箱");
            } else {

                $.post(modifyUrl, {
                    id: userid,
                    email: $("#email").val()
                }, function (response) {
                    try {
                        console.log(response);
                        var data = utils.doafterResponse(response);
                        layer.msg("修改成功");
                    } catch (err) {
                        utils.shakebox(emailebox);
                        utils.pterr(err);
                    }
                });
            }
            return false;
        });

        // 点击条目之后触发 文本框获取焦点
        tuples.on('click', function () {
            // console.log("ok");
            $('input', this).focus();
            return false;
        });

        /**
         * 文件选择完成后 直接上传
         */
        uploadImg.on('change', function () {
            // 新建表单对象
            var formData = new FormData();
            // 填充表单
            formData.append("avatar", this.files[0]);
            $.ajax({
                type: "POST"
                , url: uploadUrl
                , processData: false
                , contentType: false
                , data: formData
                , success: function (response) {
                    console.log("上传成功");
                    // console.log(response);
                    // 切换头像
                    changeAvatar(response)
                }
                , error: function (response) {
                    // console.log("上传失败，请重试");
                    utils.pterr("上传失败，请重试");
                    // console.log(response)
                }
            });
        })


    }

    // ************************* 动画开始 *******************************


    /**
     * 头像切换动画
     * @param response
     */
    function changeAvatar(response) {
        try {
            var data = utils.doafterResponse(response);
            avatar.addClass("saleMin");
            setTimeout(function () {
                avatar.attr('src', data.path);

            }, 320);
            avatar.get(0).onload = function () {
                avatar.toggleClass("saleMin");
            };
        }
        catch (err) {
            utils.pterr(err);
        }
    }

    /**
     * 动画弹出修改密码
     */
    function animateModify() {
//        modifytrigger.toggle();
        if (modifytrigger.text() == "修改密码")
            modifytrigger.text("收 起");
        else
            modifytrigger.text("修改密码");
        modifyPwdFrom.animate({
            height: 'toggle',
            opacity: 'toggle'
        }, '200');
    }


    // ************************* 动画结束 ******************************

    /**
     * 调用接口获取基础信息
     */
    function getInfo() {

        $.post(getInfoUrl, {id: userid}, function (response) {
            try {
                var data = utils.doafterResponse(response);
                for (var item in data) {
                    var dom = $("#" + item);
                    if (dom.length > 0) {
                        if (dom.is('input'))
                            dom.val(data[item]);
                        else if (dom.is('img'))
                            dom.attr('src', data[item]);
                        else
                            dom.text(data[item]);
                    }
                }
            }
            catch (err) {
                utils.pterr(err);
            }
        });
    }


    // ************************* 监听器开始 ******************************


    // 初始化
    $(function () {
        getInfo();
        EventBind();
    })
    // ************************* 监听器结束 ******************************

});
