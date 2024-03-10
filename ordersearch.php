<?php
session_start();
if (!isset($_SESSION['username'])){
    header('Location: login.html');   
}

// Existing style code
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
$dbname = "cars"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if(isset($_POST['search'])) {
    $searchTerm = $conn->real_escape_string($_POST["search_term"]);

    // Search query modified for orders table
    $sql = "SELECT id, date, customer, car FROM orders WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $searchTerm); // assuming id is an integer
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If not searching, select all records
    $sql = "SELECT id, date, customer, car FROM orders";
    $result = $conn->query($sql);
}

echo "<h1>Order Search Results</h1>";

// Existing style code...

echo "<table>";
echo "<tr><th>ID</th><th>Date</th><th>Customer</th><th>Car</th></tr>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["date"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["customer"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["car"]) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No results found</td></tr>";
}

echo "</table>";

echo "<h2>Search for an Order</h2>";
echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
echo "<input type='hidden' name='search' value='1'>";
echo "<label for='search_term'>Search ID:</label><input type='text' name='search_term' required><br>";
echo "<input type='submit' value='Search'>";
echo "</form>";

echo '<a href="lab10.html">Return to Main Page</a>';

$conn->close();
?>
