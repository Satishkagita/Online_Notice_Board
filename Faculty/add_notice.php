<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('../connection.php');
session_start();
include('dept.php');
if(isset($_POST["register"])){
    $id = $_POST['id'];
   $year = $_POST['year'];
   $section = $_POST['section'];
    $description = $_POST['description'];
    $pname = $_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir = 'C:\xampp\htdocs\MiniProject\notice';
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);

        $query = "INSERT INTO notice ( id,sendto,dept,year,section ,description ,file,postedby, post) VALUES ('$id' ,'Student','$dept', '$year','$section','$description', '$pname', '$username','Faculty')";
        mysqli_query($connect,$query);
        $_SESSION['status']= "Notice Sent successfully !!";
        $_SESSION['notice_id'] = $id; 
    $emailPath = $_SERVER['DOCUMENT_ROOT'] . '/Miniproject/Faculty/email.php';

    if (file_exists($emailPath)) {
        include($emailPath);
    } else {
        echo "email.php file not found at: $emailPath";
    }

   exit();

}
header("Location: notice.php?message=$message");
        exit();
?>