<?php
namespace App;
 
/**
 * SQLite connnection
 */
class SQLiteConnection {
    /**
     * PDO instance
     * @var type 
     */
    private $pdo;
	private $name;
 
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect($name) 
	{
        if ($this->pdo == null) 
		{
            try {
				$this->pdo = new \PDO("sqlite:" . $name);
			} catch (\PDOException $e) {
				echo "Error";
			}
        }
        return $this->pdo;
    }
}

?>