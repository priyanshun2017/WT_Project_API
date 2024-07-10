<?php
header('Content-Type: application/json');

$name = htmlspecialchars($_POST['name']);
$regno = htmlspecialchars($_POST['regno']);
$favmovie1 = htmlspecialchars($_POST['favmovie1']);
$favmovie2 = htmlspecialchars($_POST['favmovie2']);
$favmovie3 = htmlspecialchars($_POST['favmovie3']);

if (!empty($name) && !empty($regno)) {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "movie_app";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
    }

    $stmt = $conn->prepare("INSERT INTO favorites (name, regno, favmovie1, favmovie2, favmovie3) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $regno, $favmovie1, $favmovie2, $favmovie3);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'New records created successfully']);
    } else {
        echo json_encode(['error' => 'Error: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['error' => 'Name and registration number are required.']);
}
?>
