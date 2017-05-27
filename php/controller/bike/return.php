<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/3
 * Time: 12:56
 */


include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../service/RecordService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");


// 分钟
$MIN = 60.0;
// 小时
$HOUR = $MIN * 60.0;
// 每小时花费
$PRE_COST = 0.1;

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $username = $_SESSION["username"];
    $userid = $_SESSION["userid"];
    $userType = $_SESSION["userType"];

    $success = false;
    $message = "";


    $lng = Util::getParam('lng');
    $lat = Util::getParam('lat');

    $data = null;


    if (!$lng || !$lat) {
        $message = "参数错误";
    } else if ($userType != 2) {
        $message = "该角色不能进行这个操作";
    } else {

        $bikeService = new BikeService();
        // 用户 已经借的车辆
        $lendBike = $bikeService->findLendBikeByUserid($userid);

        if ($lendBike) {

            $recordService = new RecordService();
            $userService = new UserService();


            // 但前用户信息
            $thisUser = $userService->findByID($userid);

            // 余额
            $balance = $thisUser['balance'];


            $recordid = $recordService->findUnfinish($userid);


            $lendBike['lng'] = $lng;
            $lendBike['lat'] = $lat;
            $lendBike['is_lend'] = 0;

            $cost = 0;
            date_default_timezone_set('Asia/Shanghai');
            $min = ceil((time() - strtotime($recordid['stime'])) / $MIN);

//            echo $min;

            // 小于 10 小时 按照 0.1 元/时
            if ($min < (10 * 60)) {
                $cost = ceil($min / 60.0) * $PRE_COST;
            } else {
                // 大于 10 小时 按照 1元/24小时
                $cost = ceil($min / (24 * 60.0)) * $PRE_COST * 10;
            }


            $success = $bikeService->modify($lendBike);

            $cost = round(abs($cost), 2);

            $data['cost'] = $cost;


            $recordService->modify(array("id" => $recordid['id'], "cost" => $cost));
            $message = $success ? "花费: " . abs($cost) . "元" : "还车失败";
            if ($success) {

                $thisUser['balance'] = $balance - $cost;
                $success = $userService->modify($thisUser);
            } else {
                $message .= " 扣费失败";
            }

        } else
            $message = "没有借用自行车";
    }

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>

