<?php
session_start();
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernamelogin = $_POST['username'];
    $passwordlogin = $_POST['password'];

    // SQL enjeksiyon saldırılarına karşı korunmak için hazırlıklı ifadeler kullanın
    $stmt = $connect->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $usernamelogin, $passwordlogin);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Giriş başarılı
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $usernamelogin;
        header("Location: index.php");
        exit();
    } else {
        // Giriş başarısız
        header("Location: login.html");
        exit();
    }

    $stmt->close();
    $connect->close();
}
?>
