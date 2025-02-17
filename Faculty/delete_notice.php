<?php
session_start();
include('../connection.php');

if(isset($_GET['ids'])){
  
    $all_id = explode(",", $_GET['ids']);
    $safe_ids = array_map(function ($id) use ($connect) {
        return "'" . mysqli_real_escape_string($connect, $id) . "'";
    }, $all_id);
    
    $uid = implode(",",$safe_ids);

$q=mysqli_query($connect,"delete from notice where id IN ($uid) ");
if($q){
    $_SESSION['status']="Data Deleted Successfully!";

   
}
else {
    $_SESSION['status']="Data Not Deleted";
}
    header("Location:notice.php");

}
?>