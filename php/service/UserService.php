<?php

/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/27
 * Time: 14:48
 */

include(dirname(__FILE__) . "/BaseService.php");
include(dirname(__FILE__) . "/../utils/Util.php");
include(dirname(__FILE__) . "/../utils/PwdUtil.php");


error_reporting(E_ALL | E_STRICT);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!class_exists('UserService')) {
    class UserService extends BaseService
    {


        /**
         * 动态条件查询
         * @return array
         */
        function findAllByCondition($params)
        {
            $conn = $this->init();

            $page_index = isset($params["page"]) ? $params["page"] : 1;

            $current_page = !is_null($page_index) ? 1 : $page_index;

            $result = null;

            $total = 0;

            // 返回结果
            $arr = array();
            $params['data']['is_use'] = 1;
            $sql = $this->safeSqlStr($params['data'], "user");

            if ($result = $conn->query($sql)) {

                // 分页
                $total = $result->num_rows;

                $result = $this->paging($sql, $page_index, $total);

                $arr['data'] = array();
                while ($row = $result->fetch_array()) {
                    $row = Util::unsetIndexCol($row);
//                    $row['avatar'] = Util::avatarUrl($row['avatar']);
                    array_push($arr['data'], $row);
                }

            } else {
                $total = 0;
            }
            $arr['total'] = ceil($total / $this->page_size);
            $arr['current_page'] = $current_page;

            return $arr;
        }


        /**
         * 查找所有用户
         * @param [$page_index]
         * @return array
         */
        function findAll($page_index)
        {

            $conn = $this->init();

            $current_page = 1;

            $sql = "select * from `user` where is_use = 1;";

            $total = $this->countTable("user");

            $result = null;

            if ($page_index) {
                $result = $this->paging($sql, $page_index, $total);
            } else {
                $result = $conn->query($sql);
            }


            $arr = array();

            $arr['data'] = array();

            while ($row = $result->fetch_array()) {
                $row = Util::unsetIndexCol($row);
//                $row['avatar'] = Util::avatarUrl($row['avatar']);
                array_push($arr['data'], $row);
            }

            $arr['total'] = ceil($total / $this->page_size);
            $arr['current_page'] = $current_page;

            return $arr;
        }


        /**
         * 通过用户ID 查找用户
         * @param $id
         * @return null
         */
        function findByID($id)
        {
            $conn = $this->init();

            $sql = "select * from `user` where id=? and is_use = 1;";

            $stmt = $conn->prepare($sql);

            $id = intval($id);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
//                $row['avatar'] = Util::avatarUrl($row['avatar']);
            }

            return $row;
        }

        /**
         * 通过username查找 用户
         * @param $username
         * @return mixed|null
         */
        function findByUsername($username)
        {
            $conn = $this->init();

            $sql = "select * from `user` where username=? and is_use = 1;";

            $stmt = $conn->prepare($sql);


            $stmt->bind_param("s", $username);

            $stmt->execute();

            $result = $stmt->get_result();
            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
//                $row['avatar'] = Util::avatarUrl($row['avatar']);
            }

//            print_r($conn->affected_rows);

            return $row;
        }

        /**
         * 通过邮箱查找 用户
         * @param $email
         * @return mixed|null
         */
        function findByEmail($email)
        {


            $conn = $this->init();

            $sql = "select * from `user` where email=? and is_use = 1;";

            $stmt = $conn->prepare($sql);


            $stmt->bind_param("s", $email);

            $stmt->execute();

            $result = $stmt->get_result();
            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
//                $row['avatar'] = Util::avatarUrl($row['avatar']);
            }

            return $row;
        }

        /**
         * 通过手机号查找 用户
         * @param $mphone
         * @return mixed|null
         */
        function findByPhone($mphone)
        {

            $conn = $this->init();

            $sql = "select * from `user` where mphone=? and is_use = 1;";

            $stmt = $conn->prepare($sql);


            $stmt->bind_param("s", $mphone);

            $stmt->execute();

            $result = $stmt->get_result();
            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
//                $row['avatar'] = Util::avatarUrl($row['avatar']);
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
                $mphone = $params["mphone"];
                $password = $params["password"];
                $email = $params["email"];

                $regtime = Util::getTime();

                $pwd = PwdUtil::getpwd($password);

                $password = $pwd["password"];
                $salt = $pwd["salt"];
                $avatar = "default_avatar.jpg";

                $conn = $this->init();

                $sql = "insert into `user` (username,mphone,regtime,password,salt,avatar, email,is_use) VALUES (?,?,?,?,?,?,?, 1)";

                $stmt = $conn->prepare($sql);


                $stmt->bind_param("sssssss", $username, $mphone, $regtime, $password, $salt, $avatar, $email);

                $stmt->execute();
                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }

        /**
         * 修改用户
         * @param $param
         * @return bool
         */
        function modify($param)
        {
            $state = false;

            if (is_array($param)) {

                $id = intval($param["id"]);
                $mphone = $param["mphone"];
                $password = $param["password"];
                $salt = $param['salt'];
                $email = $param["email"];
                $balance = $param['balance'];
                $avatar = $param['avatar'];


                $conn = $this->init();

                $sql = "update `user` set mphone=?,  password=?, salt=?, avatar=?,email=? ,balance =? where id=? and is_use = 1;";


                $stmt = $conn->prepare($sql);


                $stmt->bind_param("sssssdi", $mphone, $password, $salt, $avatar, $email, $balance, $id);

                $stmt->execute();

                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }

        /**
         * 动态参数修改
         * @param $params
         * @return bool
         */
        function modifyByCondition($params)
        {
            $state = false;

            if (is_array($params)) {

                $conn = $this->init();

                $sql = $this->safeModifySql($params, "user");
                $result = $conn->query($sql);

                if ($conn->affected_rows > 0) {
                    $state = true;
                }
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

                $sql = "update `user` set is_use = 2 where id=?;";

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