<?php

/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/27
 * Time: 13:03
 */

if (!class_exists("Util")) {
    class Util
    {
        /**
         * 判断某个属性是否被设置
         * @param $arr
         * @param $name
         * @return bool
         */
        public static function isSetParam($arr, $name)
        {
            return isset($arr["$name"]);
        }

        /**
         * 移除末尾 符号
         * @param $str
         * @return bool|string
         */
        public static function removeEndSymbol($str)
        {

            $result = "";
            if (!is_string($str) || strlen($str) < 1) {
                $result = "";
            } else {
                $result = $str;
                $last = substr($result, -1);
                while ($last == ',' || $last == ';') {
                    $result = substr($result, 0, strlen($result) - 1);
                    if (strlen($result) > 0)
                        $last = substr($result, -1);
                    else {
                        $result = "";
                        break;
                    }
                }
            }

            return $result;
        }

        /**
         * 获取时间
         * @return string
         */
        public static function getTime()
        {
            date_default_timezone_set('Asia/Shanghai');
            return "" . date("Y-m-d H:i:s");
        }


        /**
         * 过滤字段
         * @param $src
         * @param $params
         * @return array
         */
        public static function filterAttr($src, $params)
        {
            $result = array();
            if (is_array($src)) {

                if (!is_array($params)) {
                    $result = $src;
                } else {
                    foreach ($params as $item) {
                        if (isset($src[$item]))
                            $result[$item] = $src[$item];
                    }
                }
            }
            return $result;
        }

        /**
         * 获取 除去列命index 字段后的数据
         * @param $row
         * @return null
         */
        public static function unsetIndexCol($row)
        {
            $result = null;
            if (!is_null($row)) {
                foreach ($row as $key => $value) {
                    if (is_numeric($key))
                        unset($row[$key]);
                }
                $result = $row;
            }
            return $result;
        }

        public static function compDistance($x1, $y1, $x2, $y2)
        {
            $result = 0.00;

            if ($x1 && $y1 && $x2 && $y2 && is_numeric($x1) && is_numeric($y1) && is_numeric($x2) && is_numeric($y2)) {
                $result = sqrt(($x1 - $x2) * ($x1 - $x2) + ($y1 - $y2) * ($y1 - $y2));
            }
            return $result;
        }


        /**
         * 返还JSON 对象
         * @param $obj
         */
        public static function returnJsonStr($obj)
        {
            header('Content-Type: application/json');
            echo json_encode($obj);
        }


        /**
         * 获取请求参数
         * @param $param
         * @return null
         */
        public static function getParam($param)
        {
            $result = null;
            if (is_string($param)) {
                if (isset($_REQUEST[$param]) && !is_null($_REQUEST[$param]) && $_REQUEST[$param] != '' && !ctype_space($_REQUEST[$param])) {
                    if (is_array($_REQUEST[$param])) {

                        $flag = true;

                        // 判断数组内部元素为空的情况
                        foreach ($_REQUEST[$param] as $key => $value) {
//                            echo $key . " => " . $value . "<br>";
                            if (is_null($value) || ctype_space($value) || $value == '') {
                                $result = null;
                                $flag = false;
                                break;
                            }
                        }
                        if ($flag)
                            $result = $_REQUEST[$param];
                    } else
                        $result = $_REQUEST[$param];

                } else
                    $result = null;
            }
            return $result;
        }


        public static function avatarUrl($name)
        {
            $prefex = "/CycleTwo/upload/avatar/";
            $reuslt = "";
            if (is_string($name))
                $reuslt = $prefex . $name;
            else
                $reuslt = "";
            return $reuslt;
        }

        /**
         * 过滤请求空白参数
         * @return array
         */
        public static function getRequestParam()
        {
            $result = array();
            foreach ($_REQUEST as $key => $value) {
                $value = Util::getParam($_REQUEST[$key]);
                if ($value)
                    $result[$key] = $value;
            }
            return $result;
        }

        /**
         * 页面跳转
         * @param $url
         */
        public static function page_redirect($url)
        {
            echo "<script>";

            if (!is_null($url)) {
                echo "window.location=\"$url\";";
            }
            echo "</script>";
            if (!is_null($url)) die();
        }

        /**
         * 拦截
         */
        public static function routing($userType)
        {
            if (!isset($_SESSION)) {
                session_start();
            }
            if (is_null($userType)) {
                if (!isset($_SESSION["username"]) || !isset($_SESSION["userType"]) || !isset($_SESSION["userid"])) {
                    Util::page_redirect("/CycleTwo/index.html");
                }
            } else {
                if (!isset($_SESSION["username"]) || !isset($_SESSION["userType"]) || !isset($_SESSION["userid"]) || $userType != $_SESSION["userType"]) {
                    Util::page_redirect("/CycleTwo/index.html");
                }
            }

        }

        /**
         *  生成固定位数的数字字符串
         * @param $bit
         * @param $num
         * @return bool|null|string
         */
        public static function getCode($bit, $num)
        {
            $result = null;
            if (is_numeric($bit) && is_numeric($num)) {
                $base = Util::cpow(10, $bit);
                $base += $num;
                $result = strval($base);
                $result = substr($result, 1, strlen($result) - 1);
            }
            return $result;
        }


        /**
         * 快速幂
         * @param $a
         * @param $b
         * @return int
         */
        public static function cpow($a, $b)
        {
            $ans = 1;
            $base = $a; // 基数
            while ($b != 0) {
                if ($b & 1 != 0)
                    $ans = ($base * $ans);
                $base = ($base * $base);
                $b >>= 1;
            }
            return $ans;
        }


    }
}
?>