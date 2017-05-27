<?php

/**
 * Created by PhpStorm.
 * User: Cliven
 * Date: 2017/5/2
 * Time: 15:44
 */

include(dirname(__FILE__) . "/BaseService.php");
include(dirname(__FILE__) . "/../utils/Util.php");


error_reporting(E_ALL | E_STRICT);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!class_exists('RecordService')) {
    class RecordService extends BaseService
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

//            $params['data']['is_use'] = 1;

            $sql = $this->safeSqlStr($params['data'], "record");



            if ($result = $conn->query($sql)) {

                // 分页
                $total = $result->num_rows;

                $result = $this->paging($sql, $page_index, $total);


                $arr['data'] = array();
                while ($row = $result->fetch_array()) {
                    $row = Util::unsetIndexCol($row);
                    array_push($arr['data'], $row);
                }

            } else {
                $total = 0;
            }
            $arr['total'] = ceil($total / $this->page_size);
            $arr['current_page'] = $current_page;

            return $arr;
        }

//        /**
//         * 查找所有记录
//         * @param $page_index
//         * @return array
//         */
//        function findAll($page_index)
//        {
//            $conn = $this->init();
//
//            $current_page = !is_null($page_index) && is_numeric($page_index) ? 1 : $page_index;
//
//            $sql = "select * from `record`;";
//
//            $total = $this->countTable("record");
//
//            $result = null;
//
//            if ($page_index) {
//                $result = $this->paging($sql, $page_index, $total);
//            } else {
//                $result = $conn->query($sql);
//            }
//
//            $arr = array();
//            $arr['data'] = array();
//            while ($row = $result->fetch_array()) {
//                $row = Util::unsetIndexCol($row);
//                array_push($arr['data'], $row);
//            }
//
//            return $arr;
//        }


        /**
         * 通过ID 查找记录
         * @param $id
         * @return null
         */
        function findByID($id)
        {
            $conn = $this->init();

            $sql = "select * from `record` where id=?;";

            $stmt = $conn->prepare($sql);

            $id = intval($id);

            $stmt->bind_param("i", $id);

            $stmt->execute();

            $result = $stmt->get_result();

            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }

            return $row;
        }

        /**
         * 通过$userid查找 记录
         * @param $userid
         * @return mixed|null
         */
        function findByUserid($userid)
        {
            $conn = $this->init();

            $sql = "select * from `record` where userid=?  ORDER BY stime DESC;";


            $stmt = $conn->prepare($sql);


            $stmt->bind_param("i", $userid);

            $stmt->execute();

            $result = $stmt->get_result();
            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }

            return $row;
        }

//        /**
//         * 通过自行车id 查找记录
//         * @param $bikeid
//         * @return mixed|null
//         */
//        function findByBikeid($bikeid)
//        {
//
//            $conn = $this->init();
//
//            $sql = "select * from `record` where bikeid=? ORDER BY stime DESC;";
//
//            $stmt = $conn->prepare($sql);
//
//
//            $stmt->bind_param("i", $bikeid);
//
//            $stmt->execute();
//
//            $result = $stmt->get_result();
//            $row = null;
//            if ($conn->affected_rows > 0) {
//                $row = $result->fetch_array();
//                $row = Util::unsetIndexCol($row);
//            }
//            return $row;
//        }


        /**
         * 添加记录
         * @param $params
         * @return bool
         */
        function add($params)
        {

            $state = false;
            if (is_array($params)) {

                $userid = intval($params['userid']);
                $bikeid = intval($params['bikeid']);

                $stime = Util::getTime();


                $conn = $this->init();

                $sql = "insert into `record` (userid,bikeid,stime) VALUES (?,?,?);";

                $stmt = $conn->prepare($sql);


                $stmt->bind_param("iis", $userid, $bikeid, $stime);

                $stmt->execute();
                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }


        /**
         * 修改记录
         * @param $param
         * @return bool
         */
        function modify($param)
        {
            $state = false;

            if (is_array($param)) {

                $id = intval($param['id']);

                $cost = floatval($param['cost']);
                $etime = Util::getTime();

                $conn = $this->init();

                $sql = "update `record` set etime=?, cost=? where id=?;";


                $stmt = $conn->prepare($sql);


                $stmt->bind_param("sdi", $etime, $cost, $id);

                $stmt->execute();

                $state = $conn->affected_rows > 0 ? true : false;
            }
            return $state;
        }

        /**
         * 查询未完成的记录
         * @param $userid
         * @return mixed|null
         */
        function findUnfinish($userid)
        {


            $userid = intval($userid);

            $conn = $this->init();

            $sql = "select * from record where userid=? and etime is null;";


            $stmt = $conn->prepare($sql);


            $stmt->bind_param("i", $userid);

            $stmt->execute();
            $result = $stmt->get_result();
            $row = null;
            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }

            return $row;
        }
    }
}

?>