<?php
session_start();
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "cars";

$user_input_username = $_POST['username'];
$user_input_password = $_POST['password'];
$encpass = md5($user_input_password);

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = "SELECT * FROM login WHERE username = '$user_input_username' AND password='$encpass'";

$result = $conn->query($stmt);

if ($result->num_rows > 0) {
    $_SESSION['username']=$user_input_username;

    header('Location:lab10.php');   

}
else{
    header('Location:login2.html');   

}

$conn->close();
?>