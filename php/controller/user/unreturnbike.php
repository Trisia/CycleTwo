<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/3
 * Time: 12:04
 */

include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../service/RecordService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION['userid'];


    $success = false;
    $message = "";

    $bikeService = new BikeService();

    $data = $bikeService->findLendBikeByUserid($userid);

    if ($data) {
        $message = "查询成功";
        $recordSerive = new RecordService();
        $record = $recordSerive->findUnfinish($userid);
        $data['rbtime'] = $record['stime'];
        $success = true;
    } else {
        $message = "没有借出的车辆";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}


?>