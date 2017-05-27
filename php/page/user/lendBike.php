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
    <title>租车</title>
    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">
    <link rel="stylesheet" href="../../../css/lendbike.css">
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>

</head>


<body>

<div id="container">

    <div id="headbox">
        <div id="block"></div>
    </div>

    <div class="content">
        <div id="resizetablebox">
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>借车辆</legend>
            </fieldset>
            <table class="layui-table customer-table" id="tablebox" lay-skin="nob">
                <colgroup>
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                </colgroup>

                <thead>
                <tr>
                    <th>CycleTow车牌</th>
                    <th>位置</th>
                    <th>状态</th>
                    <th>功能</th>
                </tr>
                </thead>

                <tbody id="tablebody">
                </tbody>
            </table>

        </div>

        <div id="pagingbox" style="margin: auto">
            <div id="pagecontent" class="page-style"></div>
        </div>

    </div>
</div>





</body>
<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/lendBike.js"></script>
<script>


</script>

</html>