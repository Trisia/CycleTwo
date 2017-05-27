<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/24
 * Time: 21:34
 */

/**
 * @return mysqli 建立连接
 */

if (!class_exists("Connector")) {
    class Connector
    {
        public static function connectDB()
        {
            $server = "localhost:3306";
            $user = "root";
            $pwd = "123456";
            $db_name = "cycletwo";

            $conn = new mysqli($server, $user, $pwd, $db_name);

            if ($conn->connect_errno) {
                die("数据库连接错误： " . $conn->connect_errno);
            }
            return $conn;

        }

        /**
         * 初始化字符类型
         * @param $conn
         */
        public static function initDB($conn)
        {
            if (!$conn) {
                die("连接 不合法");
            }
            $sql = "set names utf8";

            $conn->query($sql);
        }
    }
}

?>