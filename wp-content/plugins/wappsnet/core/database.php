<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 11.02.2018
 * Time: 1:00
 */

namespace Wappsnet\Core;

class Database
{
// ============================================================================ //
    public $join = '';
    public $joinColumns = '';
    public $select = '';
    public $where = '';
    public $groupBy = '';
    public $orderBy = '';
    public $limit = '1000';
    public $page = 1;
    public $perPage = 10;

// ============================================================================ //
    public $db_link;

// ============================================================================ //
    public $db_host;
    public $db_name;
    public $db_user;
    public $db_pass;
// ============================================================================ //
    protected static $instance;
// ============================================================================ //
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
// ============================================================================ //
    protected function __construct()
    {
        //set db configs from app
        $this->db_host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASSWORD;

        //create db link for connection
        $this->db_link = $this->initConnection();
    }
// ============================================================================ //
    protected function initConnection()
    {
        $db_link = mysqli_connect(
            $this->db_host,
            $this->db_user,
            $this->db_pass,
            $this->db_name
        );

        if (mysqli_connect_errno()) {
            die('Cannot connect to MySQL server: ' . mysqli_connect_error());
        }

        mysqli_set_charset($db_link, 'utf8');
        return $db_link;
    }
// ============================================================================ //
    public static function reinitializedConnection()
    {
        $db = self::getInstance();
        if (!mysqli_ping($db->db_link)) {
            if (!empty($db->db_link)) {
                mysqli_close($db->db_link);
            }
            $db->db_link = self::initConnection();
        }
        return true;
    }
// ============================================================================ //
    public function optimizeTables($tablesList = '')
    {
        $inDB = self::getInstance();

        if (is_array($tablesList)) {

            foreach ($tablesList as $tableName) {
                $inDB->query("OPTIMIZE TABLE $tableName");
                $inDB->query("ANALYZE TABLE $tableName");
            }
        } else if ($inDB->isTableExists('information_schema.tables')) {

            $tablesList = $inDB->get_table('information_schema.tables',"table_schema = '".$this->db_name,'table_name');

            if (!is_array($tablesList)) {
                return false;
            }

            foreach ($tablesList as $tableName) {
                $inDB->query("OPTIMIZE TABLE {$tableName['table_name']}");
                $inDB->query("ANALYZE TABLE {$tableName['table_name']}");
            }
        }

        if ($inDB->errno()) {
            return false;
        }
        return true;
    }
// ============================================================================ //
    public function isTableExists($table)
    {

        $this->query("SELECT*FROM ".$table." LIMIT 1");
        if ($this->errno()) {
            return false;
        }
        return true;
    }
// ============================================================================ //
    public function get_table($table, $where = '', $fields = '*')
    {
        $list = Array();
        $sql = 'SELECT '.$fields.' FROM '.$table;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }

        $sql .= $this->orderBy;
        $sql .= ' LIMIT '.$this->limit;
        $result = $this->query($sql);
        if ($result && $this->num_rows($result) > 0) {
            while ($data = $this->fetch_assoc($result)) {
                $list[] = $data;
            }
            return $list;
        } else {
            return false;
        }
    }
// ============================================================================ //
    public function __destruct()
    {
        mysqli_close($this->db_link);
    }
// ============================================================================ //
    public function resetConditions()
    {

        $this->where = '';
        $this->select = '';
        $this->join = '';
        $this->joinColumns = '';
        $this->groupBy = '';
        $this->orderBy = '';
        $this->limit = '1000';
        return $this;
    }
// ============================================================================ //
    public function addJoin($joinTable, $joinParams, $joinType = 'LEFT JOIN')
    {
        $join = "".$joinType." ".$joinTable." ON ".$joinParams."";
        $this->join .= $join . "\n";
        return $this;
    }
// ============================================================================ //
    public function join_query($table, $where = ''){
        $list = Array();
        $sql  = 'SELECT '.$this->joinColumns.' FROM '.$table.' ';
        $sql .= $this->join;
        if ($where) {
            $sql .= ' WHERE ' . $where;
        }
        $sql .= $this->orderBy;
        $result = $this->query($sql);
        if ($this->num_rows($result) > 0) {
            while($data = $this->fetch_assoc($result)) {
                $list[] = $data;
            }
            return $list;
        } else {
            return false;
        }
    }
// ============================================================================ //
    public function joinColumns($joinColumns)
    {
        $this->joinColumns .= $joinColumns . "\n";
        return $this;
    }
// ============================================================================ //
    public function addSelect($condition)
    {
        $this->select .= ', ' . $condition;
        return $this;
    }
// ============================================================================ //
    public function where($condition)
    {
        $this->where .= ' AND (' . $condition . ')' . "\n";
        return $this;
    }
// ============================================================================ //
    public function groupBy($field)
    {
        $this->groupBy = 'GROUP BY ' . $field;
        return $this;
    }
