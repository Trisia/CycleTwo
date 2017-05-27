<?php

include(dirname(__FILE__) . "/../../utils/Util.php");
Util::routing(2);
$username = $_SESSION["username"];
$userType = $_SESSION["userType"];
$userid = $_SESSION["userid"];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>充值</title>
    <!--    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">-->
    <link rel="stylesheet" href="../../../css/baseStyle.css">
    <link rel="stylesheet" href="../../../css/charge.css">
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>

    <style>


    </style>
</head>
<body>
<div class="container">
    <div id="headbox">
        <div id="block"></div>
    </div>
    <div class="content">
<!--        <div id="headbox2">-->
<!--            <div id="block2"></div>-->
<!--        </div>-->
        <p>账户名称: <span id="username"><?php echo $username; ?></span></p>
        <p>账户余额: <span id="balance">-</span> 元</p>
        <div id="chragebox">
            <p>充值金额</p>
            <input type="number" class="input" id="money">
            <p id="tip">充值金额不合法</p>
            <div class="chargeSubmitbox">
                <a class="btn" id="charge">充 值</a>
            </div>
        </div>
    </div>

</div>

</body>

<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/basicUtil.js"></script>
<script src="../../../js/charge.js"></script>
</html>