<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/25
 * Time: 21:55
 */


if (!class_exists("PwdUtil")) {
    class PwdUtil
    {

        public static function getpwd($password)
        {
            $salt = time();

            $salt = md5($salt);

            $password = md5($password);

            $password = $password . $salt;

            $password = md5($password);

            return array("password" => $password, "salt" => $salt);
        }

        public static function decode($password, $salt)
        {
            if (is_null($password) || is_null($salt)) {
                return "";
            }

            $password = md5($password);
            $password = $password . $salt;
            $password = md5($password);
            return $password;
        }

    }
}


?>