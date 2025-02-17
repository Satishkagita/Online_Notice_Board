<?php
session_start();
include('../connection.php');
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // The rest of your code to fetch the user's profile
$q=mysqli_query($connect,"select * from student where name='$username'");
$rr=mysqli_num_rows($q);
?>
<?php include 'student_index.php';?>
    <div class="content">
    <link rel="stylesheet" href="faculty.css">
    <div>
    <h2><center>Profile</center></h2>
    <?php
    $i=1;
    while($row=mysqli_fetch_assoc($q)){
        echo '<div class="card">';
        
       echo '<form>';
       echo '<label>Name:</label>';
       echo $row['name'];
       echo '</form>';
       echo '<form>';
       echo '<label>Id:</label>';
        echo $id=$row['id'];
        echo '</form>';
        echo '<form>';
       echo '<label>Email:</label>';
        echo $row['email'];
        echo '</form>';
        echo '<form>';
       echo '<label>Phone No:</label>';
        echo $row['phno'];
        echo '</form>';
        echo '<form>';
        echo '<label>Year:</label>';
         echo $row['year'];
         echo '</form>';
         echo '<form>';
         echo '<label>Department:</label>';
          echo $row['dept'];
          echo '</form>';
          
           echo '<form>';
          echo '<label>Section:</label>';
           echo $row['section'];
           echo '</form>';
         echo '<form action="update.php" method="post">';
         echo "<input style='display:none';  name='update' value='{$row['id']}' >";
         echo '<button class="update" type="submit" >Update</button>';
         echo '</form>';
         echo '</div>';
        $i++;
    }?>
   <?php  ?>  
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>
</html>
<?php } else {
    // Handle the case where the user is not logged in or the session is not properly initialized.
    echo 'not set';
}?>