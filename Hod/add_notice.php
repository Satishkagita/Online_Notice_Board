<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('../connection.php');
session_start();
if(isset($_POST['register'])){
    $id = $_POST['id'];
   $sendto = $_POST['sendto'];
   $year = $_POST['year'];
    $description = $_POST['description'];
    include('dept.php');
    if (isset($_SESSION['dept'])) {
        $dept = $_SESSION['dept'];
       
    } else {
        // Handle the case where 'dept' is not set in the session
        die('Error: The department is not set in the session.');
    }
    $pname =$_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir = 'C:\xampp\htdocs\MiniProject\notice';
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
   
        $query = "INSERT INTO notice ( id,sendto,dept,year, description, file, postedby,post) VALUES ('$id' ,'$sendto', '$dept','$year','$description',  '$pname',' $username','HOD')";
        mysqli_query($connect,$query);
        $_SESSION['status']= "Notice Sent successfully!!";
        $_SESSION['notice_id'] = $id; 
        $emailPath = $_SERVER['DOCUMENT_ROOT'] . '/Miniproject/Hod/email.php';

    if (file_exists($emailPath)) {
        include($emailPath);
    } else {
        echo "email.php file not found at: $emailPath";
    }

   exit();

}
header("Location: hodnotice.php?message=$message");
        exit();
?>