<?php
 
namespace App;
error_reporting(E_ALL);
ini_set('display_errors', 1); 
/**
 * PHP SQLite Insert Demo
 */
class SQLiteInsert {
 
    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;
 
    /**
     * Initialize the object with a specified PDO object
     * @param \PDO $pdo
     */
    public function __construct($pdo) 
	{
        $this->pdo = $pdo;		
		$this->pdo->exec('pragma synchronous = off;');
		$this->pdo->exec("PRAGMA journal_mode = MEMORY;");
		$this->pdo->exec("PRAGMA temp_store = MEMORY;");
    }
 
    /**
     * Insert a new project into the projects table
     * @param string $projectName
     * @return the id of the new project
     */

	public function begin()
	{
		$this->pdo->exec('BEGIN;');		
	}
	
	public function commit()
	{
		$this->pdo->exec('COMMIT;');		
	}	

	public function insertProject($projectName) {
        $sql = 'INSERT INTO projects(project_name) VALUES(:project_name)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':project_name', $projectName);
        $stmt->execute();
 
        return $this->pdo->lastInsertId();
    }
 
    /**
     * Insert a new task into the tasks table
     * @param type $taskName
     * @param type $startDate
     * @param type $completedDate
     * @param type $completed
     * @param type $projectId
     * @return int id of the inserted task
     */
    public function insertObj($call_str, $columns, $values) 
	{
        $sql = $call_str;
        $stmt = $this->pdo->prepare($sql);

        for($i = 0; $i < count($columns); $i++)
		{
			$stmt->bindParam(($i+1), $values[$i]);
        }
		//print_r($stmt);
		$stmt->execute();

		
        return $this->pdo->lastInsertId();	
		
	    // $sql = 'INSERT INTO tasks(task_name,start_date,completed_date,completed,project_id) '
         //       . 'VALUES(:task_name,:start_date,:completed_date,:completed,:project_id)';
 
        //$stmt = $this->pdo->prepare($sql);
        //$stmt->execute([
        //    ':task_name' => $taskName,
        //    ':start_date' => $startDate,
        //    ':completed_date' => $completedDate,
        //    ':completed' => $completed,
        //    ':project_id' => $projectId,
        //]);
 
        //return $this->pdo->lastInsertId();
    }
	
	public function createIndex()
	{
		$sql = "CREATE INDEX `index1` ON `all_WT` (`uid`	ASC);";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
	}
 
}