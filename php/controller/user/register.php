<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 17:43
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

session_start();

$flag = true;

$success = false;
$message = "";

$userInfo = array();
$userInfo["username"] = Util::getParam("username");
$userInfo["password"] = Util::getParam('password');
$userInfo["repwd"] = Util::getParam('repwd');
$userInfo["mphone"] = Util::getParam('mphone');
$userInfo["email"] = Util::getParam('email');

$userService = new UserService();


$regex = '/^\w{3,12}$/';
if (!$userInfo["username"] || preg_match($regex, $userInfo['username']) <= 0) {

    $flag = false;
    $message = "用户名不能包含特殊字符，并且要大于长度3";
} else {
    if ($userService->findByUsername($userInfo["username"]) != null) {
        $flag = false;
        $message = "用户名已存在";
    }
}

if ($flag) {
    $regex = '/^\w{6,12}$/';
    if (!$userInfo["password"] || preg_match($regex, $userInfo['password']) <= 0) {
        $flag = false;
        $message = "密码不能包含特殊字符，并且要大于长度6";
    }

    if ($flag && (!$userInfo["repwd"] || $userInfo["repwd"] != $userInfo["password"])) {
        $flag = false;
        $message = "两次输入密码不匹配";
    }
}


if ($flag) {
    $regex = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
    if (!$userInfo["email"] || strlen($userInfo["email"]) > 50 || preg_match($regex, $userInfo["email"]) <= 0) {
        $flag = false;
        $message = "邮箱不合法";
    } else {
        if ($userService->findByEmail($userInfo["email"]) != null) {
            $flag = false;
            $message = "邮箱已经被注册";
        }
    }
}

if ($flag) {
    $regex = '/^1\d{9}\d$/';
    if (preg_match($regex, $userInfo["mphone"]) <= 0) {
        $flag = false;
        $message = "手机号不合法";
    } else {
        if ($userService->findByPhone($userInfo["mphone"]) != null) {
            $flag = false;
            $message = "手机号已被注册";
        }
    }
}

if ($flag) {
    $message = "OK";
    $success = $userService->add($userInfo);
}

Util::returnJsonStr(array("success" => $success, "message" => $message));

?>