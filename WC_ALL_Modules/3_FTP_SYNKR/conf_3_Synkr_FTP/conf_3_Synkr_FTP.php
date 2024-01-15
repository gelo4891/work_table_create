<?php

class FTPMonitor {
    private $ftpHost;
    private $ftpUsername;
    private $ftpPassword;
    private $ftpDirectory;
    private $localPath;
    private $uploadedFilesPath;

    public function __construct($host, $username, $password, $directory, $localPath, $uploadedFilesPath) {
        $this->ftpHost = $host;
        $this->ftpUsername = $username;
        $this->ftpPassword = $password;
        $this->ftpDirectory = $directory;
        $this->localPath = $localPath;
        $this->uploadedFilesPath = $uploadedFilesPath;
    }

    public function monitorFTP() {
        // Встановлення з'єднання з FTP-сервером
        $ftp = ftp_connect($this->ftpHost);
        ftp_login($ftp, $this->ftpUsername, $this->ftpPassword);
        ftp_chdir($ftp, $this->ftpDirectory);

        // Отримання списку файлів на FTP-сервері
        $files = ftp_nlist($ftp, ".");

        // Перевірка наявності нових та модифікованих файлів
        foreach ($files as $filename) {
            $localFile = $this->localPath . '/' . $filename;
            if (!file_exists($localFile) || ftp_mdtm($ftp, $filename) > filemtime($localFile)) {
                // Якщо файл відсутній локально або був змінений на FTP-сервері, і не був завантажений раніше, завантажуємо його
                if (!$this->isFileUploaded($filename)) {
                    $newFilename = $filename;
                    if (file_exists($localFile)) {
                        $newFilename = 'UP' . $filename;
                    }
                    if (ftp_get($ftp, $this->localPath . '/' . $newFilename, $filename, FTP_BINARY)) {
                        echo "Завантажено файл: $filename\n";
                        // Збереження інформації про завантажений файл
                        $this->saveToFile($filename, date('Y-m-d H:i:s'));
                    } else {
                        echo "Помилка завантаження файлу: $filename\n";
                    }
                }
            }
        }

        // Закриття з'єднання з FTP-сервером
        ftp_close($ftp);
    }

    private function saveToFile($filename, $date) {
        $data = "$filename|$date\n";
        file_put_contents($this->uploadedFilesPath, $data, FILE_APPEND);
    }

    private function isFileUploaded($filename) {
        $uploadedFiles = file($this->uploadedFilesPath, FILE_IGNORE_NEW_LINES);
        foreach ($uploadedFiles as $uploadedFile) {
            list($uploadedFilename, $uploadedDate) = explode('|', $uploadedFile);
            if ($filename === $uploadedFilename) {
                return true;
            }
        }
        return false;
    }
}

// Використання класу FTPMonitor
$ftpHost = '10.80.48.160';
$ftpUsername = 'yurii.ivakhnenkov';
$ftpPassword = 'Admin2099';
$ftpDirectory = '/out';

$localPath = '/path/test';
$uploadedFilesPath = 'uploaded_files.txt';

$monitor = new FTPMonitor($ftpHost, $ftpUsername, $ftpPassword, $ftpDirectory, $localPath, $uploadedFilesPath);
$monitor->monitorFTP();

?>
