<?php
/*
############# How to user the Class Databese #############
Connect to database as constructor
$myDB = new myDB("localhost", "class", "root", "");
or
$myDB->connect("localhost", "class", "root", "");

Example inputs
$table = "data";
$array = array(
	"title" => "Title",
	"content" => "Content",
	"count" => 1
);

// Insert
if($myDB->isExist($table, array("title" => "Title")))echo "Exist!";
else echo $myDB->insert($table, $array);

// Delete
$myDB->delete($table, "id=4");

// Update
$myDB->update($table, array("title" => "New Title"), array("id" => 1));
$myDB->update($table, array("title" => "New Title"), "id=1");

// Select
$arr = $myDB->select($table, "*");
$myDB->formatLine($arr);
$myDB->formatTable($arr);
$myDB->formatPre($arr);

// Pagination
echo $db->page("data", "", $curPage, 3, 2)['html'];
$items = $db->select("data", "*", "", "ORDER BY id ASC", true);

*/

/**
 * This class describes my db.
 */
class myDB
{
	public $pdo;
	public $result;
	public $page;

    function __construct($host = "localhost", $dbname = "test", $user = "root", $pass = "", $charset = "utf8")
    {
		$this->connect($host, $dbname, $user, $pass, $charset);
	}

    function __destruct() {
        $this->pdo = null;
    }

	function connect($host, $dbname, $user, $pass, $charset = "utf8")
	{
	    try {
	        $this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset='.$charset, $user, $pass);
	        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        return true;
	    }
	    catch(PDOException $e){
		    die($e->getMessage());
		    return false;
	    }
	}
	/**
	 * @param      array   $inputs  The inputs array("key" => "value");
	 * @return     int     latest id
	 */

