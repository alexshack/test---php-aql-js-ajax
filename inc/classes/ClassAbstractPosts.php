<?php
abstract class AbstractPosts {
	protected $table;
	protected $where = [];
	protected $sort = [];
	protected $type;
	protected $posts;

	function __construct( $where = [], $sort = [], $type = 'public' ) {
		$this->where = $where;
		$this->sort = $sort;
		$this->type = $type;
		$this->posts = $this->getRows();
		if( is_array( $this->posts ) && count( $this->posts )) {
			$this->setupData();
		}

		return $this;	
	}

	abstract protected function setupData();

	function getRows() {
		$db = (new MyDB())->db;

		$sql = 'SELECT * FROM ' . $this->table;
		if (count($this->where)) {
			$sql .= ' WHERE';
			$i = 0;
			foreach ( $this->where as $key => $value ) {
				if ($i > 0) {
					$sql .= ' AND';	
				}
				if ( is_numeric( $value ) || str_contains( $value, 'NULL') || str_contains( $value, 'LIKE') ) {
					$sql .= " {$key} = {$value}";
				} else {
					$sql .= " {$key} = '{$value}'";
				}
				$i++;
			}
		}
		if (count($this->sort)) {
			$sql .= ' ORDER BY';
			$i = 0;
			foreach ($this->sort as $key => $value) {
				if ($i > 0) {
					$sql .= ',';	
				}
				$sql .= " {$key} {$value}";
				$i++;
			}
		}

		$result = mysqli_query($db, $sql);
		$posts = [];
		while ($row = mysqli_fetch_object($result)) {
			$posts[] = $row;
		}

        mysqli_close($db);

		return $posts;

	}

	public function getPosts() {
		return $this->posts;
	}

}