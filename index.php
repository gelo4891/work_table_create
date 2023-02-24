<!DOCTYPE html>
<html>
<head>
	<title>Список таблиць Oracle</title>
</head>
<body>
	<h1>Список таблиць Oracle</h1>
	
	<!-- Форма вибору таблиці -->
	<form method="POST" action="process.php">
		<label for="table_name">Виберіть таблицю:</label>
		<select name="table_name" id="table_name">
			<?php

                echo '<link rel="stylesheet" href="../css/style_lab_1-13_1.css">';
                
				// Підключення до бази даних Oracle
				$conn = oci_connect('username', 'password', 'db_server/db_name');
				
				// Отримання списку таблиць
				$sql = "SELECT table_name FROM user_tables";
				$stmt = oci_parse($conn, $sql);
				oci_execute($stmt);
				
				// Виведення випадаючого списку з таблицями
				while (($row = oci_fetch_array($stmt, OCI_ASSOC)) != false) {
					echo "<option value='" . $row['TABLE_NAME'] . "'>" . $row['TABLE_NAME'] . "</option>";
				}
			?>
		</select>
		<button type="submit">Показати</button>
	</form>
</body>
</html>
