<?php
ob_start();
session_start();

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    
    $sql = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['SESSION_EMAIL'] = $email;
        header("Location: ../Dashboard/index.html");
        exit();
    } else {
        $msg = "<div class='alert alert-danger'>Email or password is incorrect.</div>";
    }
}
if (isset($_POST['guest_login'])) {
    $_SESSION['SESSION_EMAIL'] = 'guest@example.com';
    $_SESSION['IS_GUEST'] = true;
    header("Location: ../Dashboard/index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="/style/style.css"> -->
    <style>
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }
        .divider span {
            padding: 0 10px;
            color: #6c757d;
            font-size: 0.9rem;
        }
        .btn-guest {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
        }
        .btn-guest:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #495057;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card form-container">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-flex bg-primary text-white p-5 align-items-center justify-content-center">
                            <img src="" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-5 text-center">
                                <h2 class="card-title mb-4">Login Now</h2>
                                <p class="text-muted mb-4">Welcome back! Please login to your account.</p>
                                <?php echo $msg; ?>
                                <form action="" method="post" class="w-100">
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Enter Your Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                                    </div>
                                    <div class="mb-3 text-end w-100">
                                        <a href="forgot-password.php" class="text-muted">Forgot Password?</a>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" name="submit" class="btn btn-primary">Login</button>
                                    </div>
                                </form>
                                <div class="divider">
                                    <span>OR</span>
                                </div>
                                <form action="" method="post">
                                    <div class="d-grid">
                                        <button type="submit" name="guest_login" class="btn btn-guest">
                                            <i class="fas fa-user me-2"></i>Continue as Guest
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-4">
                                    <p>Create Account! <a href="register.php">Register</a>.</p>
                                </div>
                                <div class="text-center mt-4">
                                    <a href="#" class="text-muted me-3"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                                    <a href="#" class="text-muted"><i class="fab fa-pinterest-p"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>