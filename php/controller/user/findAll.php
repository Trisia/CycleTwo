<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 17:44
 */
include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if(!isset($_SESSION)){
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION['userid'];

   $page = Util::getParam('page');


    $success = true;
    $message = "查询成功";

    $userService = new UserService();

    $date = $userService->findAll($page);

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data"=>$date));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}


?>