// ============================================================================ //
    public function orderBy($field, $direction = 'ASC')
    {
        $this->orderBy = 'ORDER BY ' . $field . ' ' . $direction;
        return $this;
    }
// ============================================================================ //
    public function limit($howMany)
    {
        return $this->limitIs(0, $howMany);
    }
// ============================================================================ //
    public function limitIs($from, $howMany = '')
    {
        $this->limit = (int)$from;
        if ($howMany) {
            $this->limit .= ', ' . $howMany;
        }
        return $this;
    }
// ============================================================================ //
    public function limitPage($page, $perPage)
    {
        $this->page = $page;
        $this->perPage = $perPage;
        return $this->limitIs(($page - 1) * $perPage, $perPage);
    }
// ============================================================================ //
    public function queryCache($sql, $clear = FALSE)
    {
        $filename = 'cache/' . $this->formatStr($sql) . '.sqcache';

        if (!file_exists($filename)) {
            $result = mysqli_query($this->db_link, $sql);
            $arr = $this->fetch_all($result);
            $text = json_encode($arr, TRUE);
            $text = HasPi::compresspi($text);
            $fp = fopen($filename, "w");
            fwrite($fp, $text);
            fclose($fp);
            $result = $arr;
        } else {
            $time = time() - filectime($filename);
            $text = file_get_contents($filename);
            $text = HasPi::uncompresspi($text);
            $result = json_decode($text, TRUE);
            if ($time > 3600 || $clear) {
                unlink($filename);
            }
        }
        return $result;
    }
// ============================================================================ //
    public function formatStr($str)
    {
        $str = trim($str);
        $str = stripslashes($str);
        $str = htmlspecialchars($str);
        $str = str_replace(" ", "", $str);
        $str = $this->toHex($str);
        return $str;
    }
// ============================================================================ //
    public function toHex($string)
    {
        $hex = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $hex .= dechex(ord($string[$i]));
        }
        return $hex;
    }
// ============================================================================ //
    public function fetch_all($result)
    {
        $array = array();
        if ($this->num_rows($result)) {
            while ($object = mysqli_fetch_assoc($result)) {
                $array[] = $object;
            }
        }
        return $array;
    }
// ============================================================================ //
    public function num_rows($result)
    {
        return mysqli_num_rows($result);
    }
// ============================================================================ //
    public function fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }
// ============================================================================ //
    public function free_result($result)
    {
        return mysqli_free_result($result);
    }
// ============================================================================ //
    public function affected_rows()
    {
        return mysqli_affected_rows($this->db_link);
    }
// ============================================================================ //
    public function rows_count($table, $where = false, $limit = 0)
    {

        $sql = "SELECT*FROM ".$table;

        if($where) {
            $sql .= " WHERE ".$where;
        }

        if ($limit) {
            $sql .= " LIMIT " . (int)$limit;
        }
        $result = $this->query($sql);
        return $this->num_rows($result);
    }
