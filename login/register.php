<?php
ob_start();
session_start();

include 'config.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, md5($_POST['confirm-password']));
    $query = "SELECT * FROM users WHERE email='{$email}' AND password='{$password}'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $msg = "<div class='alert alert-danger'>Email and password combination already exists.</div>";
    } else {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'")) > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address already exists.</div>";
        } else {
            if ($password === $confirm_password) {
                $sql = "INSERT INTO users (name, email, password) VALUES ('{$name}', '{$email}', '{$password}')";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    $_SESSION['SESSION_EMAIL'] = $email;
                    header("Location: ../Dashboard/index.html");
                    die();
                } else {
                    $msg = "<div class='alert alert-danger'>Registration failed. Please try again.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
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
    <title>Register Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
    <!-- <link rel="stylesheet" href="/style/style.css"> -->
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card form-container">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block bg-primary text-white p-5 d-flex align-items-center justify-content-center">
                            <img src="" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div class="card-body p-5">
                                <h2 class="card-title text-center mb-4">Register Now</h2>
                                <p class="text-center text-muted mb-4">Create your account to get started</p>
                                <?php echo $msg; ?>
                                <form action="" method="post">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" value="<?php if (isset($_POST['submit'])) { echo $name; } ?>" required>
                                        <label for="name">Enter Your Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" value="<?php if (isset($_POST['submit'])) { echo $email; } ?>" required>
                                        <label for="email">Enter Your Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="password" name="password" minlength="8" placeholder="Enter Your Password" required>
                                        <label for="password">Enter Your Password</label>
                                        <small id="passwordError" style="color: red; display: none;">Password harus berisikan minimal 8 karakter</small>
                                        <script>
                                            document.getElementById('password').addEventListener('input', function () {
                                                const passwordError = document.getElementById('passwordError');
                                                if (this.value.length < 8) {
                                                    passwordError.style.display = 'inline';
                                                } else {
                                                    passwordError.style.display = 'none';
                                                }
                                            });
                                        </script>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" required>
                                        <label for="confirm-password">Confirm Your Password</label>
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-lg" type="submit" name="submit">Register</button>
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
                                <div class="text-center mt-4">
                                    <p>Have an account! <a href="index.php">Login</a>.</p>
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
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>