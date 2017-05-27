<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/13
 * Time: 14:25
 */
include(dirname(__FILE__) . "/../../service/BikeService.php");
include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../service/RecordService.php");
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

    $id = Util::getParam('id');
    $stime = Util::getParam('stime');
    $etime = Util::getParam('etime');
    $bikecode = Util::getParam('bikecode');
    $username = Util::getParam('$username');
    $cost = Util::getParam('cost');
    $orderby = Util::getParam('orderby');

    $userid = Util::getParam('userid');


//    $keyword = Util::getParam('keyword');

    $recordService = new RecordService();
    $bikeService = new BikeService();
    $userService = new UserService();

    if (!is_null($page))
        $params['page'] = $page;


    if (!is_null($id)) {
        $data['id'] = $id;
    }


    if (!is_null($userid)) {
        $data['userid'] = $userid;
    }


    if (!is_null($bikecode)) {
        $bike = $bikeService->findByBikeCode($bikecode);
        if (!is_null($bike)) {
            $data['bikeid'] = $bike['id'];
        }
    }


    if (!is_null($username)) {
        $user = $userService->findByUsername($username);
        if (!is_null($user)) {
            $data['userid'] = $user['id'];
        }
    }

    if (!is_null($stime) && is_array($stime) && count($stime) == 2)
        $data['stime'] = $stime;

    if (!is_null($etime) && is_array($etime) && count($etime) == 2)
        $data['etime'] = $etime;

    if (!is_null($cost) && is_array($cost) && count($cost) == 2)
        $data['cost'] = $cost;

    if (!is_null($orderby))
        $data['orderby'] = $orderby;


    $params['data'] = $data;

    $returnData = null;

    $resultData = $recordService->findAllByCondition($params);


    $len = count($resultData['data']);


    /**
     * 数据重新查询显示
     */
    for ($i = 0; $i < $len; $i++) {

        foreach ($resultData['data'][$i] as $key => $value) {
            if ($key == 'bikeid') {
                $bikecode = $bikeService->findByID($value)['bikecode'];
                $resultData['data'][$i]['bikecode'] = $bikecode;
            } else if ($key == 'userid') {
                $username = $userService->findByID($value)['username'];
                $resultData['data'][$i]['username'] = $username;
            }

        }
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $resultData));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}

?>
