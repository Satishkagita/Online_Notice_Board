<?php
include('../connection.php');
session_start();
include('dept.php');
if(isset($_POST['register'])){
    $rollno = $_POST['rollno'];
    $email = $_POST['email'];
    $phno =$_POST['phno'];
    $name = $_POST['name'];
    echo $phno;
    $sql_rollno=mysqli_query($connect,"select * from student where id='$rollno'");
    $sql_email=mysqli_query($connect,"select * from student where email='$email'");
    $sql_phno=mysqli_query($connect,"select * from student where phno='$phno'");
   
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
   
 
        $year=$_POST['year'];

        $section=$_POST['section'];
        $query = "INSERT INTO student (id, name, email, phno, dept, year,section) VALUES ('$rollno', '$name', '$email', '$phno', '$dept', '$year','$section')";
        mysqli_query($connect,$query);
        $_SESSION['status']= "Registration successfull !!";
       
}
if (headers_sent()) {
    echo "Headers already sent. Redirect failed.";
} else {
    header("Location:studentmanagement.php?message=$message");
    exit();
}

}

?>