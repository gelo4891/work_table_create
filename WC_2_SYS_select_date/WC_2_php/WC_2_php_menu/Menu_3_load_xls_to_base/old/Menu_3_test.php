<?php
//phpinfo();
/*------------------------PDO_odbc-----------------------------------*/
// Підключення до бази даних Oracle за допомогою PDO_ODBC
/*$conn = new PDO('odbc:ODBS_dell720','test_c','test_c');

$sql = "SELECT ROWID, PRINTER_INVENTAR_NUMBER, PRINTER_SERIALL_NUMBER, PRINTER_NAME, PRINTER_KIMNATA, PRINTER_PIDROZDIL FROM TEST_C.KAR_PRINTER_INFO";
$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>ROWID</th><th>PRINTER_INVENTAR_NUMBER</th><th>PRINTER_SERIALL_NUMBER</th><th>PRINTER_NAME</th><th>PRINTER_KIMNATA</th><th>PRINTER_PIDROZDIL</th></tr>";

foreach ($result as $row) {
    echo "<tr><td>" . $row['ROWID'] . "</td><td>" . $row['PRINTER_INVENTAR_NUMBER'] . "</td><td>" . $row['PRINTER_SERIALL_NUMBER'] . "</td><td>" . $row['PRINTER_NAME'] . "</td><td>" . $row['PRINTER_KIMNATA'] . "</td><td>" . $row['PRINTER_PIDROZDIL'] . "</td></tr>";
}

echo "</table>";
$conn = null;
/*------------------------odbc-----------------------------------*/
// Підключення до бази даних Oracle за допомогою ODBC
/*$conn = odbc_connect('ODBS_dell720','test_c','test_c');

if (!$conn) {
    die("Connection failed: " . odbc_errormsg());
}
$sql = "SELECT ROWID, PRINTER_INVENTAR_NUMBER, PRINTER_SERIALL_NUMBER, PRINTER_NAME, PRINTER_KIMNATA, PRINTER_PIDROZDIL FROM TEST_C.KAR_PRINTER_INFO";
$result = odbc_exec($conn, $sql);
echo "<table border='1'>";
echo "<tr><th>ROWID</th><th>PRINTER_INVENTAR_NUMBER</th><th>PRINTER_SERIALL_NUMBER</th><th>PRINTER_NAME</th><th>PRINTER_KIMNATA</th><th>PRINTER_PIDROZDIL</th></tr>";
while ($row = odbc_fetch_array($result)) {
    echo "<tr><td>" . $row['ROWID'] . "</td><td>" . $row['PRINTER_INVENTAR_NUMBER'] . "</td><td>" . $row['PRINTER_SERIALL_NUMBER'] . "</td><td>" . $row['PRINTER_NAME'] . "</td><td>" . $row['PRINTER_KIMNATA'] . "</td><td>" . $row['PRINTER_PIDROZDIL'] . "</td></tr>";
}
echo "</table>";
odbc_close($conn);

/*------------------------oci8-----------------------------------*/
/*
$conn = oci_connect('test_c', 'test_c', '//10.6.128.18:1521/region06');
if (!$conn) {
    $error = oci_error();
    throw new Exception('Oracle connection failed: ' . $error['message']);
}

/*------------------------PDO_odbc-----------------------------------*/

/*---------------------------------------------------------------------*/
/*------------------------PDO-----------------------------------*/

try {
    $conn = new PDO('oci:dbname=//10.6.128.18:1521/dell720', 'test_c', 'test_c');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "SELECT ROWID, PRINTER_INVENTAR_NUMBER, PRINTER_SERIALL_NUMBER, PRINTER_NAME, PRINTER_KIMNATA, PRINTER_PIDROZDIL FROM TEST_C.KAR_PRINTER_INFO";
    $result = $conn->query($sql);
    
    echo "<table border='1'>";
    echo "<tr><th>ROWID</th><th>PRINTER_INVENTAR_NUMBER</th><th>PRINTER_SERIALL_NUMBER</th><th>PRINTER_NAME</th><th>PRINTER_KIMNATA</th><th>PRINTER_PIDROZDIL</th></tr>";
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>" . $row['ROWID'] . "</td><td>" . $row['PRINTER_INVENTAR_NUMBER'] . "</td><td>" . $row['PRINTER_SERIALL_NUMBER'] . "</td><td>" . $row['PRINTER_NAME'] . "</td><td>" . $row['PRINTER_KIMNATA'] . "</td><td>" . $row['PRINTER_PIDROZDIL'] . "</td></tr>";
    }
    
    echo "</table>";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/*
phpinfo();
*/
?>

