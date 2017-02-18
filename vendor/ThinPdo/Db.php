<?php
namespace ThinPdo;

/**
 * A minimal wrapper for PHP's PDO class to make database access easier
 *
 * @version    1.2.1
 * @author     William Entriken <github.com@phor.net>
 * @copyright  2016 William Entriken
 * @license    MIT
 * @link       https://github.com/fulldecent/thin-pdo
 */

class Db extends \PDO {
    private $error;
    private $sql;
    private $bind;
    private $errorCallbackFunction;

    public function __construct($dsn, $user="", $passwd="", $options=array()) {
        if(empty($options)){
            $options = array(
                \PDO::ATTR_PERSISTENT => false,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            );
        }

        try {
            parent::__construct($dsn, $user, $passwd, $options);
            parent::exec("SET CHARACTER SET utf8");
            parent::exec("SET NAMES utf8");
        } catch (\PDOException $e) {
            trigger_error($e->getMessage());
            return false;
        }
    }

    private function debug() {
        if (empty($this->errorCallbackFunction)) {
            return;
        } 
        $error = array("Error" => $this->error);
        if(!empty($this->sql))
            $error["SQL Statement"] = $this->sql;
        if(!empty($this->bind))
            $error["Bind Parameters"] = trim(print_r($this->bind, true));
        $backtrace = debug_backtrace();
        if(!empty($backtrace)) {
            foreach($backtrace as $info) {
                if(isset($info["file"] ) && $info["file"] != __FILE__)
                    $error["Backtrace"] = $info["file"] . " at line " . $info["line"];
            }
        }
        $func = $this->errorCallbackFunction;
        $func($error);
    }

    public function delete($table, $where, $bind="") {
        $sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
        return $this->run($sql, $bind);
    }

    private function filter($table, $info) {
        $driver = $this->getAttribute(\PDO::ATTR_DRIVER_NAME);
        if($driver == 'sqlite') {
            $sql = "PRAGMA table_info('" . $table . "');";
            $key = "name";
        }
        elseif($driver == 'mysql') {
            $sql = "DESCRIBE `" . $table . "`;";
            $key = "Field";
        }
        else {
            $sql = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key = "column_name";
        }

        if(false !== ($list = $this->run($sql))) {
            $fields = array();
            foreach($list as $record)
                $fields[] = $record[$key];
            return array_values(array_intersect($fields, array_keys($info)));
        }
        return array();
    }

    private function cleanup($bind) {
        if(!is_array($bind)) {
            if(!empty($bind))
                $bind = array($bind);
            else
                $bind = array();
        }
		foreach($bind as $key => $val)
			$bind[$key] = stripslashes($val);
        return $bind;
    }

    public function insert($table, $info, $ignore=false) {
        $fields = $this->filter($table, $info);
        $sql = ($ignore?"INSERT IGNORE":"INSERT")." INTO `" . $table . "` (`" . implode($fields, "`, `") . "`) VALUES (:" . implode($fields, ", :") . ");";
        $bind = array();
        foreach($fields as $field)
            $bind[":$field"] = $info[$field];
        return $this->run($sql, $bind);
    }

    public function replace($table, $info) {
        $fields = $this->filter($table, $info);
        $sql = "REPLACE INTO `" . $table . "` (`" . implode($fields, "`, `") . "`) VALUES (:" . implode($fields, ", :") . ");";
        $bind = array();
        foreach($fields as $field)
            $bind[":$field"] = $info[$field];
        return $this->run($sql, $bind);
    }

    public function run($sql, $bind="") {
        $this->sql = trim($sql);
        $this->bind = $this->cleanup($bind);
        $this->error = "";

        try {
            $pdostmt = $this->prepare($this->sql);
            if($pdostmt->execute($this->bind) !== false) {
                if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ")\\s/i", $this->sql))
                    return $pdostmt->fetchAll(\PDO::FETCH_ASSOC);
                elseif(preg_match("/^(" . implode("|", array("delete", "insert", "replace", "update")) . ")\\s/i", $this->sql))
                    return $pdostmt->rowCount();
            }
        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            $this->debug();
            return false;
        }
    }

    public function select($table, $where="", $bind="", $fields="*", $extra="") {
        $sql = "SELECT " . $fields . " FROM `" . $table . "`";
        if(!empty($where))
            $sql .= " WHERE " . $where;
        $sql .= " $extra;";
        return $this->run($sql, $bind);
    }

    public function selectOne($table, $where="", $bind="", $fields="*", $extra="") {
        $row = $this->select($table, $where, $bind, $fields, $extra);
        if (count($row) == 0) {
            return NULL;
        }
        $rowOne = $row[0];
        return reset($rowOne);
    }

    // The function get a JSON-encodable object with debugging data
    public function setErrorCallbackFunction($errorCallbackFunction) {
        if (!function_exists($errorCallbackFunction)) {
            return;
        }
        $this->errorCallbackFunction = $errorCallbackFunction;
    }

    public function update($table, $info, $where, $bind="") {
        $fields = $this->filter($table, $info);
        $fieldSize = sizeof($fields);

        $sql = "UPDATE `" . $table . "` SET ";
        for($f = 0; $f < $fieldSize; ++$f) {
            if($f > 0)
                $sql .= ", ";
            $sql .= $fields[$f] . " = :update_" . $fields[$f];
        }
        $sql .= " WHERE " . $where . ";";

        $bind = $this->cleanup($bind);
        foreach($fields as $field)
            $bind[":update_$field"] = $info[$field];

        return $this->run($sql, $bind);
    }
}
?>
