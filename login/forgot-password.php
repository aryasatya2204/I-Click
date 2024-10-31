<?php
session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location: welcome.php");
    die();
}

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        
        // Store the token in the database (optional)
        mysqli_query($conn, "UPDATE users SET reset_token='{$token}' WHERE email='{$email}'");

        // Send an email with the reset link
        $reset_link = "http://yourdomain.com/reset-password.php?token={$token}&email={$email}";
        mail($email, "Reset Your Password", "Click this link to reset your password: " . $reset_link);

        $msg = "<div class='alert alert-success'>A reset link has been sent to your email.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>$email - This email address was not found.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - Brave Coder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: rgba(99, 194, 110, 0.1);
            min-height: 100vh;
        }
        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 2px 9px 49px -17px rgba(0, 0, 0, 0.1);
        }
        .brand-side {
            background: #00c16e;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        .btn-primary {
            background-color: #00c16e;
            border-color: #00c16e;
        }
        .btn-primary:hover {
            background-color: #4ca356;
            border-color: #4ca356;
        }
        .social-icons i {
            font-size: 1.2rem;
            margin: 0 0.5rem;
        }
        .close-btn {
            position: absolute;
            right: -5px;
            top: -5px;
            background: #62c16e;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
</head>
<body class="d-flex align-items-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="position-relative">
                    <!-- <div class="close-btn">
                        <i class="fas fa-times"></i>
                    </div> -->
                    <div class="row form-container">
                        <div class="col-md-6 brand-side d-flex align-items-center justify-content-center p-5">
                            <img src="images/image3.svg" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6 p-5">
                            <h2 class="mb-3">Forgot Password</h2>
                            <p class="text-muted mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            
                            <?php echo $msg; ?>

                            <form method="post" action="">
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary w-100">Send Reset Link</button>
                            </form>

                            <div class="text-center mt-4">
                                <p>Back to! <a href="index.php" class="text-decoration-none">Login</a>.</p>
                                <div class="social-icons mt-3">
                                    <i class="fab fa-facebook text-primary"></i>
                                    <i class="fab fa-twitter text-info"></i>
                                    <i class="fab fa-pinterest text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <script>
        document.querySelector('.close-btn').addEventListener('click', function() {
            this.closest('.position-relative').style.display = 'none';
        });
    </script>
</body>
</html>