<?php

session_start();

if (!isset($_SESSION['username'])) {
    // If the session variable is not set, redirect to the login page
    header("Location:login.html");
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
$username = "root";
$password = "";
$dbname = "cars";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user input
    $id = $_POST["id"];
    $building = $_POST["building"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $country = $_POST["country"];

    // Insert data into the "address" table
    $sql = "INSERT INTO address (id, building, street, city, country) VALUES ('$id', '$building', '$street', '$city', '$country')";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, building, street, city, country FROM address";
$result = $conn->query($sql);
echo "<h1>Address Table</h1>";
echo"<h4>primarykey:id </h4>";

echo"<h4>make sure when you insert to not duplicate the primarykey or using any new foriegnkey other than the displayed</h4>";

echo "<table>";
echo "<tr><th>ID</th><th>Building</th><th>Street</th><th>City</th><th>Country</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td><td>" . $row["building"] . "</td><td>" . $row["street"] . "</td><td>" . $row["city"] ."</td><td>" . $row["country"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "<tr>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<td><input type='text' name='id' required></td>";
echo "<td><input type='text' name='building' required></td>";
echo "<td><input type='text' name='street' required></td>";
echo "<td><input type='text' name='city' required></td>";
echo "<td><input type='text' name='country' required></td>";
echo "<td><input type='submit' value='Add address'></td>";
echo "</form>";
echo "</tr>";

echo '<a href="lab10.html">Return to Main Page</a>';
echo "</table>";
$conn->close();
?>