// ============================================================================ //
    public function query($sql)
    {
        if (empty($sql)) {
            return false;
        }

        try {
            $result = mysqli_query($this->db_link, $sql);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
// ============================================================================ //
    public function get_field($table, $where='', $field='id')
    {
        $sql = "SELECT ".$field." as get_field FROM ".$table."";
        $sql .= ' WHERE '.$where;
        $sql .= $this->orderBy;
        $sql .= ' LIMIT 1';

        $result = $this->query($sql);

        if ($this->num_rows($result) > 0) {
            $data = $this->fetch_assoc($result);
            return $data['get_field'];
        } else {
            return false;
        }
    }
// ============================================================================ //
    public function fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }
// ============================================================================ //
    public function get_fields($table, $where, $fields = '*')
    {

        $sql  = 'SELECT '.$fields.' FROM '.$table;
        $sql .= ' WHERE '.$where;
        $sql .= $this->orderBy;
        $sql .= ' LIMIT 1';
        $result = $this->query($sql);
        if ($this->num_rows($result) > 0) {
            $data = $this->fetch_assoc($result);
            return $data;
        } else {
            return false;
        }
    }
// ============================================================================ //
    public function get_cells($table, $where, $cells)
    {
        $sql = 'SELECT '.$cells.' FROM '.$table;
        $sql .= 'WHERE '.$where;
        $sql .= $this->orderBy;
        $sql .= 'LIMIT '.$this->limit;

        $result = $this->query($sql);

        if ($this->num_rows($result) > 0) {
            $data = $this->fetch_assoc($result);
            return $data;
        } else {
            return false;
        }
    }
// ============================================================================ //
    public function error()
    {
        return mysqli_error($this->db_link);
    }
// ============================================================================ //
    public function escape_string($value)
    {

        if (is_array($value)) {

            foreach ($value as $key => $string) {
                $value[$key] = $this->escape_string($string);
            }
            return $value;
        }
        return mysqli_real_escape_string($this->db_link, stripcslashes($value));
    }
// ============================================================================ //
    public function isFieldExists($table, $field)
    {
        $sql = "SHOW COLUMNS FROM $table WHERE Field = '$field'";
        $result = $this->query($sql);

        if ($this->errno()) {
            return false;
        }
        return (bool)$this->num_rows($result);
    }
// ============================================================================ //
    public function errno()
    {
        return mysqli_errno($this->db_link);
    }
// ============================================================================ //
    public function isFieldType($table, $field, $type)
    {

        $sql = "SHOW COLUMNS FROM $table WHERE Field = '$field' AND Type = '$type'";
        $result = $this->query($sql);

        if ($this->errno()) {
            return false;
        }
        return (bool)$this->num_rows($result);
    }
// ============================================================================ //
    /**
     * Добавляет массив записей в таблицу
     * ключи массива должны совпадать с полями в таблице.
     * param table =  string,
     * param insert_array= array,
     * param ignore,
     */
    public function insert($table, $insert_array, $ignore = false)
    {

        // убираем из массива ненужные ячейки
        $insert_array = $this->removeTheMissingCell($table, $insert_array);
        $set = '';

        // формируем запрос на вставку в базу

        foreach ($insert_array as $field => $value) {
            $set .= "{$field} = '{$value}',";
        }

        // убираем последнюю запятую

        $set = rtrim($set, ',');
        $i = $ignore ? 'IGNORE' : '';
        $this->query("INSERT ".$i." INTO ".$table." SET ".$set."");

        if ($this->errno()) {
            return false;
        }

        return $this->get_last_id($table);
    }
// ============================================================================ //
    /**
     * Убирает из массива ячейки, которых нет в таблице назначения
     * используется при вставке/обновлении значений таблицы
     */
    public function removeTheMissingCell($table, $array)
    {

        $result = $this->query("SHOW COLUMNS FROM `".$table."`");
        $list = array();
        while ($data = $this->fetch_assoc($result)) {
            $list[$data['Field']] = '1';
        }

        // убираем ненужные ячейки массива
        foreach ($array as $k => $v) {
            if (!isset($list[$k])) {
                unset($array[$k]);
            }
        }

        if (!$array || !is_array($array)) {
            return array();
        }
        return $array;
    }
// ============================================================================ //
    public function get_last_id($table = '')
    {

        if (!$table) {
            return (int)mysqli_insert_id($this->db_link);
        }

        $result = $this->query("SELECT LAST_INSERT_ID() as lastID FROM ".$table." LIMIT 1");

        if ($this->num_rows($result) > 0) {
            $data = $this->fetch_assoc($result);
            return $data['lastID'];
        } else {
            return 0;
        }
    }
// ============================================================================ //
    /**
     * Обновляет данные в таблице
     * ключи массива должны совпадать с полями в таблице
     * @param $table
     * @param $update_array
     * @param $id
     * @return bool
     */
    public function update($table, $update_array, $id)
    {

        if (isset($update_array['id'])) {
            unset($update_array['id']);
        }
        // id или where

        if (is_numeric($id)) {
            $where = "id = '{$id}' LIMIT 1";
        } else {
            $where = $id;
        }

        // убираем из массива ненужные ячейки

        $update_array = $this->removeTheMissingCell($table, $update_array);
        $set = '';

        // формируем запрос на вставку в базу

        foreach ($update_array as $field => $value) {
            $set .= "{$field} = '{$value}',";
        }

        // убираем последнюю запятую
        $set = rtrim($set, ',');
        $this->query("UPDATE ".$table." SET ".$set." WHERE ".$where."");

        if ($this->errno()) {
            return false;
        }
        return true;
    }
// ============================================================================ //
    public function delete($table, $where = '', $limit = 0)
    {

        $sql = "DELETE FROM ".$table." WHERE ".$where;

        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }

        $this->query($sql);

        if ($this->errno()) {
            return false;
        }

        return true;
    }
// ============================================================================ //
    public function stmt_bind_assoc(&$stmt, &$output)
    {
        $data = mysqli_stmt_result_metadata($stmt);
        $fields = array();
        $output = array();
        $fields[0] = $stmt;
        $count = 1;
        $currentTable = '';
        while ($field = mysqli_fetch_field($data)) {
            if (strlen($currentTable) == 0) {
                $currentTable = $field->table;
            }
            $fields[$count] = &$output[$field->name];
            $count++;
        }
        call_user_func_array('mysqli_stmt_bind_result', $fields);
    }
// ============================================================================ //
    public function setFlags($table, $items, $flag, $value)
    {
        foreach ($items as $id) {
            $this->setFlag($table, $id, $flag, $value);
        }
        return $this;
    }
// ============================================================================ //
    public function setFlag($table, $id, $flag)
    {
        $this->query("UPDATE ".$table." SET $flag WHERE id='".$id."'");
        return $this;
    }
}