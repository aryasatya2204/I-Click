<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'config.php';  // File koneksi database

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $email = mysqli_real_escape_string($conn, $input['email']);
    
    // Cari email di database
    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $token = bin2hex(random_bytes(50));
        $expire = date("Y-m-d H:i:s", strtotime('+1 hour'));  // Token berlaku selama 1 jam
        $update_query = "UPDATE users SET reset_token='$token', reset_token_expire='$expire' WHERE email='$email'";
        if (mysqli_query($conn, $update_query)) {
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'YOUR_EMAIL_HERE';                     //SMTP username
                $mail->Password   = 'YOUR_PASSWORD_HERE';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   
                $mail->Port = 465;

                $mail->setFrom('YOUR_EMAIL_HERE');
                $mail->addAddress($email);


                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/I-Click/assets/login/change-password.php?reset='.$code.'">http://localhost/I-Click/assets/login/change-password.php?reset='.$code.'</a></b>';

                $mail->send();
                echo json_encode(['status' => 'success', 'message' => 'Password reset email sent!']);
            } catch (Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Email could not be sent.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to store reset token.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>



<form method="POST">
    <input type="password" name="new-password" placeholder="New Password" required>
    <input type="password" name="confirm-password" placeholder="Confirm Password" required>
    <button type="submit" name="submit">Change Password</button>
</form>
<?php echo $msg; ?>
