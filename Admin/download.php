<?php
include('../connection.php');

// Add necessary error reporting and session handling here, if required.

if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $file_path = 'C:\xampp\htdocs\Miniproject\notice/' . $file ;
    

    // Check if the file exists and is readable.
    if (file_exists($file_path) && is_readable($file_path)) {
        // Set appropriate headers for file download.
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));

        // Output the file.
        readfile($file_path);
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}
?>
