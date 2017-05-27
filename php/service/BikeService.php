<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/25
 * Time: 22:13
 */
//include (dirname(__FILE__)."/PwdUtil.php");
include(dirname(__FILE__) . "/BaseService.php");
include(dirname(__FILE__) . "/RecordService.php");
include(dirname(__FILE__) . "/../utils/Util.php");


error_reporting(E_ALL | E_STRICT);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


class BikeService extends BaseService
{

    /**
     * 动态条件查询
     * @return array
     */
    function findAllByCondition($params)
    {
        $conn = $this->init();

        $page_index = isset($params["page"]) ? intval($params["page"]) : 1;

        $current_page = !is_null($page_index) ? 1 : $page_index;

        $result = null;

        $total = 0;

        // 返回结果
        $arr = array();

        $params['data']['is_use'] = 1;

        $sql = $this->safeSqlStr($params['data'], "bike");

//        echo $sql;

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


    /**
     * 查找没有使用的车
     * @return array
     */
    function findUnuse($page_index)
    {
        $conn = $this->init();

        $current_page = !is_null($page_index) ? 1 : $page_index;

        $sql = "select count(*) as amount from bike where is_lend = 0 and is_use=1 and bikestate=1;";

        $result = $conn->query($sql);

        $row = $result->fetch_array();

        $total = $row["amount"] ? $row["amount"] : 0;

        $result = null;

        $sql = "select * from bike where is_lend = 0 and is_use=1 and bikestate=1;";

        if ($page_index) {
            $result = $this->paging($sql, $page_index, $total);
        } else {
            $result = $conn->query($sql);
        }


        $arr = array();

        $arr['data'] = array();

        if (!is_null($result)) {
            while ($row = $result->fetch_array()) {
                $row = Util::unsetIndexCol($row);
                array_push($arr['data'], $row);
            }
        }

        $arr['total'] = ceil($total / $this->page_size);
        $arr["current_page"] = $current_page;

        return $arr;
    }


    /**
     * 查找自行车
     * @param [$page_index]
     * @return array
     */
    function findAll($page_index)
    {
        $conn = $this->init();

        $current_page = 1;
        $total = $this->countTable("bike");


        $result = null;
        $sql = "select * from bike where is_use = 1;";
        if ($page_index) {
            $result = $this->paging($sql, $page_index, $total);
        } else {
            $result = $conn->query($sql);
        }


        $arr = array();
        $arr['data'] = array();
        while ($row = $result->fetch_array()) {
            $row = Util::unsetIndexCol($row);
            array_push($arr['data'], $row);
        }

        $arr['total'] = ceil($total / $this->page_size);
        $arr['current_page'] = $current_page;

        return $arr;
    }


    /**
     * 查找不同状态自行车
     * @param $bikestate
     * @param $page_index
     * @return array
     */
    function findByBikeState($bikestate, $page_index)
    {
        $conn = $this->init();

        $current_page = 1;

        $sql = "select count(*) as amount from bike where bikestate = ? and is_use=1;";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $bikestate);

        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_array();

        $total = $row["amount"] ? $row["amount"] : 0;


        $sql = "select * from bike where bikestate = ? and is_use=1;";


        //*************************** start paging ****************************************
        $result = null;
        $start = 0;
        // sql 检查 去除末尾',' 和 ';'
        $sql = Util::removeEndSymbol($sql);

        // 参数检查
        if ($page_index && is_numeric($page_index)) {

            $page_index = intval($page_index);
            // 开始查询记录的条数
            if ($page_index < 1 || $start > $total) {
                $start = 0;
            } else
                $start = ($page_index - 1) * $this->page_size;
        }

        $sql .= " limit ?, " . $this->page_size . ";";
        $stmt = $conn->prepare($sql);
        //*************************** end paging ****************************************

        $stmt->bind_param("ii", $bikestate, $start);

        $stmt->execute();
        $result = $stmt->get_result();


        $arr = array();
        $arr['data'] = array();
        while ($row = $result->fetch_array()) {
            $row = Util::unsetIndexCol($row);
            array_push($arr['data'], $row);
        }

        $arr['total'] = ceil($total / $this->page_size);
        $arr['current_page'] = $current_page;

        return $arr;
    }


    /**
     * 查找不同状态自行车
     * @param $keyword
     * @param $page_index
     * @return array
     */
    function findByMoBikeCode($keyword, $page_index)
    {
        $conn = $this->init();

        $current_page = 1;

        $sql = "select count(*) as amount from bike where bikecode like concat('%', ?,'%') and is_use=1;";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $keyword);

