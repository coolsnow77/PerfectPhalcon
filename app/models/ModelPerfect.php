<?php

/**
 * @author shizhice <shizhice@gmial.com>
 */
trait ModelPerfect
{
    /**
     * @var null
     */
    static protected $_instance = null;

    /**
     * @var array
     */
    static protected $_conditions = [];

    static protected $_orConditions = [];

    /**
     * @var array
     */
    static protected $_bindData = [];

    /**
     * @var null
     */
    static protected $_columns = null;

    /**
     * @var null
     */
    static protected $_order = null;

    /**
     * @var null
     */
    static protected $_limit = null;

    /**
     * @var null
     */
    static protected $_offset = null;

    /**
     * @var array
     */
    static public $bindKey = ["key" => "BindKey","num" => 0];

    /**
     * @var array
     */
    static public $lowOperator = ["=","!=",">",">=","<","<=","LIKE"];

    /**
     * @var array
     */
    static public $highOperator = ["BETWEEN","NOT BETWEEN","IN","NOT IN"];

    /**
     * @return string
     * @author shizhice <shizhice@gmail.com>
     */
    static protected function setBindKey()
    {
        static::$bindKey["num"] += 1;
        return static::getBindKey();
    }

    /**
     * @return string
     * @author shizhice <shizhice@gmail.com>
     */
    static protected function getBindKey()
    {
        return static::$bindKey["key"].static::$bindKey["num"];
    }

    /**
     * @param _where
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _where()
    {
        if (!in_array(func_num_args(),[2,3])) {
            throw new \Exception("必须为两个参数或三个参数");
        }
        if (func_num_args() == 2) {
            list($field,$value) = func_get_args();
            $operator = "=";
        }else{
            list($field,$operator,$value) = func_get_args();
        }

        static::getInstance()->makeConditionAndBindData($field,strtoupper($operator),$value);

        return static::getInstance();
    }

    /**
     * @param _orWhere
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _orWhere()
    {
        if (!in_array(func_num_args(),[2,3])) {
            throw new \Exception("必须为两个参数或三个参数");
        }
        if (func_num_args() == 2) {
            list($field,$value) = func_get_args();
            $operator = "=";
        }else{
            list($field,$operator,$value) = func_get_args();
        }

        static::getInstance()->makeConditionAndBindData($field,strtoupper($operator),$value, true);

        return static::getInstance();
    }

    /**
     * @param $field
     * @param $operator
     * @param $value
     * @throws \Exception
     */
    protected function makeConditionAndBindData($field,$operator,$value,$or = false)
    {
        if (in_array($operator,static::$lowOperator)) {
            if(!$or){
                static::$_conditions[] = "($field $operator :".static::setBindKey().":)";
            }else{
                static::$_orConditions[] = "($field $operator :".static::setBindKey().":)";
            }
            static::$_bindData[static::getBindKey()] = $value;
        }elseif(in_array($operator,static::$highOperator)) {
            if (!is_array($value)) {
                throw new \Exception("采用高级运算符(".implode(",",static::$highOperator).")，第三个参数必须为数组");
            }
            $map = [];
            foreach ($value as $row) {
                $map[] = ":".static::setBindKey().":";
                static::$_bindData[static::getBindKey()] = $row;
            }

//            static::$_conditions[] = "($field $operator (".implode(",",$map)."))";

            if(in_array($operator,["BETWEEN","NOT BETWEEN"])) {
                static::$_conditions[] = "($field $operator ".implode(" AND ",$map).")";
            }else {
                static::$_conditions[] = "($field $operator (".implode(",",$map)."))";
            }

        }else {
            throw new \Exception("运算符不存在，请在以下选择".implode(",",array_merge(static::$lowOperator,static::$highOperator)));
        }
    }


    /**
     * @param $order
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _order($order = null)
    {
        !is_null($order) and static::$_order = $order;
        return static::getInstance();
    }

    /**
     * @param $limit
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _limit($limit)
    {
        static::$_limit = $limit;
        return static::getInstance();
    }

    /**
     * @param $offset
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _offset($offset)
    {
        static::$_offset = $offset;
        return static::getInstance();
    }

    /**
     * @param string $columns
     * @author shizhice <shizhice@gmail.com>
     * @return static
     */
    static public function _columns($columns = "*")
    {
        if ($columns != "*") {
            if (is_string($columns)) {
                $columns = explode(",",$columns);
            }
            foreach ($columns as &$field) {
                $field = static::class.".".trim($field);
            }
            static::$_columns = $columns;
        }

        return static::getInstance();
    }

