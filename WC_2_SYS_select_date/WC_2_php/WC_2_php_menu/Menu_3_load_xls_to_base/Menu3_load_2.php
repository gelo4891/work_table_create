<?php
//echo $test1=$_FILES['Menu3_load_file']['tmp_name'];
// дані для FTP підключення
$ftp_server = "10.6.128.63";
$ftp_port = 21;
$ftp_username = "FZ_Oleg_User";
$ftp_password = "FZ_Oleg_User";

// завантаження файлу на сервер
$local_file = $_FILES['Menu3_load_file']['tmp_name'];
$remote_file = $_FILES['Menu3_load_file']['name'];

// встановлення з'єднання та авторизація на сервері FTP
$ftp_conn = ftp_connect($ftp_server, $ftp_port) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);

// перевірка з'єднання та завантаження файлу
if ($ftp_conn && $login) {
    if (ftp_put($ftp_conn, $remote_file, $local_file, FTP_BINARY)) {
        echo "File transfer successful!";
    } else {
        echo "File transfer failed!";
    }
} else {
    echo "FTP connection has failed!";
}

// закриття з'єднання
ftp_close($ftp_conn);

?>

