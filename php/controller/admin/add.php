<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 15:38
 */

include(dirname(__FILE__) . "/../../service/AdminService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

session_start();
$flag = true;

$success = false;


$userInfo = array();
$userInfo["username"] = $_POST["username"];
$userInfo["password"] = $_POST["password"];
$userInfo["repwd"] = $_POST["repwd"];

if (!$userInfo["username"] || $userInfo["username"] == "" || strlen($userInfo["username"]) < 3) {
//    page_redirect("用户名不能为空", '../index.html', 1);
    $flag = false;
    echo "username error <br>";
}

if (!$userInfo["password"] || $userInfo["password"] == "" || strlen($userInfo["password"]) < 6) {
//    page_redirect("密码不能为空", '../index.html', 1);
    $flag = false;
    echo "password error <br>";
}

if ($userInfo["repwd"] != $userInfo["password"]) {
    $flag = false;
    echo "password repeat error <br>";
}


$adminService = new AdminService();


if ($flag)
    $success = $adminService->add($userInfo);

Util::returnJsonStr(array("success" => $success));

?>