<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="update.css">
</head>
<body>
<?php
session_start();
$image=$_SESSION['image'];
include('../connection.php');
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phno = $_POST['phno'];
    $password = $_POST['password'];

    if($_FILES["file"]["name"]==''){
        $pname = $image;
    }
    else{
        $pname = $_FILES["file"]["name"];
    }
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir = 'C:\xampp\htdocs\Miniproject\Admin\image';
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
  $query = mysqli_query($connect, "update admin set
        name='$name',email='$email', phno='$phno',
        password='$password', image='$pname' where id='$id'");
    $_SESSION['image']=$pname;
    }

?>
<?php include 'admin_index.php';?>
<div class="content1">


<?php

if (isset($_POST['update'])) {
    $update = $_POST['update'];
    $query1 = mysqli_query($connect, "select * from admin where id='$update'");
    while ($row1 = mysqli_fetch_array($query1)) {
        echo "<h2><center>Update Form</center></h2>";
        echo "<hr />";
        // Open the form tag here
        echo "<form method='POST' action='update.php' enctype='multipart/form-data'>";
        echo "<div class='upload'>";
        echo "<img src='image/{$row1['image']}' width = 125 height = 125 title='{$row1['image']}'>";
        echo "<div class='round'>";
          echo "<input type='file' name='file' id = 'image' value='{$row1['image']}' accept='.jpg, .jpeg, .png'>";
          echo "<i class = 'fa fa-camera' style = 'color: #fff;'></i>";
          echo "</div>";
          echo "</div>";
      
        echo "<input class='input' type='hidden' name='id' value='{$row1['id']}' />";
        echo "<br />";
        echo "<label for='name'>" . "Name" . "</label>" . "<br />";
        echo "<input class='input' type='text' name='name' id='name' pattern='[a-zA-Z ]*' required title='Only letters are allowed'  value='{$row1['name']}' />";
        echo "<br />";
        echo "<label>" . "Email" . "</label>" . "<br />";
        echo "<input class='input' type='email' name='email' value='{$row1['email']}' />";
        echo "<br />";
        echo "<label>" . "Mobile Number" . "</label>" . "<br />";
        echo "<input class='input' type='text' name='phno' pattern='[0-9]{10}' value='{$row1['phno']}' title=' It should be 10 digits.' required/>";
        echo "<br />";
        echo "<label>" . "Password" . "</label>" . "<br />";
        echo "<input class='input' type='password' name='password' value='{$row1['password']}' />";
        echo "<br />";
        echo "<input class='submit' type='submit' name='submit' value='update' id='updateButton' />";
        echo "</form>"; 
    }
}

if (isset($_POST['submit']) and empty($message)) {
    echo '<div class="form" id="form3">
    <Span>Data Updated Successfully......!!</span></div>';
}
?>



</div>
</body>
</html>
