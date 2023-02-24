<?php
class WorkClassAll {
	private $host;
	private $username;
	private $password;
	private $database;
	
	public function __construct($host, $username, $password, $database) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->database = $database;
	}
	
	// Метод підключення до бази даних
	public function connect_to_database($db_type) {
		if ($db_type == 'oracle') {
			// Підключення до бази даних Oracle
			$conn = oci_connect($this->username, $this->password, $this->host . '/' . $this->database);
			if (!$conn) {
				$e = oci_error();
				trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
			}
		} elseif ($db_type == 'mysql') {
			// Підключення до бази даних MySQL
			$conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}
		} else {
			die("Invalid database type.");
		}
		
		return $conn;
	}
}

// Приклад використання класу та методу
$host = 'localhost';
$username = 'myusername';
$password = 'mypassword';
$database = 'mydatabase';

$database_conn = new WorkClassAll ($host, $username, $password, $database);

// Підключення до бази даних Oracle
$conn_oracle = $database_conn->connect_to_database('oracle');

// Підключення до бази даних MySQL
$conn_mysql = $database_conn->connect_to_database('mysql');
?>
