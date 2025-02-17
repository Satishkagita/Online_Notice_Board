<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//forget_password.php

include('../connection.php');

$message = '';

session_start();
if(isset($_POST['user_type'])){
$_SESSION['user_type'] = $_POST['user_type'];
}
if (isset($_SESSION["user_id"])) {
    header("location:homepage.php");
}

if (isset($_POST["submit"])) {
    if (empty($_POST["user_email"])) {
        $message = '<div class="alert alert-danger">Email Address is required</div>';
    } else {
        $user_email = trim($_POST["user_email"]);
        $user_activation_code = md5(rand());
        if (isset($_POST["submit"])) {
            if (empty($_POST["user_email"])) {
                $message = '<div class="alert alert-danger">Email Address is required</div>';
            } else {
                $user_email = trim($_POST["user_email"]);
                $user_activation_code = md5(rand());

                // Get the selected user type from the form
               
               
                $user_type = $_SESSION["user_type"];
                
                // Define the SQL statements based on the user type
                $query = "UPDATE $user_type SET user_activation_code = ? WHERE email = ?";
                $selectQuery = "SELECT id, email, user_activation_code, user_otp FROM $user_type WHERE email = ?";

                if (isset($query)) {
                    $statement1 = $connect->prepare($query);
                    $statement1->bind_param("ss", $user_activation_code, $user_email);
                    $statement1->execute();

                    $statement = $connect->prepare($selectQuery);
                    $statement->bind_param("s", $user_email);
                    $statement->execute();

                    // Rest of your code to fetch data, check the result, and bind results





                    $statement->store_result(); // Store the result set
                    if ($statement->num_rows() > 0) {

                        $statement->bind_result($id, $user_email, $user_activation_code, $user_otp);




                        while ($statement->fetch()) {
                            // Your code to process each row goes here


                            $user_otp = rand(100000, 999999);

                            $sub_query = "UPDATE $user_type SET user_otp = '$user_otp' WHERE id = '$id'";
                            $connect->query($sub_query);
        
                            // Send an email with the OTP
                
                            $connect->query($sub_query);

                            require_once '../emailNotification/vendor/autoload.php';

                            $mail = new PHPMailer;

                            $mail->IsSMTP();

                            $mail->Host = 'smtp.gmail.com';

                            $mail->Port = '587';

                            $mail->SMTPAuth = true;

                            $mail->Username = 'eboardnotifications@gmail.com';

                            $mail->Password = 'jvig htqh zqec visl';

                            $mail->SMTPSecure = 'tls';

                            $mail->From = 'eboardnotifications@gmail.com';

                            $mail->FromName = 'Online Notice';

                            $mail->AddAddress($user_email);

                            $mail->IsHTML(true);

                            $mail->Subject = 'Password reset request for your account';

                            $message_body = '
     <p>For reset your password, you have to enter this verification code when prompted: <b>' . $user_otp . '</b>.</p>
     <p>Sincerely,</p>
     ';

                            $mail->Body = $message_body;

                            if ($mail->Send()) {
                                echo '<script>alert("Please Check Your Email for password reset code")</script>';

                                echo '<script>window.location.replace("forgot_password.php?step2=1&code=' . $user_activation_code . '")</script>';
                            } else {
                                echo '<script>alert("email not sent")</script>';
                            }
                        }
                    } else {
                        $message = '<div class="alert alert-danger">Email Address not found in our record</div>';
                    }
                }
            }
        }
    }
}

if (isset($_POST["check_otp"])) {
    if (empty($_POST["user_otp"])) {
        $message = '<div class="alert alert-danger">Enter OTP Number</div>';
    } else {
        $user_type = $_SESSION["user_type"];
        $query = "SELECT * FROM $user_type WHERE user_activation_code = ? AND user_otp = ?";

        if (isset($query)) {

        $statement = $connect->prepare($query);

        $statement->bind_param("ss", $_POST["user_code"], $_POST["user_otp"]);

        $statement->execute(); // Execute the prepared statement

        $result = $statement->get_result(); // Get the result set

        if ($result->num_rows > 0) {
            echo '<script>window.location.replace("forgot_password.php?step3=1&code=' . $_POST["user_code"] . '")</script>';
        } else {
            $message = '<div class="alert alert-danger">Wrong OTP Number</div>';
        }
    }
    }
}

if (isset($_POST["change_password"])) {
    $new_password = $_POST["user_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password == $confirm_password) {
        $user_type = $_SESSION["user_type"];
        $query = "
  UPDATE $user_type
  SET password = '" . $new_password . "' 
  WHERE user_activation_code = '" . $_POST["user_code"] . "'
  ";

        $connect->query($query);

        echo '<script>window.location.replace("HomePage.php?reset_password=success")</script>';
    } else {
        $message = '<div class="alert alert-danger">Confirm Password is not match</div>';
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password script in PHP using OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://code.jquery.com/jquery.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .button {
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            background-color: #4886d2;
            color: black;
            border: none;
            font-size: 16px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
            float: left;
            cursor: pointer;

        }
    </style>
</head>

<body>
    <br />
    <div class="container">
        <h3 align="center">Password Reset</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:#4886d2">
                <h3 class="panel-title" style="color:black">Reset Your Password</h3>
            </div>
            <div class="panel-body">
                <?php

                echo $message;

                if (isset($_GET["step1"])) {
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Select User Type</label>
                            <select name="user_type" class="form-control">

                                <option value="admin">Admin</option>
                                <option value="hod">HOD</option>
                                <option value="faculty">Faculty</option>

                                <option value="student">Student</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Your Email</label>
                            <input type="text" name="user_email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="button" value="Send" />
                        </div>
                    </form>
                    <?php
                }
                if (isset($_GET["step2"], $_GET["code"])) {
                    ?>
                    <form method="POST">
                        <div class="form-group">
                            <label>Enter OTP Number</label>
                            <input type="text" name="user_otp" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>" />
                            <input type="submit" name="check_otp" class="button" value="Send" />
                        </div>
                    </form>
                    <?php
                }

                if (isset($_GET["step3"], $_GET["code"])) {
                    ?>
                    <form method="post">
                        <div class="form-group">
                            <label>Enter New Password</label>
                            <input type="password" name="user_password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Enter Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="user_code" value="<?php echo $_GET["code"]; ?>" />
                            <input type="submit" name="change_password" class="button" value="Change" />

                        </div>
                    </form>
                    <?php
                }

                ?>
            </div>
        </div>
    </div>
    <br />
    <br />
</body>

</html>