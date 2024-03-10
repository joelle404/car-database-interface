<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: login.html');   
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
    $date = $_POST["date"];
    $customer = $_POST["customer"];
    $car = $_POST["car"];

    // Insert data into the "orders" table
    $sql = "INSERT INTO orders (id, date, customer, car) VALUES ('$id', '$date', '$customer', '$car')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT id, date, customer, car FROM orders";
$result = $conn->query($sql);

echo "<h1>Orders Table</h1>";
echo "<h4>Primary key: id and Foreign key:customer and car</h4>";
echo "<h4>Make sure when you insert to not duplicate the primary key or use any new foreign key other than the displayed</h4>";


echo "<table>";
echo "<tr><th>ID</th><th>Date</th><th>Customer</th><th>Car</th></tr>";

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["customer"] . "</td><td>" . $row["car"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
$sql = "SELECT id FROM customer"; // Query to fetch values for the "customer" column
$customerResult = $conn->query($sql);
$sql = "SELECT name FROM car"; // Query to fetch values for the "car" column
$carResult = $conn->query($sql);
echo "<tr>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<td><input type='text' name='id' required></td>";
echo "<td><input type='text' name='date' required></td>";
echo "<td>";
echo "<label for='customer'>Customer:</label>";
echo "<select name='customer' required>";
while ($row = $customerResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}
echo "</select><br>";
echo"</td>";
echo"<td>";
echo "<label for='car'>Car:</label>";
echo "<select name='car' required>";
while ($row = $carResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";echo"</td>";

echo "</td>";


echo "<td><input type='submit' value='Add Order'></td>";
echo "</form>";
echo "</tr>";

echo '<a href="lab10.html">Return to Main Page</a>';
echo "</table>";
$conn->close();
?>
