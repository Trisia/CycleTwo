<?php

include(dirname(__FILE__) . "/../utils/Util.php");
Util::routing(null);
$username = $_SESSION["username"];
$userType = $_SESSION["userType"];
$userid = $_SESSION["userid"];

?>


<!DOCTYPE html>

<html lang="en" class="no-js">

<head>

    <meta charset="UTF-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CycleTwo</title>

    <script>
        "use strict";
        const userid = "<?php echo $userid; ?>";
        const userType = "<?php echo $userType; ?>";
    </script>
    <!--<link rel="stylesheet" type="text/css" href="../css/normalize.css"/>-->


    <!--必要样式-->
    <link rel="stylesheet" type="text/css" href="../../css/menu_bubble.css"/>

    <link rel="stylesheet" href="../../css/main_page_css.css">
    <!--    <link rel="stylesheet" href="../../js/lib/layui/css/layui.css">-->


    <script src="../../js/snap.svg-min.js"></script>
    <!--[if IE]>
    <script src="../../js/html5.js"></script><![endif]-->

</head>

<body>

<div class="content">

    <div class="menu-wrap">

        <nav class="menu">

            <div class="icon-list" id="menuList">

            </div>
            <footer class="footer_content">
                <div class="foot-content">
                    <p>copyright©
                        <time>2017</time>
                        <a href="https://www.cliven.me">CycleTwo by Cliven</a>
                    </p>
                </div>
            </footer>
        </nav>

        <!--svg 开始-->
        <div class="morph-shape" id="morph-shape"
             data-morph-open="M-7.312,0H15c0,0,66,113.339,66,399.5C81,664.006,15,800,15,800H-7.312V0z;M-7.312,0H100c0,0,0,113.839,0,400c0,264.506,0,400,0,400H-7.312V0z">

            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 100 800"
                 preserveAspectRatio="none">

                <path d="M-7.312,0H0c0,0,0,113.839,0,400c0,264.506,0,400,0,400h-7.312V0z"/>

            </svg>

        </div>
        <!--svg 结束-->

    </div>


    <div class="nav">

        <!--<button class="menu-button" id="open-button">Open Menu</button>-->
        <div class="" id="open-button">
            <div class="hamburger" id="hamburger-9">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>

    </div>

    <!--wrap 包-->
    <div class="content-wrap">
        <div id="bcg"></div>
        <iframe src="" frameborder="0" id="subpage" class="subpage"></iframe>
    </div>


</div>


</body>
<script src="../../js/jquery-3.2.1.js"></script>
<script src="../../js/lib/layui/layui.js"></script>
<script src="../../js/sidebarControler.js"></script>

</html>