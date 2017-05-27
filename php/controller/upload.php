<?php
/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/5
 * Time: 8:32
 */

if (!isset($_SESSION)) {
    session_start();
}


error_reporting(E_ALL | E_STRICT);

include(dirname(__FILE__) . "/../utils/Util.php");
include(dirname(__FILE__) . "/../service/UserService.php");

//print_r($_SESSION);

if (isset($_SESSION['username']) && isset($_SESSION['userid']) && isset($_SESSION['userType'])) {

// 上传文件路径
    $upload_path = dirname(__FILE__) . "/../../upload/avatar/";

    $MAX_SIZE = 1024 * 1024 * 2;

    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $userType = $_SESSION['userType'];

    // 文件名
    $name = 'avatar';

    $message = "";

    $success = false;

    $data = array();
//    print_r($_FILES);
    if ((($_FILES[$name]["type"] == "image/gif")
            || ($_FILES[$name]["type"] == "image/jpeg")
            || ($_FILES[$name]["type"] == "image/png"))
        && ($_FILES[$name]["size"] < $MAX_SIZE)
    ) {

        if ($_FILES[$name]["error"] > 0) {
            $message .= "上传文件错误";
            $data = array("error_code" => $_FILES[$name]["error"]);
        } else if (file_exists($upload_path . $_FILES[$name]["name"])) {
            $message .= $_FILES[$name]["name"] . " 已经存在";
        } else {
            $data['type'] = $_FILES[$name]["type"];
            $data['size'] = ($_FILES[$name]["size"] / 1024) . " Kb";

            $suffix = explode(".", $_FILES[$name]["name"])[1];

            $file_name = time() . $username . "." . $suffix;

            $params = array();
            $params['set'] = array();
            $params['set']['avatar'] = $file_name;
            $params['where'] = array();
            $params['where']['id'] = $userid;


            $target_file_path = $upload_path . $file_name;

            move_uploaded_file($_FILES[$name]["tmp_name"], $target_file_path);

            $success = true;
            $message .= "文件上传成功";

            $data["path"] = Util::avatarUrl($file_name);

            $userService = new UserService();

            $success = $userService->modifyByCondition($params);
            $message .= $success ? " 修改成功" : " 修改失败";
        }

    } else {
        $message .= "图片格式只能为gif、jpeg、pjpeg 并且不能超过2M";
    }
    Util::returnJsonStr(array("success" => $success, "message" => $message, "data" => $data));
} else {
    Util::page_redirect("/CycleTwo/index.html");
}


?>