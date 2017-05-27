<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/28
 * Time: 8:05
 */

include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");


if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && $_SESSION['userType'] == 1) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION['userid'];

    $newbike = array();

    $newbike['bikecode'] = Util::getParam('bikecode');
    $newbike['lng'] = Util::getParam("lng");
    $newbike['lat'] = Util::getParam("lat");

    $success = false;
    $message = "";

    $flag = true;

    if (!is_null($newbike['bikecode']) && !is_null($newbike['lng']) && !is_null($newbike['lat'])) {
        $bikeService = new BikeService();

        $bike = $bikeService->findByBikeCode($newbike['bikecode']);

        if ($bike) {
            $message = "自行车生产编号重复";
        } else {
            $success = $bikeService->add($newbike);
            $message = $success ? "添加成功" : "添加失败";
        }

    } else {
        $message = "参数错误";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>