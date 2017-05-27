<?php

include(dirname(__FILE__) . "/../../utils/Util.php");
Util::routing(1);
$username = $_SESSION["username"];
$userType = $_SESSION["userType"];
$userid = $_SESSION["userid"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>车辆管理</title>
    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">
    <link rel="stylesheet" href="../../../css/bikeManage.css">
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>


</head>


<body>

<div id="container">
<!---->
<!--    <div id="headbox">-->
<!--        <div id="block"></div>-->
<!--    </div>-->

    <div class="content">
        <div id="resizetablebox">


            <div id="mutilconditionbox">
                <div id="addnewBikebox">
                    <a id="addnewbike">添加的CycleTwo单车</a>
                </div>
                <form id="conditionbox" class="condition">

                    <div id="search_islendbox">
                        <span>使用状态:</span>
                        <a data-is_lend="">全部</a>
                        <a data-is_lend="0">空闲</a>
                        <a data-is_lend="1">使用中</a>
                        <input type="number" id="is_lend" name="is_lend" style="display: none" value="">
                    </div>

                    <div id="search_bikestatebox">
                        <span>车辆状态:</span>
                        <a data-bikestate="">全部</a>
                        <a data-bikestate="1">正常</a>
                        <a data-bikestate="2">损坏</a>
                        <a data-bikestate="3">待维修</a>
                        <input type="number" id="bikestate" name="bikestate" style="display: none" value="">
                    </div>

                    <div id="search_positionbox">
                        <span>车辆位置:</span>
                        <label for="lng"><strong>经度:</strong></label>
                        <input type="number" class="" name="lng" placeholder="">
                        <span>-</span>
                        <input type="number" class="" name="lng" placeholder="">
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <label for="lat"><strong>纬度:</strong></label>
                        <input type="number" class="" name="lat" placeholder="">
                        <span>-</span>
                        <input type="number" class="" name="lat" placeholder="">
                    </div>
                    <div id="search_keywordbox">
                        <span>关键字:</span>
                        <input type="text" name="keyword" id="mo" placeholder="请输入模糊关键字">
                    </div>

                    <div id="search_ptimebox">
                        <span>购买时间:</span>
                        <label for="lng">从</label>
                        <input type="date" name="ptime" placeholder="">
                        <span>到</span>
                        <input type="date" name="ptime" placeholder="">
                    </div>

                    <div id="confirmbox">
                        <a id="confirm">搜 索</a>
                    </div>
                </form>
            </div>


            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>借车辆</legend>
            </fieldset>
            <table id="tablebox" class="layui-table" lay-skin="nob">
                <colgroup>
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                    <col class="col-class">
                </colgroup>

                <thead>
                <tr>
                    <th>CycleTow车牌</th>
                    <th>位置</th>
                    <th>车辆状态</th>
                    <th>使用状态</th>
                    <th>采购时间</th>
                    <th>功能</th>
                </tr>
                </thead>


                <tbody id="tablebody">
                </tbody>
            </table>
            <div id="pagingbox" style="margin: auto">
                <div id="pagecontent" class="page-style"></div>
            </div>

        </div>

    </div>

</div>

</body>
<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/basicUtil.js"></script>
<script src="../../../js/bikeManage.js"></script>
</html>
