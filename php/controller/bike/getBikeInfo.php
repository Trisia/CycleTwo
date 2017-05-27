<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/8
 * Time: 13:02
 */


include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../service/RecordService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");


if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $username = $_SESSION["username"];
    $userid = $_SESSION["userid"];
    $userType = $_SESSION["userType"];

    $success = false;
    $message = "";
    $data = null;

    $bikecode = Util::getParam("bikecode");

    if ($bikecode) {
        $bikeService = new BikeService();
        $bike = $bikeService->findByBikeCode($bikecode);

        if ($bike) {
            $message .= "查询成功";
            $data = $bike;
            $success = true;
        } else  $message = "自行车ID不存在";


    } else {
        $message = "参数错误";
    }

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}

?>