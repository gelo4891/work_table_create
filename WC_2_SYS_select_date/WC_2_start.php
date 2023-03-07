<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
    <link rel="stylesheet" href="WC_2_css/WC_2_file_start.css">
</head>
<body class="WC_2_start_class_html">
	<div>
        <h2>Увійдіть<br>до системи генерації запитів</h2>
    </div>

	<div>
     <form action="WC_2_php/WC_2_php_START_AUTH.php" method="post">
		<label for="WC_username">Username(Користувач):</label>
		<input type="text" id="WC_username" name="WC_username"><br><br>

		<label for="WC_password">Password (Пароль):</label>
		<input type="password" id="WC_password" name="WC_password"><br><br>
		<input type="submit" value="Login">
	 </form>
    </div>
</body>
</html>
