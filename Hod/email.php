<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../connection.php'; // Assuming your connection file is one level above the current directory
require_once '../emailNotification/vendor/autoload.php';

try {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'eboardnotifications@gmail.com';
    $mail->FromName = 'Online Notice';
    $mail->Password = 'jvig htqh zqec visl';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('eboardnotifications@gmail.com');

        if (isset($_SESSION['notice_id'])) {
            $notice_id = $_SESSION['notice_id'];

            unset($_SESSION['notice_id']);
    } else {
        die("Notice ID not provided in the URL.");
    }
    function getNoticeText($notice_id, $connect) {
        $query = "SELECT description, sendto,dept, year FROM notice WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "i", $notice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if ($result && $row = mysqli_fetch_assoc($result)) {
            $data = array(
                'description' => $row['description'],
                'sendto' => $row['sendto'],
                'year'=> $row['year'],
                'dept'=> $row['dept']
            );
          
        
    
            return $data;
        } else {
            return "Notice not found";
        }
    }
    

   
        $mail->addReplyTo('eboardnotifications@gmail.com');
        $notice_text = getNoticeText( $notice_id , $connect); // user-defined function
        $mail->isHTML(true);
   
        $mail->Body = "<p>Description: {$notice_text['description']}</p>";
        $mail->AltBody = 'This is for non-HTML content';
        
        if ($notice_text !== "Notice not found") {
            $mail->isHTML(true);
            $mail->Subject = 'Online notice';
            $mail->Body = "<p>{$notice_text['description']}</p>";
            $sendto = trim($notice_text['sendto']);
            $dept = $notice_text['dept'];  
            // Depending on the 'sendto' value, add recipients to the email
            if ($sendto == "All") {
                // Select email addresses from the faculty table
                $facultyQuery = "SELECT email FROM faculty where dept=?";
                $facultyStmt = mysqli_prepare($connect, $facultyQuery);
                mysqli_stmt_bind_param($facultyStmt, "s", $dept);
                mysqli_stmt_execute($facultyStmt);
                $facultyResult = mysqli_stmt_get_result($facultyStmt);
        
                if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                    while ($row = mysqli_fetch_assoc($facultyResult)) {
                        $mail->addBCC($row['email']);
                    }
                }
        
                // Select email addresses from the student table
                $studentQuery = "SELECT email FROM student WHERE dept = ?";
                $studentStmt = mysqli_prepare($connect, $studentQuery);
                mysqli_stmt_bind_param($studentStmt, "s", $dept);
                mysqli_stmt_execute($studentStmt);
                $studentResult = mysqli_stmt_get_result($studentStmt);
            
        
                if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                    while ($row = mysqli_fetch_assoc($studentResult)) {
                        $mail->addBCC($row['email']);
                    }
                }
            } elseif ($sendto === "Faculty") {
                // Select email addresses from the faculty table
                $facultyQuery = "SELECT email FROM faculty WHERE dept = ?";
                $facultyStmt = mysqli_prepare($connect, $facultyQuery);
                mysqli_stmt_bind_param($facultyStmt, "s", $dept);
                mysqli_stmt_execute($facultyStmt);
                $facultyResult = mysqli_stmt_get_result($facultyStmt);
            
                if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                    while ($row = mysqli_fetch_assoc($facultyResult)) {
                        $mail->addBCC($row['email']);
                    }
                }
            }  elseif ($sendto === "Student" && $year === "All") {
                // Send to all students
                $studentQuery = "SELECT email FROM student WHERE dept = ?";
    $studentStmt = mysqli_prepare($connect, $studentQuery);
    mysqli_stmt_bind_param($studentStmt, "s", $dept);
    mysqli_stmt_execute($studentStmt);
    $studentResult = mysqli_stmt_get_result($studentStmt);

        
                if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                    while ($row = mysqli_fetch_assoc($studentResult)) {
                        $mail->addBCC($row['email']);
                    }
                }
            }elseif ($sendto=== "Student") {
                $year = $notice_text['year'];
    $studentQuery = "SELECT email FROM student WHERE dept = ? AND year = ?";
    $studentStmt = mysqli_prepare($connect, $studentQuery);
    mysqli_stmt_bind_param($studentStmt, "si", $dept, $year);
    mysqli_stmt_execute($studentStmt);
    $studentResult = mysqli_stmt_get_result($studentStmt);

         
    if ($studentResult && mysqli_num_rows($studentResult) > 0) {
        while ($row = mysqli_fetch_assoc($studentResult)) {
            $mail->addBCC($row['email']);
        }
    } else {
        echo "No students found for the specified year.";
    }
            } else {
                

                echo "Invalid 'sendto' value.";
            }
        
            $mail->AltBody = 'This is for non-HTML content';
        
            // Rest of your code for sending the email
        } else {
            die("Notice not found");
        }

        if ($mail->send()) {
          header("location:hodnotice.php");
        } else {
            $errorInfo = $mail->ErrorInfo;
            if (stripos($errorInfo, 'SMTP connect() failed') !== false) {
                echo "Error sending notification: No internet connection";
            } else {
                echo "Error sending notification: " . $errorInfo;
            }
        }
    

} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
