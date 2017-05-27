<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/3
 * Time: 12:16
 */

include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if(!isset($_SESSION)){
    session_start();
}

if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $DISTANCE = 100;

    $lat = Util::getParam('lat');
    $lng = Util::getParam('lng');


    $page = Util::getParam('page');

    $success = false;
    $message = "";
//
//    if ($lat && $lng) {
//
    $bikeService = new BikeService();
//
//        $allbikes =  $bikeService->findUnuse();
//
//        foreach ($allbikes as $bike) {
//            $distance = Util::compDistance($bike->lat, $bike)
//            if()
//        }
//
//
//    } else {
//        $message = "参数错误";
//    }

    $data = $bikeService->findUnuse($page);
    $success = true;
    $message = "成功";

    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>