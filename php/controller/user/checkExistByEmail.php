<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 17:45
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if (!isset($_SESSION)) {
    session_start();
}


//if (isset($_SESSION["username"]) && isset($_SESSION["userType"])) {
//
//    $username = $_SESSION["username"];
//    $userType = $_SESSION["userType"];

$message = "不存在";
$success = false;
$exist = false;

$email = Util::getParam('email');

if (!is_null($email)) {

    $userService = new UserService();

    $user = $userService->findByEmail($email);
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