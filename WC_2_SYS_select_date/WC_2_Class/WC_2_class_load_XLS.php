<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class XlsUploader {
    
    private $connection;
    
    public function __construct($conn) {
        $this->connection = $conn;
    }
    
public function createTableFromXls(string $filename, string $tablename): void {
    $spreadsheet = IOFactory::load($filename);
    $worksheet = $spreadsheet->getActiveSheet();
    $columns = $worksheet->toArray()[0];
    
    $query = "CREATE TABLE $tablename (";
    foreach ($columns as $col) {
        $query .= "$col VARCHAR(255), ";
    }
    $query = rtrim($query, ', ');
    $query .= ")";
    
    $stmt = $this->connection->prepare("SELECT table_name FROM user_tables WHERE table_name = :tablename");
    $stmt->execute(['tablename' => strtoupper($tablename)]);
    $tableExists = ($stmt->fetchColumn() > 0);

    if (!$tableExists) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        echo "Table $tablename created successfully";
    } else {
        echo "Table $tablename already exists";
    }
}
	



/*--------------------------------------------------------------------------------------------*/    
public function uploadXlsToTable(string $filename, string $tablename): void {
    $spreadsheet = IOFactory::load($filename);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = array_slice($worksheet->toArray(), 1);

    $columns = implode(",", $worksheet->toArray()[0]);
    $values = "";

    foreach ($rows as $row) {
        $values .= " INTO $tablename (";
        foreach ($row as $index => $cell) {
            $values .= $worksheet->toArray()[0][$index] . ",";
        }
        $values = rtrim($values, ',');
        $values .= ") VALUES (";
        foreach ($row as $cell) {
            $cell_cp1251 = iconv("UTF-8", "CP1251//TRANSLIT", $cell);
            $cell_escaped = str_replace("'", "''", $cell_cp1251);
            $values .= "'" . $cell_escaped . "', ";
        }
        $values = rtrim($values, ', ');
        $values .= ")";
    }

    $query = "INSERT ALL $values SELECT * FROM dual";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
}
/*--------------------------------------------------------------------------------------------*/    

    
    public function readXlsFile(string $filename): Worksheet {
        $spreadsheet = IOFactory::load($filename);
        return $spreadsheet->getActiveSheet();
    }
    
    public function getXlsColumns(string $filename): array {
        $worksheet = $this->readXlsFile($filename);
        return $worksheet->toArray()[0];
    }
    
    public function getXlsRows(string $filename): array {
        $worksheet = $this->readXlsFile($filename);
        return $worksheet->toArray();
    }
    
    public function getXlsData(string $filename): array {
        $data = array();
        $columns = $this->getXlsColumns($filename);
        $rows = $this->getXlsRows($filename);
        foreach ($rows as $row) {
            $data[] = array_combine($columns, $row);
        }
        return $data;
    }
    
    public function insertXlsData(string $filename, string $tablename): void {
        $data = $this->getXlsData($filename);
        $columns = implode(",", $this->getXlsColumns($filename));
        $values = "";
        foreach ($data as $row) {
            $values .= "(";
            foreach ($row as $cell) {
                $values .= "'" . addslashes($cell) . "', ";
            }
            $values = rtrim($values, ', ');
            $values .= "), ";
        }
        $values = rtrim($values, ', ');
        
       echo  $query = "INSERT INTO $tablename ($columns) VALUES $values";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
}
?>