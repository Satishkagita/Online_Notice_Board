<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../connection.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

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
}
$q=mysqli_query($connect,"SELECT *
FROM notice
WHERE
    (sendto = 'student' OR sendto = 'All')
    AND (dept ='$dept' OR dept = 'All')
    AND (year = '$year' OR year = 'All')
    AND (section = '$section' OR section = 'All') ORDER BY id DESC;");
$rr=mysqli_num_rows($q);
?>
<?php include 'student_index.php';?>
    <div class="content">
    <link rel="stylesheet" href="faculty.css">
    <?php include 'searchnotice.html';?>
    <?php
if(!$rr){
    echo '<span style="font-size:25px;">Notice is not available.!</span>';?>

    <?php
}
else
{
    ?>
 
   
    <?php
    $i=1;
}
    
    ?>
   <?php
        if(isset($_POST['search'])){
         
       
            $search = isset($_POST['search']) ? $_POST['search'] : '';
            $search_conditions = array();
            
            // Check if the search input is a date
            if (strtotime($search)) {
                $formatted_search_date = date("Y-m-d", strtotime($search));
                $search_conditions[] = "DATE(date) = '$formatted_search_date'";
            } else {
                // Assume the search input is for other fields (id, sendto, year, section, dept, postedby)
                $fields_to_search = array('id', 'sendto', 'year', 'section', 'dept', 'postedby');
                foreach ($fields_to_search as $field) {
                    $search_conditions[] = "$field = '$search'";
                }
            }
            
            // Construct the WHERE clause based on the conditions
            $where_clause = implode(' OR ', $search_conditions);
            
            // Modify the SQL query to include the dynamic WHERE clause
            $query = "SELECT * FROM notice WHERE $where_clause ORDER BY id DESC;";
            $res = mysqli_query($connect, $query);
            
           
            
            $i=1;
            $num_rows=mysqli_num_rows($res);
            if($num_rows!=0){
            while($row=mysqli_fetch_assoc($res)){
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
        echo '</div>';
            }
        }
        else{
            echo '<td colspan="10" style="padding-top:50px;font-size:20px;">NO DATA FOUND</td>';
        }
    }
        else{
            $i=1;
        while($row=mysqli_fetch_assoc($q)){
        $i=1;
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
        $i++;
            //echo '<form method="get" action="$rows=$file->fetch_assoc()">';
            if ($row['file']) {
                echo '<form action="pdfdownload.php" method="get">';
                echo "<input value='{$row['file']}' name='file' style='display:none'>";
                echo '<button type="submit">Download PDF</button>';
                echo '</form>';
            }
            echo '</form>';
        echo '</div>';
        
         $i++;
        }
    }?>
        