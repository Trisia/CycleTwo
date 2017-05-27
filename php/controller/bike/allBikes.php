<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/9
 * Time: 21:02
 */

include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");


if(!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $success = false;
    $message = "";

    $page = Util::getParam('page');

    $bikeService = new BikeService();

    $data = $bikeService->findAll($page);

    $success = true;
    $message = "成功";

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>