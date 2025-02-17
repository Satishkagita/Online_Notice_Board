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
    function getNoticeText($notice_id, $connect)
    {
        $query = "SELECT description, sendto, dept,year FROM notice WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "i", $notice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $data = array(
                'description' => $row['description'],
                'sendto' => $row['sendto'],
                'dept' => $row['dept'],
                'year' => $row['year']
            );



            return $data;
        } else {
            return "Notice not found";
        }
    }



    $mail->addReplyTo('eboardnotifications@gmail.com');
    $notice_text = getNoticeText($notice_id, $connect); // user-defined function
    $mail->isHTML(true);
    $mail->Subject = 'Online notice';
    $mail->Body = "<p>{$notice_text['description']}</p>";

    $mail->AltBody = 'This is for non-HTML content';

    if ($notice_text !== "Notice not found") {
        $mail->isHTML(true);
        $mail->Subject = 'Online notice board';
        $mail->Body = "<p>{$notice_text['description']}</p>";
        $sendto = trim($notice_text['sendto']);
        $year = $notice_text['year'];
        $dept = $notice_text['dept'];
        // Depending on the 'sendto' value, add recipients to the email
        if ($sendto == "All") {
            // Select email addresses from the faculty table
            if($dept=="All"){
                $facultyQuery = "SELECT email FROM faculty";
                echo "all";
            }
            else{
                $facultyQuery = "SELECT email FROM faculty where dept='$dept'";
            }
            $facultyResult = mysqli_query($connect, $facultyQuery);

            if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                while ($row = mysqli_fetch_assoc($facultyResult)) {
                    $mail->addBCC($row['email']);
                }
            }

            // Select email addresses from the student table
            if($dept=="All"){
            $studentQuery = "SELECT email FROM student";
            }
            else{
                $studentQuery = "SELECT email FROM student where dept='$dept'" ;
            }
            $studentResult = mysqli_query($connect, $studentQuery);

            if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                while ($row = mysqli_fetch_assoc($studentResult)) {
                    $mail->addBCC($row['email']);
                }
            }
        } elseif ($sendto === "Faculty") {
            // Select email addresses from the faculty table
            if($dept=="All"){
                $facultyQuery = "SELECT email FROM faculty";
             
            }
            else{
                $facultyQuery = "SELECT email FROM faculty where dept='$dept'";
            }
            $facultyResult = mysqli_query($connect, $facultyQuery);

            if ($facultyResult && mysqli_num_rows($facultyResult) > 0) {
                while ($row = mysqli_fetch_assoc($facultyResult)) {
                    $mail->addBCC($row['email']);
                }
            }
        } elseif ($sendto === "HOD") {
            // Select email addresses from the faculty table
            if($dept=="All"){
            $hodQuery = "SELECT email FROM hod";
            }
            else{
                $hodQuery = "SELECT email FROM hod  where dept='$dept'";
            }
            $hodResult = mysqli_query($connect, $hodQuery);

            if ($hodResult && mysqli_num_rows($hodResult) > 0) {
                while ($row = mysqli_fetch_assoc($hodResult)) {
                    $mail->addBCC($row['email']);
                }
            }
        } elseif ($sendto === "Student" && $year === "All") {
            // Send to all students
            if($dept=="All"){
                $studentQuery = "SELECT email FROM student";
                }
                else{
                    $studentQuery = "SELECT email FROM student where dept='$dept'" ;
                }
            $studentResult = mysqli_query($connect, $studentQuery);

            if ($studentResult && mysqli_num_rows($studentResult) > 0) {
                while ($row = mysqli_fetch_assoc($studentResult)) {
                    $mail->addBCC($row['email']);
                }
            }
        } elseif ($sendto === "Student") {
            $year = $notice_text['year'];

            if($dept=="All"){
            $query = "SELECT email FROM student WHERE year = ?";
            }
            else{
                $query = "SELECT email FROM student WHERE dept='$dept' and year = ?";
            }
            $stmt = mysqli_prepare($connect, $query);
            mysqli_stmt_bind_param($stmt, "i", $year);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $mail->addBCC($row['email']);
                }
            } else {
                echo "No students found for the specified year.";
            }
        } else {
            echo "Value of sendto: $sendto<br>";

            echo "Invalid 'sendto' value.";
        }

        $mail->AltBody = 'This is for non-HTML content';

        // Rest of your code for sending the email
    } else {
        die("Notice not found");
    }
    if ($mail->send()) {
        header("location:notice.php");
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