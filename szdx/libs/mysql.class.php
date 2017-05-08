<?php
/**
 * @author     Jason
 * @version	   1.0.0
 */

class Mysql
{
	private $conn;

	function __construct()
	{
		if (defined('SAE_MYSQL_DB')) {
			$this->conn = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS)
			or die("Service busy,please try again.");
			mysql_select_db(SAE_MYSQL_DB);
		} else {
			$this->conn = mysql_connect(MYSQL_HOST.':'.MYSQL_PORT, MYSQL_USER, MYSQL_PASS)
			or die("Service busy,please try again.");
			mysql_query('SET NAMES UTF8');
			if (!mysql_select_db(MYSQL_DB, $this->conn)) {
				mysql_query("CREATE DATABASE MYSQL_DB", $this->conn);
			} //查询数据库是否存在，不存在则创建数据库。
		}
	}

	/**
	 * 查询数据
	 * @param string $ColumnName 列名
	 * @param string $TableName 表名
	 * @param string $Condition 查询条件
	 * @return boolean | array
	 */
	public function Select($ColumnName,$TableName,$Condition)
	{
		if (empty($ColumnName) or empty($TableName)) {
			return false;
		}
		$Condition = $Condition ? "Where ".$Condition : NULL;
		$result = mysql_query("SELECT $ColumnName FROM `$TableName` $Condition",$this->conn);
		if (!$result) {
			return false;
		}
		return mysql_fetch_array($result);
	}

	public function Selects($ColumnName,$TableName,$Condition)
	{
		if (empty($ColumnName) or empty($TableName)) {
			return false;
		}
		$Condition = $Condition ? "Where ".$Condition : NULL;
		$result = mysql_query("SELECT $ColumnName FROM `$TableName` $Condition",$this->conn);
		if (!$result) {
			return false;
		}
		return $result;
	}

	/**
	 * 查询数据条数
	 * @param string $ColumnName 列名
	 * @param string $TableName 表名
	 * @param string $Condition 查询条件
	 * @return boolean | integer
	 */
	public function Select_Rows($ColumnName,$TableName,$Condition)
	{
		if (empty($ColumnName) or empty($TableName)) {
			return false;
		}
		$Condition = $Condition ? "Where ".$Condition : NULL;
		$result = mysql_query("SELECT $ColumnName FROM `$TableName` $Condition",$this->conn);
		if (!$result) {
			return mysql_error();
		}
		return mysql_num_rows($result);
	}

	/**
	 * 删除数据
	 * @param string $TableName 表名
	 * @param string $Condition 条件
	 * @return boolean
	 */
	public function Delete($TableName,$Condition)
	{
		if (empty($TableName) or empty($Condition)) {
			return false;
		}
		$Condition = $Condition;
		$result = mysql_query("SELECT * FROM `$TableName` WHERE $Condition",$this->conn);
		$result_num = mysql_num_rows($result);
		if ($result_num == "0") {
			return false;
		}
		$result = mysql_query("DELETE FROM `$TableName` WHERE $Condition",$this->conn);
		if (!$result) {
			return false;
		}
        return true;
	}

	/**
	 * 插入数据
	 * @param string $TableName 表名
	 * @param array $ColumnName 列名
	 * @param array $Value 值
	 * @return boolean
	 */
	public function Insert($TableName,$ColumnName,$Value)
	{
		if (empty($TableName) or empty($Value)) {
			return false;
		}
		$result = mysql_query("INSERT INTO `$TableName` ($ColumnName) VALUES ($Value)",$this->conn);
		if (!$result) {
			return false;
		}
        return true;
	}

	/**
	 * 更新数据
	 * @param string $TableName 表名
	 * @param string $Update 更新语句
	 * @param string $Condition 条件
	 * @return boolean
	 */
	public function Update($TableName,$Update,$Condition)
	{
		if (empty($Update) or empty($TableName)) {
			return false;
		}
		$Condition = $Condition ? "Where ".$Condition : NULL;
		$result = mysql_query("UPDATE `$TableName` SET $Update $Condition",$this->conn);
		if (!$result) {
			return false;
		}
        return true;
	}

	/**
	 * 执行SQL语句
	 * @param string $TableName 表名
	 * @param string $Update 更新语句
	 * @param string $Condition 条件
	 * @return boolean
	 */
	public function Query($query)
	{
		$result = mysql_query($query, $this->conn);
		if (!$result) {
			return false;
		}
        return $result;
	}

}
?>
