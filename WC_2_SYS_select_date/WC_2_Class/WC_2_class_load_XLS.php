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
        
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
    
    public function uploadXlsToTable(string $filename, string $tablename): void {
        $spreadsheet = IOFactory::load($filename);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        
        $columns = implode(",", $worksheet->toArray()[0]);
        $values = "";
        
        foreach ($rows as $row) {
            $values .= "(";
            foreach ($row as $cell) {
                $values .= "'" . addslashes($cell) . "', ";
            }
            $values = rtrim($values, ', ');
            $values .= "), ";
        }
        $values = rtrim($values, ', ');
        
        $query = "INSERT INTO $tablename ($columns) VALUES $values";
        
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
    
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
        
        $query = "INSERT INTO $tablename ($columns) VALUES $values";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
    }
}
?>