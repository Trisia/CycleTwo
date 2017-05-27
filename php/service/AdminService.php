<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/25
 * Time: 11:30
 */


include(dirname(__FILE__) . "/BaseService.php");
include(dirname(__FILE__) . "/../utils/PwdUtil.php");
include(dirname(__FILE__) . "/../utils/Util.php");


if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL | E_STRICT);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!class_exists("AdminService")) {

    class AdminService extends BaseService
    {

        /**
         * 通过 用户名查找
         * @param $username
         * @return array
         */
        function findByUsername($username)
        {
            $conn = $this->init();

            $sql = "select * from admin where username=? and is_use = 1;";

            $stmt = $conn->prepare($sql);


            $stmt->bind_param("s", $username);

            $stmt->execute();

            $result = $stmt->get_result();

            $row = null;
            if($conn->affected_rows > 0){
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }

            return $row;
        }

        /**
         * 查找全部管理员
         * @return array
         */
        function findAll()
        {
            $conn = $this->init();

            $sql = "select * from admin where is_use = 1;";


            $result = $conn->query($sql);
            $arr = array();
            while ($row = $result->fetch_array()) {
                $row = Util::unsetIndexCol($row);
                array_push($arr, $row);
            }

            return $arr;
        }


        /**
         * 通过用户id查找
         * @param $id
         * @return array
         */
        function findByID($id)
        {
            $conn = $this->init();

            $sql = "select * from admin where id=? and is_use = 1;";

            $stmt = $conn->prepare($sql);

            $id = intval($id);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            $row = null;
            if($conn->affected_rows > 0){
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }

            return $row;
        }


        /**
         * 添加用户
         * @param $params
         * @return bool
         */
        function add($params)
        {

            $state = false;
            if (is_array($params)) {

                $username = $params["username"];
                $password = $params["password"];


                $regtime = Util::getTime();

                $pwd = PwdUtil::getpwd($password);

                $password = $pwd["password"];
                $salt = $pwd["salt"];


                $conn = $this->init();

                $sql = "insert into admin (username, password, regtime,salt, is_use) VALUES (?,?,?, ?, 1)";

                $stmt = $conn->prepare($sql);


                $stmt->bind_param("ssss", $username, $password, $regtime, $salt);

                $stmt->execute();
                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }


        /**
         * 修改密码
         * @param $param
         * @return bool
         */
        function modify($param)
        {
            $state = false;

            if (isset($param["password"]) && isset($param["id"])) {


                $conn = $this->init();

                $sql = "update admin set password = ?, salt=? where id=? and is_use=1;";

                $stmt = $conn->prepare($sql);

                $id = intval($param["id"]);

                $pwd = PwdUtil::getpwd($param["password"]);

                $password = $pwd["password"];
                $salt = $pwd["salt"];

                $stmt->bind_param("ssi", $password, $salt, $id);

                $stmt->execute();

                $state = $conn->affected_rows > 0 ? true : false;

            }
            return $state;
        }


        /**
         * 删除用户
         * @param $id
         * @return bool
         */
        function delete($id)
        {
            $state = false;
            if (!is_null($id)) {

                $conn = $this->init();

                $sql = "update admin set is_use = 2 where id=?;";

                $stmt = $conn->prepare($sql);

                $id = intval($id);

                $stmt->bind_param("i", $id);

                $stmt->execute();
                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }

    }

}
?>