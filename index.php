<?php include 'includes/header.php'; ?>

<div class="container">

    <!-- Hero Section -->
    <div class="hero">
        <h1>🏥 Smart Kidney Donor-Recipient Matching System</h1>
        <p>
            A web-based system to register kidney donors and recipients,<br>
            automatically match compatible pairs, and manage the transplant waiting list.
        </p>
        <a href="donor/register.php" class="btn btn-primary">Register as Donor</a>
        &nbsp;&nbsp;
        <a href="recipient/register.php" class="btn btn-success">Register as Recipient</a>
    </div>

    <!-- Home Cards -->
    <div class="home-cards">

        <a href="donor/register.php" class="home-card">
            <div class="icon">🩸</div>
            <h3>Donor Registration</h3>
            <p>Register as a kidney donor and help save a life.</p>
        </a>

        <a href="recipient/register.php" class="home-card">
            <div class="icon">🏨</div>
            <h3>Recipient Registration</h3>
            <p>Register patients who are in need of a kidney transplant.</p>
        </a>

        <a href="waiting_list/view.php" class="home-card">
            <div class="icon">📋</div>
            <h3>Waiting List</h3>
            <p>View the current list of recipients awaiting a donor match.</p>
        </a>

        <a href="matching/match_engine.php" class="home-card">
            <div class="icon">🔗</div>
            <h3>Matching Results</h3>
            <p>View all successful donor-recipient compatibility matches.</p>
        </a>

        <a href="admin/login.php" class="home-card">
            <div class="icon">🔐</div>
            <h3>Admin Dashboard</h3>
            <p>Login as administrator to manage and monitor the system.</p>
        </a>

        <div class="home-card">
            <div class="icon">📊</div>
            <h3>About the System</h3>
            <p>Rule-based matching using blood group, age, and health status.</p>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>