<?php


// Підключаємося до бази даних
$conn = new PDO('mysql:host=localhost;dbname=test', 'username', 'password');

if ($conn->getAttribute(PDO::ATTR_CONNECTION_STATUS)) {
    // Виконання запиту
    $stmt = $conn->query('SELECT * FROM users');

    // Виведення результату запиту на екран
    while ($row = $stmt->fetch()) {
        echo $row['id'] . ' ' . $row['name'] . ' ' . $row['email'] . '<br>';
    }
} else {
    echo 'Connection failed';
}



?>