    /**
     * 获取数据集
     * @author shizhice <shizhice@gmail.com>
     * @return mixed
     */
    static public function _get()
    {
        $result = static::find(static::makeCondition());
        self::_unsetAttributes();
        return self::getFullInstance($result);
    }

    static public function _update($data)
    {
        $result = static::getInstance()->update(static::makeCondition(),$data);
        self::_unsetAttributes();
        return $result;
    }

    /**
     * 获取数据集
     * @author shizhice <shizhice@gmail.com>
     * @return mixed
     */
    static public function _find($id = null)
    {
        $result = static::findFirst(!is_null($id) ? $id : static::getInstance()->makeCondition());

        self::_unsetAttributes();
        return self::getFullInstance($result);
    }

    /**
     * 查询构造器
     * @author shizhice <shizhice@gmail.com>
     * @return mixed
     */
    static protected function makeCondition()
    {
        $condition = [];
        $map = '';
        if (!empty(static::$_conditions)) {
            $map = implode(" AND ",static::$_conditions);
        }
        if (!empty(static::$_orConditions)) {
            $orWhere = implode(" OR ",static::$_orConditions);
            $map .= ' OR '. $orWhere;
        }
        if ($map) {
            $condition[] = $map;
        }
        if (!empty(static::$_bindData)) {
            $condition["bind"] = static::$_bindData;
        }

        !is_null(static::$_order) and $condition["order"] = static::$_order;
        !is_null(static::$_limit) and $condition["limit"] = static::$_limit;
        !is_null(static::$_offset) and $condition["offset"] = static::$_offset;
        !is_null(static::$_columns) and $condition["columns"] = static::$_columns;

        return $condition;
    }

    /**
     * 获取当前model实例
     * @author shizhice <shizhice@gmail.com>
     * @return null
     */
    static public function getInstance()
    {
        is_null(static::$_instance) and static::$_instance = new static;
        return static::$_instance;
    }

    /**
     * 获取数据条数
     * @author shizhice <shizhice@gmail.com>
     * @return mixed
     */
    static public function _count()
    {
        $result = static::count(static::makeCondition());
        self::_unsetAttributes();
        return $result;
    }

    /**
     * 自动获取分页数据
     * @author shizhice <shizhice@gmail.com>
     * @return array
     */
    static public function _paginator(int $num,$parameters = [],$page = null)
    {
        is_null($page) and $page = intval($_GET['page'] ?? 1);
        $count = static::count(static::makeCondition());
        $lastPage = intval(ceil($count / $num)) ?: 1;
        $page = $page <= 0 ? 1 : ($page <= $lastPage ? $page : $lastPage);
        static::$_limit = $num;
        static::$_offset = $num * ($page - 1);

        $result = self::getFullInstance(static::find(static::makeCondition()));
        self::_unsetAttributes();
        return [
            'preNum' => $num,
            'page' => $page,
            'count' => $count,
            'lastPage' => $lastPage,
            'data' => $result->toArray(),
        ];
    }

    /**
     * make where with array
     * @param array $where
     */
    static public function _makeWhereWithArray(array $where = [])
    {
        if (!empty($where)) {
            foreach ($where as $map) {
                static::_where(...$map);
            }
        }
        return static::getInstance();
    }

    static protected function _unsetAttributes()
    {
        static::$_conditions = [];
        static::$_bindData = [];
        static::$_columns = null;
        static::$_order = null;
        static::$_limit = null;
        static::$_offset = null;
    }

    static public function _exist(array $where = [])
    {
        static::_makeWhereWithArray($where);
        return !!static::_count();
    }

    static protected function getFullInstance($result)
    {
        if (!$result instanceof static){
            $obj = new static;
            foreach(get_object_vars($result) as $key => $value) {
                $obj->$key = $value;
            }
            $obj->dirtyState = 0;
            return $obj;
        }
        return $result;
    }
}
