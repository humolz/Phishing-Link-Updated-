<?php
$username = 'admin';
$password = '58602004';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        file_put_contents('../logs.txt', '');
        echo 'Logs have been reset successfully.';
    } else {
        echo 'Invalid credentials.';
    }
}
?>

