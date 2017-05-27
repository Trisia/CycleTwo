<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/25
 * Time: 11:58
 */

include(dirname(__FILE__) . "/../service/AdminService.php");
include(dirname(__FILE__) . "/../service/BikeService.php");
include(dirname(__FILE__) . "/../service/UserService.php");
include(dirname(__FILE__) . "/../utils/Util.php");


error_reporting(E_ALL | E_STRICT);

//
//$username = "test1";
//$password = "123asd";


if (!isset($_SESSION)) {
    session_start();
}


//$param = array("username" => $username, "password" => $password);

//foreach ($param as $key => $value) {
//    echo $key . "\t" . $value . "<br>";
//}

$adminService = new AdminService();
$bike = new BikeService();
$user = new UserService();

//echo $adminService->modify(array("password"=>"12456", "id"=>8));

//echo $adminService->add($param);

//$danbu = $adminService->selectByName("danbu");
//$danbu = $adminService->findByID(1);

//$all = $adminService->findAll();

//echo "<table>";
//$flage = true;
//foreach ($all as $item) {
//    if ($flage) {
//        $flage = false;
//        echo "<th><td>记录id</td><td>用户名</td><td>用户登录密码</td><td>加盐</td><td>用户注册时间</td><td>用户状态</td></th>";
//    }
//    echo "<tr>";
//    foreach ($item as $key => $value) {
//        echo "<td value='$key'>" . $value . "</td>";
//    }
//
//    echo "</tr>";
//}
//echo "</table>";

//echo $adminService->delete(8);

//echo $bike->add(array("bikecode"=>"1","lng"=>"N32°11′5.56","lat"=>"E120°01′20.08",));
//echo $bike->delete(6);


//echo Util::movedote("select set ,");

//$params = array();
//
//
//$sql = "select * from bike where  is_land = 0 order by id;";


//// sql 检查 去除末尾',' 和 ';'
//$sql = Util::removeEndSymbol($sql);
//
//
//$page_index = 3;
//$max = 100;
//$start = 0;
//// 参数检查
//if ($page_index && is_numeric($page_index)) {
//
//    $page_index = intval($page_index);
//    // 开始查询记录的条数
//    if ($page_index < 1 || $start > $max) {
//        $start = 0;
//    } else
//        $start = ($page_index - 1) * 10;
//}
//
//
//echo $sql .= " limit ?, " . 10 . ";";


//$param["id"] = 6;
//$param["lastuser"] = 55;
//$param["rbtime"] = Util::getTime();
//$param["lng"] = "N0°";
//$param["lat"] ="E12°";
//$param["bikestate"] = 1;
//$param["is_lend"] = 1;

//echo $bike->modify($param);

//$bikeData = $bike->findByID(6);
//print_r($bikeData);
//echo "<br><br><br>";
//print_r(Util::unsetIndexCol($bikeData));

//
//$params["username"] = "cliven2";
//$params["id"] = "2";
//$params["mphone"] = "1544845";
//$params["password"] = "123456";
//$params["email"] = "danbu@qq.com";
//
//echo $user->add($params);

//echo $user->modify($params);

//$params['bikecode'] = "HZ00001";
//$params['lng'] = "20";
//$params['lat'] = "12";


//$data = $bike->findUnuse(1);

//foreach ($data as $key => $value) {
//    if (is_array($value)) {
//        print_r($value);
//        echo "<br>";
//    } else
//        echo $key . " => " . $value . "<br>";
//}


//echo Util::getCode(4,11);

//$num = 300;
//for($i = 0 ; $i < $num; $i++){
//
//    $params = array();
//    $params['bikecode'] = "ZH".Util::getCode(6, $i);
//    $params['lat'] = rand(-999, 999);
//     $params['lng'] = rand(-999, 999);
//    echo $bike->add($params)."<br>";
//}


//$data = $bike->findUnuse(1);
//
//echo "page: " . $data['total'] . "<br>";


//$username = $_SESSION["username"];
//$userType = $_SESSION["userType"];
//$userid = $_SESSION["userid"];
//
//
//$bikecode = "ZH000003";
//$lng = rand(-999, 999);
//$lat = rand(-999, 999);
//
//echo $bikecode;
//
//
//$thisBike = $bike->findByBikeCode($bikecode);
//
//print_r($thisBike);
//
//
//echo "<br><br><br>";
//
//
//$lended =  $bike->findLendBikeByUserid($userid);
//
//print_r($lended);
//
//
//echo !$lended;
//
//
//echo "<br><br><br>";
//
//$thisUser = $user->findByID($userid);
//
//print_r($thisUser);
//

//$arr = array();
//$arr['id'] = 5;
//$arr['bikecode'] = "464515dsd";
//$arr['lng'] = "1.545";
//$arr['lat'] = -5.5855;
//$arr['orderby'] = array("id"=>true, 'bikecode'=>"false", 'lng'=>0);
//
//echo $bike->safeSqlStr($arr, $tablename);

//$params = array();
//$tablename = "bike";
//$arr['id'] = 5;
//$arr['bikecode'] = "464515dsd";
//$arr['lng'] = "1.545";
//$arr['lat'] = -5.5855;
//$arr['orderby'] = array("id"=>true, 'bikecode'=>"false", 'lng'=>0);
//$data = array("aa", "ggg", "sdfsdfsf", "58454");
//$arr['date'] = $data;
//$arr['like'] = array("bikecode" => "0", "test"=>"danbu");
////
//echo $bike->safeSqlStr($arr, $tablename);
//
//foreach ($data as $key => $value) {
//    if ($value == "ggg")
//        break;
//    else
//        echo $key . "  =>  " . $value . "<br>";
//}
//

//echo strtotime("2017-05-11 19:37:17");

//


//echo ctype_space($test)? "true" : 'false';

//
//$num = 12;
//$d = 5;
//echo ceil($num/$d);
//
//$params = array();
//$params['set'] = array();
//$params['where'] = array();
//
//$params['set']['balance'] = 0;
//$params['where']['is_use'] = 1;
//
//
//$result = $user->modifyByCondition($params);

//echo $result ? $result : "false";



?>