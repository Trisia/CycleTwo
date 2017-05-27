<?php
/**
 * Created by PhpStorm.
 * user: Cliven
 * Date: 2017/4/25
 * Time: 17:10
 */
include(dirname(__FILE__) . "/../Connector.php");
include(dirname(__FILE__) . "/../utils/Util.php");


error_reporting(E_ALL | E_STRICT);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!class_exists('BaseService')) {
    class BaseService
    {
        protected $conn;
        protected $is_conn = false;

        protected $page_size = 10;

        /**
         * AdminService constructor.
         */
        public function __construct()
        {
            $this->init();
        }

        public function __destruct()
        {
            // TODO: Implement __destruct() method.
            $this->destroy();
        }

        function getState()
        {
            return $this->is_conn;
        }

        /**
         * 统计表中数据量
         * @param $table_name
         * @return int
         */
        function countTable($table_name)
        {

            $sql = "select count(*) as amount from " . $table_name . " where is_use=1;";

            $conn = $this->init();

            $result = $conn->query($sql);

            $row = $result->fetch_array();

            return $row["amount"] ? $row["amount"] : -1;
        }

        /**
         * 分页查询
         * @param $page_index
         * @param $sql
         * @param $max
         * @return bool|mysqli_result|null
         */
        function paging($sql, $page_index, $max)
        {
            $result = null;
            $start = 0;
            $conn = $this->init();

            // sql 检查 去除末尾',' 和 ';'
            $sql = Util::removeEndSymbol($sql);

            // 参数检查
            if ($page_index && is_numeric($page_index)) {

                $page_index = intval($page_index);
                // 开始查询记录的条数
                if ($page_index < 1 || $start > $max) {
                    $start = 0;
                } else
                    $start = ($page_index - 1) * $this->page_size;
            }


            $sql .= " limit ?, " . $this->page_size . ";";

//            echo $sql;

            $stmt = $conn->prepare($sql);

            $stmt->bind_param("i", $start);

            $stmt->execute();
            $result = $stmt->get_result();


            return $result;
        }

        /**
         * 获取安全的动态sql语句
         * @param $params
         * @param $tablename
         * @return string
         */
        function safeSqlStr($params, $tablename)
        {
            $conn = $this->init();

            $sql = "SELECT *  FROM ";
            $where = " WHERE 1=1 ";
            $and = " AND ";

            $sort = "";
            // 表名为空
            if (is_null($tablename) || $tablename == '') {
                return "";
            } else {
                $tablename = $conn->real_escape_string($tablename);
                $sql = $sql . $tablename . $where;
            }

            foreach ($params as $key => $value) {
                if (is_string($key)) {

                    $key = $conn->real_escape_string($key);
                    if ($key == 'orderby' && is_array($value)) {            // 排序规则
                        $sort = $this->getOderParamSql($value);
                    } else if (is_numeric($value) || is_string($value)) {   // 普通条件
                        $value = $conn->real_escape_string($value);
                        $sql .= ($and . $key . "=" . $value);
                    } else if ($key == 'like' && is_array($value)) {       // 模糊查询
                        $sql .= $this->getLikeParamSql($value);
                    } else if (is_array($value) && count($value) == 2) {  // 区间查询
                        $value[0] = $conn->real_escape_string($value[0]);
                        $value[1] = $conn->real_escape_string($value[1]);
                        $sql .= ($and . "(" . $key . " BETWEEN " . $value[0] . $and . $value[1] . ")");
                    }
                }
            }
            $sql .= $sort;
            return $sql;
        }

        /**
         * 获取安全的动态修改sql语句
         * @param $params
         * @param $tablename
         * @return string
         */
        function safeModifySql($params, $tablename)
        {
            $sql = "";
            $updata = "UPDATE ";

            $conn = $this->init();

            if (is_null($tablename) || $tablename == ''
                || !isset($params['set']) || !is_array($params['set'])
                || count($params['set']) == 0
                || !isset($params['where']) || !is_array($params['where'])
                || count($params['where']) == 0
            ) {
                return "";
            } else {
                $tablename = $conn->real_escape_string($tablename);
                // 获取set 语句
                $set = $this->getSetSql($params['set']);
                $where = $this->getWhereSql($params['where']);
                if ($set == '' || $where == '') {
                    $sql = "";
                } else {
                    $sql = $updata . $tablename . $set . $where;
                }
            }

            return $sql;
        }


        /**
         * 获取set 语句
         * @param $param
         * @return null|string
         */
        function getSetSql($param)
        {
            $flag = true;
            $set = " SET ";
            $result = "";
            $conn = $this->init();

            foreach ($param as $key => $value) {
                $key = $conn->real_escape_string($key);
                $value = $conn->real_escape_string($value);
                if (is_null($value)) {
                    $result = "";
                    break;
                }
                if ($flag) {
                    $flag = false;
                    if (is_string($value)) {
                        $value = " '" . $value . "' ";
                    }
                    $result = $set . $key . "=" . $value;


                } else {
                    if (is_string($value)) {
                        $value = " '" . $value . "' ";
                    }
                    $result .= " , " . $key . "=" . $value;
                }
            }
            return $result;
        }


        /**
         * 获取where 语句
         * @param $param
         * @return string
         */
        function getWhereSql($param)
        {
            $flag = true;
            $where = " WHERE ";
            $and = " AND ";
            $result = "";
            $conn = $this->init();

            foreach ($param as $key => $value) {
                $key = $conn->real_escape_string($key);
                $value = $conn->real_escape_string($value);
                if (is_null($value)) {
                    $result = "";
                    break;
                }
                if ($flag) {
                    $flag = false;
                    $result = $where . $key . "=" . $value;
                } else {
                    $result .= $and . $key . "=" . $value;
                }
            }
            return $result;
        }

        /**
         * 获取 模糊查询 字段
         * @param $param
         * @return string
         */
        function getLikeParamSql($param)
        {
            $conn = $this->init();
            $result = "";
            $and = " AND ";
            $like = " LIKE ";

            if (is_null($param) || !is_array($param)) {
                $result = "";
            } else {
                foreach ($param as $key => $value) {
                    $key = $conn->real_escape_string($key);
                    $value = "'%" . $conn->real_escape_string($value) . "%'";

                    $result .= ($and . $key . $like . $value);
                }
            }
            return $result;
        }

        /**
         * 获取排序参数
         * @param $param
         * @return string
         */
        function getOderParamSql($param)
        {
            $conn = $this->init();
            $orderby = " ORDER BY ";
            $desc = " DESC ";
            $dot = " , ";

            $firstOderFlag = true;

            if (is_null($param) || !is_array($param)) {
                $orderby = "";
            } else {

                foreach ($param as $attr => $isDown) {
                    $attr = $conn->real_escape_string($attr);

                    if ($firstOderFlag) {
                        $firstOderFlag = false;
                        $orderby .= $attr;
                    } else {
                        $orderby .= ($dot . $attr);
                    }

                    if ($isDown || $isDown === 'true' || $isDown === 'TRUE') {
                        $orderby .= $desc;
                    }
                }
            }
            return $orderby;
        }


        /**
         * 初始化并且返还连接对象
         * @return mysqli
         */
        function init()
        {
            if (!$this->getState()) {
                $this->conn = Connector::connectDB();
                Connector::initDB($this->conn);
                $this->is_conn = true;
            }
            return $this->conn;
        }


        function destroy()
        {
            if (method_exists($this->conn, 'close'))
                $this->conn->close();
        }
    }
}

?>