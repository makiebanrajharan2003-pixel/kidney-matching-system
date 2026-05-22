<?php
session_start();
include '../config/db.php';

// If already logged in, go to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']); // MD5 hash to match DB

    $sql    = "SELECT * FROM admin WHERE username = '$username' AND password_hash = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Save admin details in session
        $_SESSION['admin_id']   = $admin['admin_id'];
        $_SESSION['admin_name'] = $admin['full_name'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <div class="card" style="max-width: 400px; margin: 60px auto;">
        <h2>🔐 Admin Login</h2>

        <?php if ($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">
                Login
            </button>

        </form>

        <p style="margin-top:15px; font-size:13px; color:#777;">
            Default: username = <b>admin</b> | password = <b>admin123</b>
        </p>

    </div>
</div>

<?php include '../includes/footer.php'; ?>