<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 17:44
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if (!isset($_SESSION)) {
    session_start();
}


//if (isset($_SESSION["username"]) && isset($_SESSION["userType"])) {

//    $username = $_SESSION["username"];
//    $userType = $_SESSION["userType"];

$message = "不存在";
$success = false;
$exist = false;

$username = Util::getParam('username');


if (!is_null($username)) {

    $userService = new UserService();

    $user = $userService->findByUsername($username);

//    print_r($user);

    if ($user) {
        $message = "存在";
        $exist = true;
    }
} else {
    $exist = null;
    $message = "参数错误";
}

Util::returnJsonStr(array("success" => $success, "exist" => $exist, "message" => $message));
//} else {
//    Util::page_redirect("/CycleTwo/index.html");
//}


?>