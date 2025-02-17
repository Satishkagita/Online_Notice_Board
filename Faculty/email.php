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
        $query = "SELECT description, section, year FROM notice WHERE id = ?";
        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "i", $notice_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $row = mysqli_fetch_assoc($result)) {
            $data = array(
                'description' => $row['description'],
                'section' => $row['section'],
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
        $mail->Subject = 'Online notice';
        $mail->Body = "<p>{$notice_text['description']}</p>";

        $section = trim($notice_text['section']);
        $year = $notice_text['year'];

        // Here, you can add logic to filter recipients based on year and section.
        // Example: Select recipients from the student table based on year and section

        $studentQuery = "SELECT email FROM student WHERE year = ? AND section = ?";
        $stmt = mysqli_prepare($connect, $studentQuery);
        mysqli_stmt_bind_param($stmt, "ss", $year, $section);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $mail->addBCC($row['email']);
            }
        } else {
            echo "No students found for the specified year and section.";
        }

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