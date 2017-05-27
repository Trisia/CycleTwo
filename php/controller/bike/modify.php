<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/28
 * Time: 8:40
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

    $bikecode = Util::getParam('bikecode');
    $lng = Util::getParam("lng");
    $lat = Util::getParam("lat");
    $bikestate = Util::getParam("bikestate");

//    echo $bikecode . "<br>" . $lat . "<br>" . $lng . "<br>" . $bikestate . "<br>";

    if (!is_null($bikecode) && !is_null($lng) && !is_null($lat) && !is_null($bikestate)) {
        $bikeService = new BikeService();
        $bike = $bikeService->findByBikeCode($bikecode);

        if ($bike) {
            // 管理员标记车状态
            if ($userType == 1) {
                if ($bikestate > 0 && $bikestate <= 3) {
                    $bike['bikestate'] = $bikestate;
                    $bike["lat"] = $lat;
                    $bike["lng"] = $lng;

                    $success = $bikeService->modify($bike);
                    $message = $success ? "修改成功" : "修改失败";
                } else {
                    $message = "参数错误";
                }

            } else
                $message = "权限不够";
        } else  $message = "自行车ID不存在";
    } else
        $message = "请求参数错误";

    Util::returnJsonStr(array("success" => $success, "message" => $message));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>