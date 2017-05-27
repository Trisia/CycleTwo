/**
 * Created by Cliven on 2017/5/11.
 */


var loginUrl = "php/controller/login.php"
    , registerUrl = "php/controller/user/register.php"
    , checkUsernameUrl = "php/controller/user/checkExistByUsername.php"
    , checkMphoneUrl = "php/controller/user/checkExistByPhone.php"
    , checkEmailUrl = "php/controller/user/checkExistByEmail.php";

var loginform = $(".login-form")
    , registerform = $(".register-form")
    , loginUsername = $('#login_form_username input')
    , loginPassword = $('#login_form_password input')
    , registerUsername = $('#register_form_username input')
    , registerPassword = $('#register_form_password input')
    , registerRepwd = $("#register_form_repwd input")
    , registerMphone = $("#register_form_mphone input")
    , registerEmail = $("#register_form_email input")
    , usernameTip = registerUsername.siblings('p')
    , passwordTip = registerPassword.siblings('p')
    , mphoneTip = registerMphone.siblings('p')
    , repwdTip = registerRepwd.siblings('p')
    , emailTip = registerEmail.siblings('p')
    , createBtn = $('#create')
    , flod = $('#flod')
    , userTypeCheckbox = $("#userTypeCheckbox")
    , pupli = $('.pupli')
    , elf = $('#login_form_username .elf')
    , elf2 = $('#login_form_password .elf');


/**
 * 调用登录接口
 */
function login() {

    var data = loginform.serializeObject();
    data.userType = data.userType ? parseInt(data.userType) : 2;
    // console.log(data);

    $.post(loginUrl, data, function (response) {

        try {
            console.log(response);
            utils.doafterResponse(response);
            // 置空
            $('#login_form_password>input').val('');
            console.log("登录成功");
            window.location = "php/page/mainPage.php";

        } catch (err) {
            utils.shakebox($("#login_form form"));
            utils.pterr(err);
        }
    })
}


/**
 * 调用注册接口
 */
function register() {
    var data = registerform.serialize();

    $.post(registerUrl, data, function (response) {
        console.log(response);

        if (!response.success) {
            utils.shakebox(registerform);
        }
        else {
            layer.msg('注册成功');
            // 清空表单
            $("#resetbtn").trigger('click');
            switchform();
        }
    });
    // }
}
// 表单切换
function switchform() {

    $('form').animate({
        height: 'toggle',
        opacity: 'toggle'
    }, 'slow');
}


/**
 * 事件统一绑定
 */
function eventBind() {


    //***************** 表单校检 开始 ************************


    /**
     * 精灵眼睛动画
     */
    loginUsername.on('keyup', function () {
        if (loginUsername.val() != '')
            pupli.addClass('pupli-move');
        else
            pupli.removeClass('pupli-move');
    });


    loginUsername.on('focus', function () {
        elf.addClass('elffocur');
    });

    loginUsername.on('blur', function () {
        elf.removeClass('elffocur');
    });


    /**
     * 精灵眼睛动画（密码）
     */
    loginPassword.on('keyup', function () {

        if (loginPassword.val() != '') {
            $('.pupliJi1').addClass('isactive1');
            $('.lower1').addClass('isactive2');

            $('.pupliJi2').addClass('isactive3');
            $('.lower2').addClass('isactive4');

        }
        else {
            $('.pupliJi1').removeClass('isactive1');
            $('.lower1').removeClass('isactive2');

            $('.pupliJi2').removeClass('isactive3');
            $('.lower2').removeClass('isactive4');
        }

    });

    loginPassword.on('focus', function () {
        elf2.addClass('elffocur');
    });

    loginPassword.on('blur', function () {
        elf2.removeClass('elffocur');
    });


    // 用户名
    registerUsername.on('blur', function () {

        var str = $(this).val();
        var reg = /^\w{3,12}$/;

        if (!str.match(reg)) {
            utils.shakebox($(this));
            usernameTip.text("用户名 大于 3 小于12 不能包含特殊字符");
            utils.toggleAnm(usernameTip);
        } else {
            $.post(checkUsernameUrl, {username: str}, function (response) {
                if (response.exist) {
                    utils.shakebox(registerUsername);
                    usernameTip.text("用户名 已存在");
                    utils.toggleAnm(usernameTip);
                }
            })
        }
    });

    registerUsername.on('focus', function () {
        usernameTip.hide('fast');
    });

    // 密码
    registerPassword.on('blur', function () {
        var str = $(this).val();
        var reg = /^\w{6,12}$/;
        if (!str.match(reg)) {
            utils.shakebox($(this));
            passwordTip.text("密码大于 6 小于12 不能包含特殊字符");
            utils.toggleAnm(passwordTip);
        }
    });
    registerPassword.on('focus', function () {
        passwordTip.hide('fast');
    });

    // 重复密码
    registerRepwd.on('blur', function () {
        var str = $(this).val();

        if (str !== registerPassword.val()) {
            utils.shakebox($(this));
            repwdTip.text("两次密码不一致");
            utils.toggleAnm(repwdTip);
        }

    });

    registerRepwd.on('focus', function () {
        repwdTip.hide('fast');
    });

    // 手机号
    registerMphone.on('blur', function () {
        var str = $(this).val();
        var reg = /^1\d{9}\d$/;

        if (!str.match(reg)) {
            utils.shakebox($(this));
            mphoneTip.text("手机号不合法，请输入合法的11位手机号");
            utils.toggleAnm(mphoneTip);
        } else {
            $.post(checkMphoneUrl, {mphone: str}, function (response) {
                if (response.exist) {
                    utils.shakebox(registerMphone);
                    mphoneTip.text("此手机号已被使用");
                    utils.toggleAnm(mphoneTip);
                }
            })
        }
    });

    registerMphone.on('focus', function () {
        mphoneTip.hide('fast');
    });

    // 邮箱
    registerEmail.on('blur', function () {
        var str = $(this).val();
        var reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;

        if (!str.match(reg)) {
            utils.shakebox($(this));
            emailTip.text("邮箱不合法");
            utils.toggleAnm(emailTip);
        } else {
            $.post(checkEmailUrl, {email: str}, function (response) {
                if (response.exist) {
                    utils.shakebox(registerEmail);
                    emailTip.text("邮箱已存在");
                    utils.toggleAnm(emailTip);
                }
            })
        }
    });

    registerEmail.on('focus', function () {
        emailTip.hide('fast');
    });


    //***************** 表单校检 结束 ************************


    // 隐藏的 用户类型
    flod.on('click', function () {

        flod.text(flod.text() == '︾' ? '︽' : "︾");
        // flod.toggleClass("rotate180");
        utils.toggleAnm(userTypeCheckbox);
        return false;
    });

    // 登录
    $("#login").on('click', login);

    // 注册
    $("#create").on('click', register);


    // enter 事件触发提交
    $(".login-form input").keydown(function (event) {
        if (event.which == 13)
            $("#login").trigger("click");
    });

    // 回车事件触发提交
    $(".register-form input").keydown(function (event) {
        if (event.which == 13)
            $("#create").trigger("click");
    });


    // 注册/登录 上form切换
    $(".message a").on('click', function () {
        switchform();
    });

}

$(function () {
    // 给滑动按钮添加样式
    $('.multi-switch').multiSwitch();

    // 事件绑定
    eventBind();
    // createBtn.attr('disabled', 'true');
    loginUsername.focus();

});