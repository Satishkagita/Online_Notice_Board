<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../connection.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // The rest of your code to fetch the user's profile
   $dept_query = mysqli_query($connect, "SELECT dept FROM faculty WHERE name = '$username'");

if ($dept_query) {
    // Check if the query was successful
    $dept_row = mysqli_fetch_assoc($dept_query);
    
    if ($dept_row) {
        // Check if a result row was returned
        $dept = $dept_row['dept'];
        // Assign the department value to the session variable
        $_SESSION['dept'] = $dept;
    } else {
        echo "No department found for the given username.";
    }
} else {
    // Handle the error if the query fails
    die('Error: ' . mysqli_error($connect));
}

// Check if 'dept' is set in the session

}
?>