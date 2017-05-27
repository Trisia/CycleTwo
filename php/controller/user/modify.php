<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/4/27
 * Time: 19:45
 */
include(dirname(__FILE__) . "/../../service/UserService.php");
include(dirname(__FILE__) . "/../../utils/Util.php");
include(dirname(__FILE__) . "/../../utils/PwdUtil.php");

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["username"]) && isset($_SESSION["userType"]) && isset($_SESSION["userid"])) {

    $username = $_SESSION["username"];
    $userType = $_SESSION["userType"];
    $userid = $_SESSION["userid"];

    $success = false;
    $message = "";
    $flag = true;


    $id = Util::getParam("id");

    $email = Util::getParam("email");
    $mphone = Util::getParam("mphone");


    $avatar = Util::getParam("avatar");

    $balance = Util::getParam("balance");

    if ($id) {
        $userService = new UserService();
        $user = $userService->findByID($id);
        if ($user) {


            if ($email) {

                $regex = '/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/';
                if (strlen($email) > 50 || preg_match($regex, $email) <= 0) {
                    $flag = false;
                    $message = " 邮箱不合法";
                } else {
                    if ($userService->findByEmail($email) != null) {
                        $flag = false;
                        $message = " 邮箱已经被注册";
                    } else {
                        $user["email"] = $email;
                    }
                }
            }


            if ($mphone) {
                $regex = '/^\w{6,12}$/';
                if (preg_match($regex, $mphone) <= 0) {
                    $flag = false;
                    $message .= " 手机号不合法";
                } else {
                    if ($userService->findByPhone($mphone) != null) {
                        $flag = false;
                        $message = " 手机已经被注册";
                    } else {
                        $user["mphone"] = $mphone;
                    }
                }

            }

            if ($avatar) $user["avatar"] = $avatar;

            if ($balance) {
                $balance = floatval($balance);
                $user['balance'] = floatval($user['balance']);
                $user['balance'] += $balance;
                $user['balance'] = $user['balance'] < 0 ? 0 : $user['balance'];
            }

            if ($flag) {
                $success = $userService->modify($user);
                $message = $success ? "修改成功" : "修改失败";
            } else {
                $message .= " 修改失败";
            }
        } else {
            $message = "ID 不存在";
        }
    } else {
        $message = "参数错误";
    }


    Util::returnJsonStr(array("success" => $success, "message" => $message));

} else {
    Util::page_redirect("/CycleTwo/index.html");
}

?>