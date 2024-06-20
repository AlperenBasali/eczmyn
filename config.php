<?php   

$host = "localhost";
$username = "alperen";
$password = "1234";
$database = "eczmyn";

$connect = mysqli_connect($host,$username,$password,$database);

if(mysqli_connect_errno() > 0){
    die("hata: ".mysqli_connect_errno());
}




?>