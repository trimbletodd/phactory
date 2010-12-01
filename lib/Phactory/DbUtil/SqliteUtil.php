<?php

class Phactory_DbUtil_SqliteUtil{

	protected $_pdo;

	public function __construct()
	{ 
		$this->_pdo = Phactory::getConnection();
	}
	
	public function getPrimaryKey($table)
	{
		$stmt = $this->_pdo->prepare("SELECT * FROM sqlite_master WHERE type='table' AND name=:name");
        $stmt->execute(array(':name' => $table));
		$result = $stmt->fetch();
        $sql = $result['sql'];	

        $matches = array();
        preg_match('/(\w+?)\s+\w+?\s+PRIMARY KEY/', $sql, $matches);

        if(!$matches[1]) {
            return null;
        }
		return $matches[1]; 
	}

    public function getColumns($table) {
        $stmt = $this->_pdo->query("PRAGMA table_info($table)");
        $columns = array();
        while($row = $stmt->fetch()) {
            $columns[] = $row['name'];
        }
        return $columns;
    }

    public function disableForeignKeys() {
    }

    public function enableForeignKeys() {
    }
}
