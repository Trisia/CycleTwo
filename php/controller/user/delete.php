<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 17:43
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if(!isset($_SESSION)){
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];


    $success = false;
    $message = "";

    $id = Util::getParam('username');
    if ($id) {
        $userService = new UserService();

        if ($userService->findByID($id)) {
            $success = $userService->delete($id);
            $message = $success ? "删除成功" : "删除失败";
        } else {
            $message = "ID 不存在";
        }

    } else {
        $message = "参数错误";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}


?>