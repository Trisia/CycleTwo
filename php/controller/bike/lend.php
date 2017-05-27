<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/3
 * Time: 11:45
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
    $lng = Util::getParam("lng");
    $lat = Util::getParam("lat");


    if ($bikecode) {
        $bikeService = new BikeService();
        $bike = $bikeService->findByBikeCode($bikecode);

        if ($bike) {

            $recordService = new RecordService();
            if ($userType == 2 && $lng && $lat) {

                $userService = new UserService();

                $thisBike = $bike;
                // 用户 已经借的车辆
                $lendBike = $bikeService->findLendBikeByUserid($userid);

                // 但前用户信息
                $thisUser = $userService->findByID($userid);

                // 余额
                $balance = $thisUser['balance'];


                if ($balance < 199.00) {
                    $message = "账户余额不足不能借车";
                } else if ($lendBike) {
                    $message .= "已经借出车辆";
                    $data = $lendBike;
                } else if (is_array($thisBike) && ($thisBike['is_lend'] == 0)) {

                    $thisBike['lng'] = $lng;
                    $thisBike['lat'] = $lat;
                    $thisBike['is_lend'] = 1;


                    $success = $bikeService->modify($thisBike);
                    $message = $success ? "借车成功" : "借车失败";
                    $recordService->add(array('bikeid' => $thisBike['id'], 'userid' => $userid));
                    $message .= " 记录开始。";
                }
            } else
                $message = "参数错误";
        } else  $message = "自行车车牌不存在";


    } else {
        $message = "参数错误";
    }

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}

?>