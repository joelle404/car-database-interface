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
    $name = $_POST["name"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $made = $_POST["made"];

    // Update query
    $sql = "UPDATE car SET model=?, year=?, made=? WHERE name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $model, $year, $made, $name);
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}

$sql = "SELECT name, model, year, made FROM car";
$result = $conn->query($sql);
$sql = "SELECT name FROM manufacture"; // Query to fetch names from manufacture table
$manufactureResult = $conn->query($sql);
$sql = "SELECT name FROM car"; // Query to fetch names from manufacture table
$id = $conn->query($sql);
echo "<h1>Car Table</h1>";
echo "<table>";
echo "<tr><th>Name</th><th>Model</th><th>Year</th><th>Made</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td><td>" . $row["model"] . "</td><td>" . $row["year"] . "</td><td>" . $row["made"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}

echo "</table>";

echo "<h2>Update Car</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='update' value='1'>";

// Combo box for names from the "manufacture" table
echo "<label for='name'>made:</label>";

echo "<select name='name' required>";
while ($row = $id->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";

echo "<label for='model'>Model:</label><input type='text' name='model' required><br>";
echo "<label for='year'>Year:</label><input type='text' name='year' required><br>";
echo "<label for='name'>made:</label>";

echo "<select name='made' required>";
while ($row = $manufactureResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";
echo "<input type='submit' value='Update Car'>";
echo "</form>";
echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
