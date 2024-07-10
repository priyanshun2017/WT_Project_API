<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $upload_directory = 'uploads/';
    $upload_path = $upload_directory . basename($file['name']);

    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
}
?>
