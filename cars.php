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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user input
    $name = $_POST["name"];
    $model = $_POST["model"];
    $year = $_POST["year"];
    $made = $_POST["made"];

    // Insert data into the "car" table
    $sql = "INSERT INTO car (name, model, year, made) VALUES ('$name', '$model', '$year', '$made')";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT name, model, year, made FROM car";
$result = $conn->query($sql);
echo "<h1>Car table</h1>";
echo"<h4>primarykey:name and foriegnkey:made</h4>";

echo"<h4>make sure when you insert to not duplicate the primarykey or using any new foriegnkey other than the displayed</h4>";

echo "<table>";
echo "<tr><th>Name</th><th>Model</th><th>Year</th><th>Made</th></tr>";

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["name"] . "</td><td>" . $row["model"] . "</td><td>" . $row["year"] . "</td><td>" . $row["made"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
$sql = "SELECT name FROM manufacture"; // Query to fetch names from manufacture table
$manufactureResult = $conn->query($sql);
echo "<tr>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<td><input type='text' name='name' required></td>";
echo "<td><input type='text' name='model' required></td>";
echo "<td><input type='text' name='year' required></td>";
echo "<td>";
echo "<label for='name'>made:</label>";

echo "<select name='made' required>";
while ($row = $manufactureResult->fetch_assoc()) {
    echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
}
echo "</select><br>";
echo"</td>";
echo "<td><input type='submit' value='Add Car'></td>";
echo "</form>";
echo "</tr>";

echo '<a href="lab10.html">Return to Main Page</a>';
echo "</table>";

$conn = null;
?>
