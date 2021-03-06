<?php 

/**
 * 
 */

class Articles
{
	private $table = "articles";
	private $id_column = "article_id";

	function __construct() {
	}
	public function get(int $id = 0, $columns = []) {
		$columns = empty($columns) ? '*' : implode(',', $columns);
		if ($id != 0) {
			$sql = "SELECT $columns FROM {$this->table} WHERE {$this->id_column} = $id";
		}
		else{
			$sql = "SELECT $columns FROM {$this->table}";
		}
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr;
	}

	public function get_article($slug, $columns = []) {
		$columns = empty($columns) ? '*' : implode(',', $columns);
		if ($slug == '') return [];
		$sql = "SELECT $columns FROM {$this->table} WHERE slug = '$slug'";
		$result = execute_query($sql);
		$arr = [];
		while ($row = $result->fetch_assoc()) {
			$arr[] = $row;
		}
		return $arr[0];
	}
	public function create($data = [], $columns = []) {
		if (empty($data)) return false;
		$columns = implode(',',$columns);
		extract($data);
		$sql = "INSERT INTO {$this->table} ($columns) VALUES('$image', '$title', '$slug', '$content', '$description', {$_SESSION['user_id']});";
		$result = execute_query_return_id($sql);
		return $result;
	}
	public function edit($id, $data = [], $columns = []) {
		if (empty($data) OR empty($id)) return false;
		extract($data);
		$sql = "UPDATE {$this->table} SET image = '$image', title = '$title', slug = '$slug', content = '$content', description = '$description' WHERE {$this->id_column} = $id;";
		$result = execute_query($sql);
		return $result;
	}
	public function delete($id) {
		if (empty($id)) return false;
		$sql = "DELETE FROM {$this->table} WHERE {$this->id_column} = $id;";
		$result = execute_query($sql);
		return $result;
	}

}