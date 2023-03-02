<?php
// Підключаємо файли з конфігурацією бази даних та класом QueryBuilder
require_once __DIR__ . '/Work_Class/W_C_all.php';
require_once __DIR__ . '/config/WTC_config.php';

// Запускаємо сесію
session_start();

// Перевіряємо, чи користувач вже авторизований, і перенаправляємо його на іншу сторінку, якщо так
if(isset($_SESSION['user'])) {
    header('Location: welcome.php');
    exit;
}

// Якщо форма була відправлена, обробляємо її дані
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Витягуємо дані з форми
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Перевіряємо дані користувача з базою даних
    //$qb = new WorkClassAll() ;
	$qb = new WorkClassAll ();
    //$user = $qb->boz_user('users', array('username' => $username, 'password' => $password))->first();

    // Якщо користувач існує, зберігаємо його дані в сесії та перенаправляємо на нову сторінку
    if($user) {
        $_SESSION['user'] = $user;
        header('Location: test.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if(isset($error)): ?>
    <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>