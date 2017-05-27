<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/8
 * Time: 22:17
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");
include(dirname(__FILE__) . "/../../utils/PwdUtil.php");

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION["userid"];

    $success = false;
    $message = "";
    $flag = true;


    $password = Util::getParam("password");
    $newpwd = Util::getParam("newpwd");
    $renewpwd = Util::getParam("renewpwd");


    if (is_null($password)) {
        $message .= "原密码为空";
        $flag = false;
    } else if (is_null($newpwd)) {
        $message .= "新密码为空";
        $flag = false;
    } else if (is_null($renewpwd)) {
        $message .= "重复新密码为空";
        $flag = false;
    } else {
        $userService = new UserService();
        $user = $userService->findByID($userid);

        $pwd = PwdUtil::decode($password, $user['salt']);

        if ($pwd === $user['password']) {

            $regex = '/^\w{6,12}$/';
            if (preg_match($regex, $newpwd) <= 0) {
                $flag = false;
                $message = "密码不能包含特殊字符，并且要大于长度6";
            } else {
                if ($newpwd === $renewpwd) {

                    $part = PwdUtil::getpwd($newpwd);
                    $user['password'] =$part["password"];
                    $user['salt'] = $part["salt"];

                    $success = $userService->modify($user);
                    $message = $success ? "修改成功" : "修改失败";

                } else {
                    $flag = false;
                    $message = "两次密码不一致";
                }
            }
        } else {
            $flag = false;
            $message = "密码不正确";
        }
    }

    Util::returnJsonStr(array("success" => $success, "message" => $message));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}

?>