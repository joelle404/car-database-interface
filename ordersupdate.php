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
    input[type='text'], input[type='submit'], select {
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
    label {
        color: #333;
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

if(isset($_POST['update'])) {
    $id = $_POST["id"];
    $date = $_POST["date"];
    $customer = $_POST["customer"];
    $car = $_POST["car"];

    // Update query
    $sql = "UPDATE orders SET date=?, customer=?, car=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $date, $customer, $car, $id);
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT id, date, customer, car FROM orders";
$result = $conn->query($sql);
$sql = "SELECT id FROM orders"; // Query to fetch values for the "id" column
$idResult = $conn->query($sql);
$sql = "SELECT id FROM customer"; // Query to fetch values for the "customer" column
$customerResult = $conn->query($sql);
$sql = "SELECT name FROM car"; // Query to fetch values for the "car" column
$carResult = $conn->query($sql);

echo "<h1>Orders Table</h1>";

echo "<table>";
echo "<tr><th>ID</th><th>Date</th><th>Customer</th><th>Car</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["customer"] . "</td><td>" . $row["car"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

echo "<h2>Update Order</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='update' value='1'>";

// Combo box for the "id" column values
echo "<label for='id'>ID:</label>";
echo "<select name='id' required>";
while ($row = $idResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}
echo "</select><br>";

echo "<label for='date'>Date:</label><input type='date' name='date' required><br>";

// Combo box for the "customer" column values
echo "<label for='customer'>Customer:</label>";
echo "<select name='customer' required>";
while ($row = $customerResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}
echo "</select><br>";

// Combo box for the "car" column values
echo "<label for='car'>Car:</label>";
echo "<select name='car' required>";
while ($row = $carResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";

echo "<input type='submit' value='Update Order'>";
echo "</form>";
echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
