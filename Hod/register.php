<?php
session_start();
include('dept.php');
include('../connection.php');

if(isset($_POST['register'])){
    $rollno = $_POST['rollno'];
    $email = $_POST['email'];
    $phno =$_POST['phno'];
    $name =$_POST['name'];
    $sql_rollno=mysqli_query($connect,"select * from faculty where id='$rollno'");
    $sql_email=mysqli_query($connect,"select * from faculty where email='$email'");
    $sql_phno=mysqli_query($connect,"select * from faculty where phno='$phno'");
  
    $n_rollno=mysqli_num_rows($sql_rollno);
    $n_email=mysqli_num_rows($sql_email);
    $n_phno=mysqli_num_rows($sql_phno);
    
    
    $message="";
    if($n_rollno){
        $message="User Already Exists!";
    }
    elseif(!preg_match("/^[ a-zA-Z ]*$/",$name))
    {
           $message="Only letters are allowed";
    }
    elseif (!preg_match('/^[0-9]{10}$/', $phno)) {
        $message = "Phone number should be exactly 10 digits and contain only digits.";
    }
    elseif($n_phno){
        $message="Phone Number Already Exists";
    }
   
    elseif($n_email){
        $message="Email Already Exists";
    }
   
  
    

    else{
       $query = "INSERT INTO faculty (id, name, email, phno, dept, post) VALUES ('$rollno', '$name', '$email', '$phno', '$dept', 'Faculty')";
        mysqli_query($connect,$query);
        $_SESSION['status']= "Registration successfull !!";
       
}
header("Location: facultymanagement.php?message=$message");
        exit();
}

?>