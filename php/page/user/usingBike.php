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
    <title>骑行中单车</title>
    <link rel="stylesheet" href="../../../css/baseStyle.css">
    <link rel="stylesheet" href="../../../css/usingBike.css">

    <!--    <link rel="stylesheet" href="../../js/lib/layui/css/layui.css">-->
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

            <h1 class="title">租用中的CycTwo</h1>
            <div id="haslended" class="switchInfo">
                <div id="rendInfoBox">
                    <h2 id="bikecode"></h2>
                    <p>开始</p>
                    <span id="rbtime"></span>
                    <p>现在</p>
                    <div id="timeCount">
                        <span id="hour"></span>
                        <span id="sec">:</span>
                        <span id="min"></span>
                    </div>
                    <div id="returnbox">
                        <a class="btn" id="returnBikeBtn">还 车</a>
                    </div>
                </div>
            </div>
            <div id="unlend" class="switchInfo">
                <p>未借车</p>
            </div>
        </div>

    </div>
</div>
</body>


<script src="../../../js/jquery-3.2.1.js"></script>
<script src="../../../js/lib/layui/layui.js"></script>
<script src="../../../js/basicUtil.js"></script>
<script src="../../../js/usingBike.js"></script>
<script>


</script>
</html>
