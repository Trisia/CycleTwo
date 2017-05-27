<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 16:06
 */

include(dirname(__FILE__) . "/../../service/AdminService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");


session_start();

$success = true;
$data = null;

$adminService = new AdminService();


$data = $adminService->findAll();


Util::returnJsonStr(array("success" => $success, "data" => $data));

?>