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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect user input
    $id = $_POST["id"];
    $building = $_POST["f_name"];
    $street = $_POST["l_name"];
    $city = $_POST["address"];
    $country = $_POST["job"];

    // Insert data into the "address" table
    $sql = "INSERT INTO customer (id,  f_name, l_name, address,job) VALUES ('$id', '$building', '$street', '$city', '$country')";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$sql = "SELECT id, f_name, l_name,address, job FROM customer";
$result = $conn->query($sql);
echo"<h1> customer table</h1>";
echo"<h4>primarykey:id and foriegnkey:address</h4>";

echo"<h4>make sure when you insert to not duplicate the primarykey or using any new foriegnkey other than the displayed</h4>";

echo "<table>";
echo "<tr><th>id</th><th>f_name</th><th>l_name</th><th>address</th><th>job</th></tr>";

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td><td>" . $row["f_name"] . "</td><td>" . $row["l_name"] . "</td><td>" . $row["address"] ."</td><td>" . $row["job"] . "</td>";
        echo "</tr>";
    }
} else {
    echo "0 results";
}
$sql3 = "SELECT id FROM address"; // Query to fetch values for the "address" column
$addressResult = $conn->query($sql3);
echo "<tr>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<td><input type='text' name='id' required></td>";
echo "<td><input type='text' name='f_name' required></td>";
echo "<td><input type='text' name='l_name' required></td>";
echo "<td>";
echo "<select name='address' required>";
while ($row = $addressResult->fetch_assoc()) {
    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
}
echo "</select><br>";
echo"</td>";
echo "<td><input type='text' name='job' required></td>";
echo "<td><input type='submit' value='Add customer'></td>";
echo "</form>";
echo "</tr>";

echo '<a href="lab10.html">Return to Main Page</a>';
echo "</table>";
$conn->close();
?>
