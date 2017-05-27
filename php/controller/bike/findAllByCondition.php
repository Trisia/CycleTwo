<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/9
 * Time: 21:35
 */
include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");

if (!isset($_SESSION)) {
    session_start();
}
//print_r($_REQUEST);

if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {


    $page = Util::getParam('page');



    $success = true;
    $message = "";


    $params = array();
    $data = array();

    $bikecode = Util::getParam('bikecode');
    $pctime = Util::getParam('pctime');
    $lng = Util::getParam('lng');
    $lat = Util::getParam('lat');
    $bikestate = Util::getParam('bikestate');
    $is_lend = Util::getParam('is_lend');
    $page = Util::getParam('page');
    $keyword = Util::getParam('keyword');

    $bikeService = new BikeService();



    if (!is_null($page))
        $params['page'] = $page;

    if (!is_null($bikecode))
        $data['bikecode'] = $bikecode;

    if (!is_null($pctime) && is_array($pctime) && count($pctime) == 2)
        $data['pctime'] = $pctime;

    if (!is_null($lng) && is_array($lng) && count($lng) == 2)
        $data['lng'] = $lng;

    if (!is_null($lat) && is_array($lat) && count($lat) == 2)
        $data['lat'] = $lat;

    if (!is_null($bikestate))
        $data['bikestate'] = $bikestate;

    if (!is_null($is_lend))
        $data['is_lend'] = $is_lend;

    if (!is_null($keyword))
        $data['like'] = array('bikecode' => $keyword);

    $params['data'] = $data;

    $returnData = null;

    $returnData = $bikeService->findAllByCondition($params);


    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $returnData));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}
?>
