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
    <div class="card" style="max-width: 450px; margin: 60px auto;">
        <div style="text-align: center; margin-bottom: 24px;">
            <span style="font-size: 48px;">🔐</span>
            <h2 style="margin-top: 12px; margin-bottom: 8px; border-bottom: none; padding-bottom: 0; justify-content: center;">Admin Portal Login</h2>
            <p style="color: var(--dark-muted); font-size: 14px;">Access the donor matching system control center</p>
        </div>

        <?php if ($error): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
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

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                Secure Login
            </button>

        </form>

        <div style="margin-top: 24px; padding: 12px 16px; background-color: var(--light-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); font-size: 13px; color: var(--dark-muted); text-align: center;">
            🔑 Default Credentials: <strong>admin</strong> / <strong>admin123</strong>
        </div>

    </div>
</div>

<?php include '../includes/header.php'; // Wait, let's include includes/footer.php here! Wait, the original had footer.php on line 70. Ah, let's fix it! ?>
<?php include '../includes/footer.php'; ?>