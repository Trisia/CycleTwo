<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 16:15
 */

if (!isset($_SESSION)) {
    session_start();
}

include(dirname(__FILE__) . "/../utils/Util.php");
include(dirname(__FILE__) . "/../utils/PwdUtil.php");
include(dirname(__FILE__) . "/../service/AdminService.php");
include(dirname(__FILE__) . "/../service/UserService.php");


error_reporting(E_ALL | E_STRICT);


$success = false;
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['userType'])) {

    $username = Util::getParam('username');
    $password = Util::getParam('password');
    $userType = Util::getParam('userType');

    $message = "";

    $data = array();

    if ($username && $password && $userType) {

        if ($userType == 1) {
            $adminService = new AdminService();

            $adminUser = $adminService->findByUsername($username);

            if (!is_null($adminUser)) {
                $pwd = PwdUtil::decode($password, $adminUser['salt']);
                if ($pwd == $adminUser['password']) {
                    $success = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["userid"] = $adminUser['id'];
                    $_SESSION["userType"] = $userType;

                    $message = "OK";

                    $data['userType'] = 1;

                } else
                    $message = "管理员 账号或密码错误！";

            } else
                $message = "管理员 不存在！！";


        } else if ($userType == 2) {
            $userService = new UserService();

            $user = $userService->findByUsername($username);
            if (is_null($user))
                $user = $userService->findByEmail($username);

            if (is_null($user))
                $user = $userService->findByPhone($username);


            if (!is_null($user)) {
                $pwd = PwdUtil::decode($password, $user['salt']);

                if ($pwd === $user['password']) {
                    $success = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["userid"] = $user['id'];
                    $_SESSION["userType"] = $userType;
                    $message = "OK";
                    $data['userType'] = 2;
                } else
                    $message = "用户 账号或密码错误！";

            } else
                $message = "用户 不存在！";

        } else
            $message = "用户类型不存在！";
    } else
        $message = "请求参数不足！";
} else
    $message = "请登录！";

Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));


?>