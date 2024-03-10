<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "cars";

$user_input_username = $_POST['username'];
$user_input_password = $_POST['password'];
$hashed_password = md5($user_input_password);

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO login (username, password) VALUES ('$user_input_username', '$hashed_password')";
$result = $conn->query($sql);

if ($result) {
    echo"you have succesfully registrated";
    header('Location:login.html');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
