<?php
// change-password.php
session_start();
include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));

    if ($new_password === $confirm_password) {
        $query = mysqli_query($conn, "UPDATE users SET password='{$new_password}' WHERE email='{$email}'");

        if ($query) {
            header("Location: index.php");
        } else {
            $msg = "<div class='alert alert-danger'>Failed to update password.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form - Brave Coder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
         body {
            font-family: 'Poppins', sans-serif;
            background-color: rgba(99, 194, 110, 0.1);
        }
         .form-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        } 
        .logo-section {
            background-color: #00c16e;
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
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card form-container">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center logo-section">
                            <img src="images/image3.svg" alt="" class="img-fluid p-4">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h2 class="card-title text-center mb-4">Change Password</h2>
                                <p class="text-center text-muted mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                                <?php echo $msg; ?>
                                <form action="" method="post">
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                                    </div>
                                    <div class="d-grid">
                                        <button name="submit" class="btn btn-primary" type="submit">Change Password</button>
                                    </div>
                                </form>
                                <div class="text-center mt-4">
                                    <p>Back to! <a href="index.php">Login</a>.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>
</body>
</html>