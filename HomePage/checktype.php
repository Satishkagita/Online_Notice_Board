<?php  
session_start();
include('../connection.php');

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
    
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$username = test_input($_POST['username']);
	$password = test_input($_POST['password']);
	$role = test_input($_POST['role']);

	if (empty($username)) {
		header("Location: ../HomePage/HomePage.php?error=User Name is Required");
	}else if (empty($password)) {
		header("Location: ../HomePage/HomePage.php?error=Password is Required");
	}else {

		// Hashing the password
		//$password = md5($password);
        
        $sql = "SELECT * FROM $role WHERE name='$username' AND password='$password'";
        $result = mysqli_query($connect, $sql);

        if ( $result && mysqli_num_rows($result)===1) {
        	// the user name must be unique
        	$row = mysqli_fetch_assoc($result);
        	if ($row['name'] === $username && $row['password'] === $password) {
        		if($role=="student"){
					$_SESSION['username']=$username;
					$_SESSION['image']=$row['image'];
					header("location:..\student\student_index.php");
                }
               else if($role=="admin"){
				   $_SESSION['username']=$username;
				   $_SESSION['image']=$row['image'];
                    header("location:..\admin\admin_index.php");
                }
                else if($role=="hod"){
					$_SESSION['username']=$username;
					$_SESSION['image']=$row['image'];
                    header("location:..\hod\hod_index.php");
                }
                else if($role=="faculty"){
					$_SESSION['username']=$username;
					$_SESSION['image']=$row['image'];
					header("Location: ..\Faculty\Faculty_index.php");

                }

        		

        	}else {
        		header("Location: ../HomePage/HomePage.php?error=Incorrect User name or password");
        	}
        }else {
        	header("Location: ../HomePage/HomePage.php?error=Incorrect User name or password");
        }

	}
	
}else {
	header("Location: ../HomePage/HomePage.php");
  
}