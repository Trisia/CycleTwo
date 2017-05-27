<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/13
 * Time: 14:18
 */
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
    <title>记录查询</title>
    <link rel="stylesheet" href="../../../js/lib/layui/css/layui.css">
    <link rel="stylesheet" href="../../../css/record.css">
    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
    </script>

    <style>

    </style>
</head>


<body>

<div id="container">

<!--    <div id="headbox">-->
<!--        <div id="block"></div>-->
<!--    </div>-->

    <div class="content">
        <div id="resizetablebox">

            <div id="mutilsearchbox">
                <div id="idbox" toggle>
                    <span>记录ID:</span>
                    <label for="id"></label>
                    <input type="number"  id="id" name="id" value="" placeholder="输入记录ID">
                    <span><a id="id_search">搜 索</a></span>
                </div>
                <div id="toggerMoCondition">
                    <a id="more">更多条件</a>
                </div>
                <form id="conditionfrombox" style="display: none" toggle>

                    <div id="search_usernamebox">
                        <label for="username">用户名: </label>
                        <input type="text" id="username" name="username" placeholder="输入用户名" value="">
                    </div>

                    <div id="search_bikecodebox">
                        <label for="bikecode">自行车车牌: </label>
                        <input type="text" id="bikecode" name="bikecode" placeholder="输入车牌" value="">
                    </div>


                    <div id="search_stimebox" class="inputboxMIn">
                        <span>开始时间段: 从</span>
                        <input type="datetime-local" class="" name="stime" placeholder="">
                        <span> 到 </span>
                        <input type="datetime-local" class="" name="stime" placeholder="">
                    </div>
                    <div id="search_etimebox" class="inputboxMIn">
                        <span>结束时间段: 从</span>
                        <input type="datetime-local" class="" name="etime" placeholder="">
                        <span> 到 </span>
                        <input type="datetime-local" class="" name="etime" placeholder="">
                    </div>
                    <div id="search_costbox" class="inputboxMIn">
                        <span>花费金额范围: </span>
                        <input type="number" name="cost" placeholder="" value="">
                        <span>-</span>
                        <input type="number" name="cost" placeholder="" value="">
                        <span>元</span>
                    </div>


                    <div id="toggerSortbox">
                        <a id="sort">排 序</a>
                    </div>

                    <div id="sortRule" style="display: none">
                        <span>排序规则</span>
                        <div class="colortip">
                            <span>不排序</span>
                            <span class="no bord"></span>
                            <span>降序</span>
                            <span class="up bord"></span>
                            <span>升序</span>
                            <span class="down bord"></span>
                        </div>
                        <span><a data-key="id">ID</a></span>
                        <span><a data-key="stime">开始时间</a></span>
                        <span><a data-key="etime">结束时间</a></span>
                        <span><a data-key="cost">花费</a></span>
                    </div>


                    <div id="confirmbox">
                        <a id="confirm">搜 索</a>
                    </div>
                </form>
            </div>


            <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
                <legend>记录查询</legend>
            </fieldset>
            <table id="tablebox" class="layui-table customer-table" id="tablebox" lay-skin="nob">
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
                    <th>记录ID</th>
                    <th>开始时间</th>
                    <th>结束时间</th>
                    <th>CycleTwo车牌</th>
                    <th>用户名</th>
                    <th>花费/元</th>
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
<script src="../../../js/record.js"></script>
</html>

