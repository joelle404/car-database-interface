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
    input[type='text'] {
        background-color: rgb(206, 206, 137); /* Light background for input */
        color: #333; /* Dark text color */
        width: 70%; /* Adjust as needed */
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
if(isset($_POST['search'])) {
    $searchTerm = $conn->real_escape_string($_POST["search_term"]);

    // Search query
    $sql = "SELECT car, part FROM car_part WHERE car LIKE ? OR part LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If not searching, select all records
    $sql = "SELECT car, part FROM car_part";
    $result = $conn->query($sql);
}

echo "<h1>Car Part Search Results</h1>";



echo "<table>";
echo "<tr><th>Car</th><th>Part</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["car"]) . "</td><td>" . htmlspecialchars($row["part"]) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No results found</td></tr>";
}

echo "</table>";

echo "<h2>Search for a Car Part</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='search' value='1'>";
echo "<label for='search_term'>Search Term:</label><input type='text' name='search_term' required><br>";
echo "<input type='submit' value='Search'>";
echo "</form>";

echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
