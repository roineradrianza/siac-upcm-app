<?php 

/**
 * 
 */

class UPCMS
{
	private $table = "upcms";
	private $id_column = "upcm_id";

	function __construct() {
	}
	public function get(int $id = 0, $columns = []) {
		$columns = empty($columns) ? '*' : implode(',', $columns);
		if ($id != 0) {
			$sql = "SELECT $columns FROM " . $this->table. " WHERE ". $this->id_column. " = $id";
		}
		else{
			$sql = "SELECT $columns FROM ". $this->table;
		}
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}
	public function get_info(int $id = 0) {
		if ($id == 0) return false;
		$sql = "SELECT upcm_logo, upcm_name, upcm_key, upcm_country, upcm_state, count(user_id) AS members FROM " . $this->table. " AS up INNER JOIN users AS u ON up.upcm_id = u.upcm_id WHERE up.". $this->id_column. " = $id";
		$result = execute_query($sql);
		if (!$result) return '';
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}
	public function create($data = [], $columns = []) {
		if (empty($data)) return false;
		$columns = implode(',',$columns);
		extract($data);
		$sql = "INSERT INTO " . $this->table . " ($columns) VALUES('$upcm_name', '$upcm_key', '$upcm_coordinator_key', '$upcm_country', '$upcm_state');";
		$result = execute_query_return_id($sql);
		return $result;
	}
	public function edit($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE " . $this->table . " SET upcm_name = '$upcm_name', upcm_key = '$upcm_key', upcm_coordinator_key = '$upcm_coordinator_key', upcm_country = '$upcm_country', upcm_state = '$upcm_state' WHERE " . $this->id_column . " = $id;";
		$result = execute_query($sql);
		return $result;
	}
	public function edit_name($id, $data = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE " . $this->table . " SET upcm_name = '$upcm_name' WHERE " . $this->id_column . " = $id;";
		$result = execute_query($sql);
		return $result;
	}
	public function update_logo($id, $upcm_logo) {
		if (empty($upcm_logo) OR empty($id)) return false;
		$sql = "UPDATE " . $this->table . " SET upcm_logo = '$upcm_logo' WHERE " . $this->id_column . " = $id;";
		$result = execute_query($sql);
		return $result;
	}
	public function delete($id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM " . $this->table . " WHERE ". $this->id_column. " = $id;";
		$result = execute_query($sql);
		return $result;
	}

}