<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/6
 * Time: 9:26
 */


include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userid"]) && isset($_SESSION["userType"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION["userid"];

    $id = Util::getParam("id");
    $data = array();

    $success = false;
    $message = "";
    if ($id) {
        $userService = new UserService();
        $data = $userService->findByID($id);
        if ($data) {
            $message = "查询成功";
            $success = true;
            $data = Util::filterAttr($data, array("id", "username", "avatar", "email", "mphone", "regtime", "balance"));
            $data['avatar'] = Util::avatarUrl($data['avatar']);
        }
    } else {
        $message = "id 不能为空";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>