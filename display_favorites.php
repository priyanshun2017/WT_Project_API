<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "movie_app";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT favmovie1, favmovie2, favmovie3 FROM favorites";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>";
    
    echo "<table>
            <tr>
                <th>Favorite Movie 1</th>
                <th>Favorite Movie 2</th>
                <th>Favorite Movie 3</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["favmovie1"]) . "</td>
                <td>" . htmlspecialchars($row["favmovie2"]) . "</td>
                <td>" . htmlspecialchars($row["favmovie3"]) . "</td>
              </tr>";
    }
    
    echo "</table>";
} else {
    echo "No results found.";
}

$conn->close();
?>
