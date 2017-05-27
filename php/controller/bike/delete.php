<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/28
 * Time: 8:36
 */

include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if(!isset($_SESSION)){
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && $_SESSION["userType"] == 1) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];


    $success = false;
    $message = "";

    $bikeCode = Util::getParam('bikecode');

    if (!is_null($bikeCode)) {
        $bikeService = new BikeService();
        $bike = $bikeService->findByBikeCode($bikeCode);
        if (!is_null($bike)) {
            $success = $bikeService->delete($bike['id']);
            $message = $success ? "删除成功" : "删除失败";
        } else {
            $message = "车牌为".$bikeCode."的CycleTwo单车不存在";
        }
    } else {
        $message = "车牌不能为空";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}


?>