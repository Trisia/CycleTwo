<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/6
 * Time: 9:45
 */


if(!isset($_SESSION)){
    session_start();
}


error_reporting(E_ALL | E_STRICT);

include(dirname(__FILE__) . "/../utils/Util.php");


if (isset($_SESSION['username']) || isset($_SESSION["userid"])) {
    $username = $_SESSION['username'];
    session_destroy();
}
Util::page_redirect("/CycleTwo/index.html");
?>