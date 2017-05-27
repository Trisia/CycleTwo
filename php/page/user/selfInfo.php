<?php

include(dirname(__FILE__) . "/../../utils/Util.php");
Util::routing(2);
$username = $_SESSION["username"];
$userType = $_SESSION["userType"];
$userid = $_SESSION["userid"];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>个人信息</title>

    <!--    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">-->
    <link rel="stylesheet" href="../../../css/baseStyle.css">
    <link rel="stylesheet" href="../../../css/selfInfo.css">
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>
</head>
<body style="height: 100%; width: 100%">

<div class="container">
    <div id="avatarContainer">
        <div>
            <img id="avatar" src="" alt="">
        </div>
        <div id="motal" class="motal">
            <div id="imgTitle">
                <span>修改头像</span>
                <span><input id="uploadImg" name="avatar" accept="image/png,image/git,image/jpeg" type="file"></span>
            </div>
        </div>
    </div>

    <div class="content">
        <form action="" id="baiscInfo">
            <div id="usernamebox" data-id="" class="item">
                <h2 id="username"></h2>
            </div>
            <h3>手机号</h3>
            <div id="mphonebox" class="item">

                <div class="tuple">
                    <input id="mphone" class="" type="text" style="text-align: center" value="">&nbsp;&nbsp;|
                    <a class="btn-right ativ" id="mphoneChange">修 改</a>
                </div>

            </div>
            <h3>邮箱</h3>
            <div id="emailebox" class="item">

                <div class="tuple">
                    <input id="email" class="input-left" type="text" style="text-align: center" value="">&nbsp;&nbsp;|
                    <a class="btn-right ativ" id="emailChange">修 改</a>
                </div>
            </div>

            <a class="btn" id="modifybutton">修改密码</a>
        </form>

        <div id="modifyPassword" class="item">
            <form class="modify-password-form">
                <br><br>
                <div id="passwordbox" class="tuple">
                    <a class="btn-left" disabled>原密码</a>&nbsp;&nbsp;|
                    <input type="password" class="input-right" id="password" placeholder="原密码" name="password">
                </div>
                <br>
                <div id="newpwdbox" class="tuple">
                    <a class="btn-left" disabled>新密码</a>&nbsp;&nbsp;|
                    <input type="password" class="input-right" id="newpwd" placeholder="新密码" name="newpwd">
                </div>
                <br>
                <div id="renewpwdbox" class="tuple">
                    <a class="btn-left" disabled>再一次</a> |
                    <input type="password" class="input-right" id="renewpwd" placeholder="重复密码" name="renewpwd">
                </div>
                <br>
                <a type="button" class="btn-sure ativ" id="modifypwd">修 改</a>
            </form>
        </div>
    </div>

</div>

<!--模态框-->
<div id="gmotal" class="gmotal"></div>
</body>

<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/basicUtil.js"></script>
<script src="../../../js/selfInfo.js"></script>

</html>