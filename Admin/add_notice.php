<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('../connection.php');
session_start();
if(isset($_POST["submit"])){
    $id = $_POST['id'];
   $sendto = $_POST['sendto'];
    $description = $_POST['description'];
    $year= $_POST['year'];
    $dept = $_POST['dept'];
    // $date = $_POST['date'];
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    $pname = $_FILES["file"]["name"];
    $tname = $_FILES["file"]["tmp_name"];
    $uploads_dir = 'C:\xampp\htdocs\Miniproject\notice';
    move_uploaded_file($tname, $uploads_dir.'/'.$pname);
try{
        $query = "INSERT INTO notice ( id,sendto, dept,year,description,file, postedby,post) VALUES ('$id' ,'$sendto','$dept','$year', '$description', '$pname', '$username','Admin')";
        mysqli_query($connect,$query);
        $_SESSION['status']= "Notice Sent successfully !!";
        $_SESSION['notice_id'] = $id; 
    $emailPath = $_SERVER['DOCUMENT_ROOT'] . '/Miniproject/Admin/email.php';

    if (file_exists($emailPath)) {
        include($emailPath);
    } else {
        echo "email.php file not found at: $emailPath";
    }

   exit();

}
catch (mysqli_sql_exception $e) {
    // Handle the duplicate entry error here
    $_SESSION['error_message'] = "Duplicate entry";
}
}
header("Location: notice.php?message=$message");
        exit();

?>