<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../connection.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];}
    // Retrieve department, year, and section
    $query = mysqli_query($connect, "SELECT dept, year, section FROM student WHERE name = '$username'");

    if ($query) {
        $data = mysqli_fetch_assoc($query);

        if ($data) {
            $dept = $data['dept'];
            $year = $data['year'];
            $section = $data['section'];

            // Now, you have 'dept', 'year', and 'section' in variables
        } else {
            echo "No data found for the given username.";
        }
    } else {
        die('Error: ' . mysqli_error($connect));}
if (isset($_POST['search_button'])) {
    $search_date = mysqli_real_escape_string($connect, $_POST['search_date']);
    $search_posted_by = mysqli_real_escape_string($connect, $_POST['search_posted_by']);
    $search_query = "SELECT * FROM notice
        WHERE (sendto = 'student' OR sendto = 'all')
        AND (dept = '$dept' OR dept = 'all')
        AND (year = '$year' OR year = 'all')
        AND (section = '$section' OR section = 'all')";

    if (!empty($search_date)) {
        $search_query .= " AND 'date' LIKE '%$search_date%'";
    }

    if (!empty($search_posted_by)) {
        $search_query .= " AND postedby LIKE '%$search_posted_by%'";
    }

    $q = mysqli_query($connect, $search_query);
    $rr = mysqli_num_rows($q);
} else {
    // Your existing code here
    $q = mysqli_query($connect, "SELECT * FROM notice
        WHERE (sendto = 'student' OR sendto = 'all')");

    $rr = mysqli_num_rows($q);
}
?>
<!-- Include your HTML header and navigation here -->
<div class="content">
<link rel="stylesheet" href="css/faculty.css">
    <?php
    if (!$rr) {
        echo '<span style="font-size:25px;">No matching notices found.</span>';
    } else {
        $i = 1;
        while ($row = mysqli_fetch_assoc($q)) {
            // Display your search results here
            echo '<div class="card">';
        echo '<div class="chechbox">';
        echo '<td><input type="checkbox" class="recordCheckbox" name="recordsToDelete[]" value="' . $row['id'] . '" style="display:none;"></td>';
        echo '</div>';
        echo '<div class="inner_header">';
        echo $row['postedby'];
        echo '</div>';
        echo '<div class="under">';
        $dateString = $row['date']; // Replace this with your actual date string
        $dateTime = new DateTime($dateString);
        echo $dateTime->format('d M Y H:i');
        
        echo '</div>';
        echo $row['description'];
        }
    }
    ?>
</div>

<!-- Include your HTML footer here -->