        $stmt->execute();

        $result = $stmt->get_result();

        $row = $result->fetch_array();

        $total = $row["amount"] ? $row["amount"] : 0;


        $sql = "select * from bike where bikecode like concat('%', ?,'%') and is_use=1;";

        //*************************** start paging ****************************************
        $result = null;
        $start = 0;
        // sql 检查 去除末尾',' 和 ';'
        $sql = Util::removeEndSymbol($sql);

        // 参数检查
        if ($page_index && is_numeric($page_index)) {

            $page_index = intval($page_index);
            // 开始查询记录的条数
            if ($page_index < 1 || $start > $total) {
                $start = 0;
            } else
                $start = ($page_index - 1) * $this->page_size;
        }

        $sql .= " limit ?, " . $this->page_size . ";";
        $stmt = $conn->prepare($sql);
        //*************************** end paging ****************************************


        $stmt->bind_param("si", $keyword, $start);

        $stmt->execute();
        $result = $stmt->get_result();


        $arr = array();
        $arr['data'] = array();
        while ($row = $result->fetch_array()) {
            $row = Util::unsetIndexCol($row);
            array_push($arr['data'], $row);
        }

        $arr['total'] = ceil($total / $this->page_size);
        $arr['current_page'] = $current_page;

        return $arr;
    }


    /**
     * 通过bikeCode 找车
     * @param $bikecode
     * @return mixed|null
     */
    function findByBikeCode($bikecode)
    {

        $row = null;

        if ($bikecode) {
            $conn = $this->init();
            $sql = "select * from bike where bikecode=? and is_use = 1;";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("s", $bikecode);

            $stmt->execute();

            $result = $stmt->get_result();

            if ($conn->affected_rows > 0) {
                $row = $result->fetch_array();
                $row = Util::unsetIndexCol($row);
            }
        }
        return $row;
    }

    /**
     * 查找用户已经借用车辆
     * @param $id
     * @return mixed|null
     */
    function findLendBikeByUserid($id)
    {
        $row = null;

        if ($id) {

            $recordService = new RecordService();

            $record = $recordService->findUnfinish($id);

            if (!is_null($record)) {
                $row = $this->findByID($record['bikeid']);
            }

        }

        return $row;
    }

    /**
     * 通过ID找车
     * @param $id
     * @return mixed|null
     */
    function findByID($id)
    {
        $conn = $this->init();

        $sql = "select * from bike where id=? and is_use = 1;";

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
     * 添加自行车
     * @param $params
     * @return bool
     */
    function add($params)
    {

        $state = false;
        if (is_array($params)) {

            $bikecode = $params["bikecode"];
            $lng = floatval($params["lng"]);
            $lat = floatval($params["lat"]);


            $pctime = Util::getTime();


            $conn = $this->init();

            $sql = "insert into bike (bikecode,pctime,lng,lat, bikestate, is_lend,is_use) VALUES (?,?,?, ?, 1,0, 1);";

            $stmt = $conn->prepare($sql);


            $stmt->bind_param("ssdd", $bikecode, $pctime, $lng, $lat);

            $stmt->execute();
            $state = $conn->affected_rows > 0 ? true : false;
        }
        return $state;
    }


    /**
     * 修改自行车
     * @param $param
     * @return bool
     */
    function modify($param)
    {
        $state = false;

        if (is_array($param)) {


            $id = intval($param["id"]);
            $lng = floatval($param["lng"]);
            $lat = floatval($param["lat"]);
            $bikestate = intval($param["bikestate"]);
            $is_lend = intval($param["is_lend"]);


            $conn = $this->init();

            $sql = "update bike set lng=?, lat=?, bikestate=?, is_lend=? where id=? and is_use = 1;";


            $stmt = $conn->prepare($sql);


            $stmt->bind_param("ddiii", $lng, $lat, $bikestate, $is_lend, $id);

            $stmt->execute();

            $state = $conn->affected_rows > 0 ? true : false;

        }
        return $state;
    }


    /**
     * 删除自行车
     * @param $id
     * @return bool
     */
    function delete($id)
    {
        $state = false;
        if (!is_null($id)) {

            $conn = $this->init();

            $sql = "update bike set is_use = 2 where id=?;";

            $stmt = $conn->prepare($sql);

            $id = intval($id);

            $stmt->bind_param("i", $id);

            $stmt->execute();
            $state = $conn->affected_rows > 0 ? true : false;
        }
        return $state;
    }


}

?>