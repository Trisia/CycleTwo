<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/14
 * Time: 10:18
 */

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
    <title>历史记录</title>
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>
    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">
    <link rel="stylesheet" href="../../../css/lendRecord.css">
</head>


<body>

<div id="container">

    <div id="headbox">
        <div id="block"></div>
    </div>

    <div class="content">
        <div id="resizetablebox">
            <!--            <div id="tablebox">-->
            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>历史记录</legend>
            </fieldset>
            <table id="tablebox" class="layui-table" lay-even="" lay-skin="nob">
                <colgroup>
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                </colgroup>

                <thead>
                <tr style="position: relative">
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>车牌</th>
                    <th>费用/元</th>
                </tr>
                </thead>

                <tbody id="tablebody">

                </tbody>

            </table>
            <div class="morebox"><a id="showMore">更 多</a></div>
            <!--            </div>-->
        </div>

        <div id="pagingbox" style="margin: auto">
            <div id="pagecontent" class="page-style"></div>
        </div>

    </div>
</div>


</body>
<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/basicUtil.js"></script>
<script src="../../../js/lendRecord.js"></script>

</html>