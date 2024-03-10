<?php
session_start();

if (!isset($_SESSION['username'])) {
    // If the session variable is not set, redirect to the login page
    header("Location: login.html");
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
    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $address = $_POST["address"];
    $job = $_POST["job"];

    // Update query
    $sql = "UPDATE customer SET f_name=?, l_name=?, address=?, job=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $f_name, $l_name, $address, $job, $id);
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT id, f_name, l_name, address, job FROM customer";
$result = $conn->query($sql);
$sql2 = "SELECT id FROM customer"; // Query to fetch values for the "id" column
$idResult = $conn->query($sql2);
$sql3 = "SELECT id FROM address"; // Query to fetch values for the "address" column
$addressResult = $conn->query($sql3);

echo "<h1>Customer Table</h1>";

echo "<table>";
echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Job</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td><td>" . $row["address"] . "</td><td>" . $row["job"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

echo "<h2>Update Customer</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='update' value='1'>";

// Combo box for the "id" column values
echo "<label for='id'>ID:</label>";
echo "<select name='id' required>";
while ($row = $idResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}

echo "</select><br>";
echo "<label for='f_name'>First Name:</label><input type='text' name='f_name' required><br>";
echo "<label for='l_name'>Last Name:</label><input type='text' name='l_name' required><br>";
// Combo box for the "address" column values
echo "<label for='address'>Address:</label>";
echo "<select name='address' required>";
while ($row = $addressResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}
echo "</select><br>";


echo "<label for='job'>Job:</label><input type='text' name='job' required><br>";
echo "<input type='submit' value='Update Customer'>";
echo "</form>";
echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