	function insert($table, $inputs)
	{
		$query = $this->queryInsert($inputs);
		try {
		    $sql = "INSERT INTO `{$table}` ({$query['field']}) VALUES ({$query['parameter']});";
		    $stmt = $this->pdo->prepare($sql);
			$stmt->execute($inputs);
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
		return $this->pdo->lastInsertId();
	}
	/**
	 * @param      array   $inputs  The inputs array("key" => "value");
	 * @param      str/arr  $where   The where array("key" => "value") / "key=value"
	 */

	function update($table, $inputs, $where)
	{
		$query = $this->queryUpdate($inputs);
		$where = $this->querySearch($where);
		try {
			$sql = "UPDATE {$table} SET {$query} {$where}";
		    $stmt = $this->pdo->prepare($sql);
			$stmt->execute($inputs);
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
	}
	/**
	 * @param      str/arr  $where    The where
	 * @param      string  $orderBy  The order by
	 * @return     array  results
	 */

	function select($table, $select = "*", $where = "", $orderBy = "ORDER BY `id` ASC", $showPage = false)
	{
		$where = $this->querySearch($where);
		$limit = "";
		if($showPage == true)
		{
			if(!empty($this->page))
				$limit = "{$this->page['begin']}, {$this->page['perpage']}";
			else
				$limit = "0, 5";
			if(strpos("LIMIT", $orderBy) === false)$limit = " LIMIT {$limit}";
		}
		try {
			$stmt = $this->pdo->prepare("SELECT {$select} FROM {$table} {$where} {$orderBy} {$limit};");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
		$this->result = $results;
		return $results;
	}

	function size($table, $where = "")
	{
		$where = $this->querySearch($where);
		try {
			$stmt = $this->pdo->query("SELECT count(*) FROM {$table} {$where};");
			return $stmt->fetchColumn();
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
	}

	function page($table, $where = "", $currentPage = 1, $perPage = 5, $offset = 3)
	{
		$WHERE = "&";
		$c = 1;
		foreach ($_GET as $key => $value) {
			if($key != 'p') {
				$WHERE .= "{$key}={$value}&";
			}
		}
        $total_rows = $this->size($table, $where);
        $total_pages = ceil($total_rows / $perPage);
    	$html = "<ul class='pagination'>";
        if($currentPage != 1)$html .= "<li class='page-item'><a class='page-link' href='?p=1{$WHERE}'>First</a></li>";
        for($i = $currentPage - $offset; $i <= $currentPage + $offset; $i++)
        {
        	if($i < 1 || $i > $total_pages)continue;
        	if($i == $currentPage)$html .= "<li class='page-item active'><a class='page-link' href='javascript:void();' >{$i}</a></li>";
        	else $html .= "<li class='page-item'><a class='page-link' href='?p={$i}{$WHERE}'>{$i}</a></li>";
        }
        if($currentPage != $total_pages)$html .= "<li class='page-item'><a class='page-link' href='?p=$total_pages{$WHERE}'>Last</a></li>";
    	$html .= '</ul>';
        return $this->page = array(
        	"perpage" => $perPage,
        	"begin" => ($currentPage - 1) * $perPage,
        	"html" => $html
        );
	}
	/**
	 * @param      str/arr  $where  The where
	 */

	function delete($table, $where)
	{
		$where = $this->querySearch($where);
		try {
			$stmt = $this->pdo->prepare("DELETE FROM {$table} {$where};");
			$stmt->execute();
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
	}
	/**
	 * @param      str/arr   $inputs  The inputs
	 * @return     boolean  True if exist, False otherwise.
	 */

	function isExist($table, $where)
	{
		$where = $this->querySearch($where);
		try {
			$stmt = $this->pdo->prepare("SELECT * FROM {$table} {$where};");
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e){
		    die($e->getMessage());
		}
		return ($results)?true:false;
	}
	/**
	 * @param      array   $array  The array
	 * @return     string  ( description_of_the_return_value )
	 */

	function formatLine($array = "")
	{
		if(empty($array))$array = $this->result;
		$html = "";
		$html .= join(", ", array_keys($array[0])) . "<br />";
		foreach ($array as $key => $value) {
			$html .= join(", ", $value) . "<br />";
		}
		echo $html;
	}
	/**
	 * @param      array  $array  The array
	 */

	function formatTable($array = "")
	{
		if(empty($array))$array = $this->result;
		$style = "<style>
			table {width: 100%;}
			table, th, td {border: 1px solid black; border-collapse: collapse; }
			td {padding: 5px; }
			</style>";
		$html = "<table>";
		$html .= "<thead><tr>";
		foreach (array_keys($array[0]) as $key => $value) {
			$html .= "<th>{$value}</th>";
		}
		$html .= "</tr></thead>";
		$html .= "<tbody>";
		foreach ($array as $key => $value) {
			$html .= "<tr>";
			foreach ($value as $l => $v) {
				if($l == "title")
					$html .= "<td>".substr($v, 0, 50)."...</td>";
				else
					$html .= "<td>{$v}</td>";
			}
			$html .= "</tr>";
		}
		$html .= "</tbody>";
		$html .= "</table>";
		echo $style.$html;
	}

	function formatPre($array = "")
	{
		if(empty($array))$array = $this->result;
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}
	/**
	 * Helper functions.
	 */

	function queryInsert($inputs)
	{
		$result['field'] = $result['parameter'] = "";
		$c = 1;
		foreach ($inputs as $key => $value) {
			if($c < count($inputs))
			{
				$result['field'] .= "`{$key}`, ";
				$result['parameter'] .= ":{$key}, ";
			}
			else
			{
				$result['field'] .= "`{$key}`";
				$result['parameter'] .= ":{$key}";
			}
			$c++;
		}
		return $result;
	}

	function queryUpdate($inputs)
	{
		$result = "";
		$c = 1;
		foreach ($inputs as $key => $value) {
			if($c < count($inputs))
				$result .= "`{$key}`=:{$key}, ";
			else
				$result .= "`{$key}`=:{$key} ";
			$c++;
		}
		return $result;
	}

	function querySearch($inputs)
	{
		if(!$inputs)return;
		if(!is_array($inputs))
		{
			return "WHERE " . $inputs;
		}
		$result = "";
		$c = 1;
		foreach ($inputs as $key => $value) {
			if($c < count($inputs))
				$result .= "`{$key}`='{$value}' AND ";
			else
				$result .= "`{$key}`='{$value}' ";
			$c++;
		}
		return "WHERE " . $result;
	}
}

