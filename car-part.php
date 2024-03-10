<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

echo "<style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(146, 146, 105);
        color: #fff;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        color: #333; /* Dark text for contrast */
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
    th {
        background-color: rgb(206, 206, 137);
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    a {
        background-color: rgb(118, 151, 118);
        color: white;
        padding: 8px 16px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }
    a:hover {
        background-color: rgb(100, 130, 100);
    }
    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
    }
    input[type='text'], input[type='submit'] {
        padding: 8px;
        margin: 10px 0;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
    input[type='submit'] {
        background-color: rgb(118, 151, 118);
        color: white;
        cursor: pointer;
    }
    input[type='submit']:hover {
        background-color: rgb(100, 130, 100);
    }
</style>";
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "cars";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling for car_part
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car = $_POST["car"];
    $part = $_POST["part"];

    $stmt = $conn->prepare("INSERT INTO car_part (car, part) VALUES (?, ?)");
    $stmt->bind_param("ss", $car, $part);
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch data for the combo boxes
$sqlCar = "SELECT name FROM car";
$sqlPart = "SELECT no FROM device";
$carResult = $conn->query($sqlCar);
$partResult = $conn->query($sqlPart);

// Display car_part table
$sql = "SELECT car, part FROM car_part";
$result = $conn->query($sql);

echo "<h1>car_part table</h1>";
echo "<table>";
echo "<tr><th>car</th><th>part</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["car"] . "</td><td>" . $row["part"] . "</td></tr>";
    }
} else {
    echo "0 results";
}
echo "<tr>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<td>";
echo "<label for='car'>car:</label>";

echo "<select name='car' required>";
while ($row = $carResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";
echo"</td>";
echo "<td>";
echo "<label for='part'>part:</label>";

echo "<select name='part' required>";
while ($row = $partResult->fetch_assoc()) {
    echo "<option value='" . $row['no'] . "'>" . $row['no'] . "</option>";
}
echo "</select><br>";
echo"</td>";
echo "<td><input type='submit' value='Add Car'></td>";
echo "</form>";
echo "</tr>";
echo '<a href="lab10.html">Return to Main Page</a>';

echo "</table>";




$conn->close();
?>
