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
    $no = $_POST["no"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $weight = $_POST["weight"];
    $made = $_POST["made"];

    // Update query
    $sql = "UPDATE device SET name=?, price=?, weight=?, made=? WHERE no=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $price, $weight, $made, $no);
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT no, name, price, weight, made FROM device";
$result = $conn->query($sql);
$sql = "SELECT no FROM device"; // Query to fetch values for the "no" column
$noResult = $conn->query($sql);
$sql = "SELECT name FROM manufacture"; // Query to fetch names from manufacture table
$manufactureResult = $conn->query($sql);

echo "<h1>Device Table</h1>";

echo "<table>";
echo "<tr><th>No</th><th>Name</th><th>Price</th><th>Weight</th><th>Made</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["no"] . "</td><td>" . $row["name"] . "</td><td>" . $row["price"] . "</td><td>" . $row["weight"] . "</td><td>" . $row["made"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

echo "<h2>Update Device</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='update' value='1'>";

// Combo box for the "no" column values
echo "<label for='no'>No:</label>";
echo "<select name='no' required>";
while ($row = $noResult->fetch_assoc()) {
    echo "<option value='" . $row['no'] . "'>" . $row['no'] . "</option>";
}
echo "</select><br>";

echo "<label for='name'>name:</label><input type='text' name='name' required><br>";

echo "<label for='price'>Price:</label><input type='text' name='price' required><br>";
echo "<label for='weight'>Weight:</label><input type='text' name='weight' required><br>";
// Combo box for the "name" column values
echo "<label for='made'>made:</label>";
echo "<select name='made' required>";
while ($row = $manufactureResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' value='Update Device'>";
echo "</form>";
echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
