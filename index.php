<?php include 'includes/header.php'; ?>

<div class="hero-section" style="background-image: url('/kidney_system/hero-bg.png');">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">🏥 Advanced Healthcare Technology</div>
        <h1>Smart Kidney Donor–Recipient<br>Matching System</h1>
        <p>A secure, web-based platform to register kidney donors and recipients,<br>
        run automated compatibility matching, and manage transplant waiting lists.</p>
        
        <div class="hero-btns">
            <a href="donor/register.php" class="btn btn-primary">🩸 Register as Donor</a>
            <a href="recipient/register.php" class="btn btn-white">🏥 Register as Recipient</a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container">
    <div class="section-title">
        <h2>Our Services</h2>
        <p>Comprehensive tools for kidney transplant coordination</p>
    </div>

    <div class="home-cards">
        <a href="donor/register.php" class="home-card">
            <div class="card-icon-wrap">🩸</div>
            <h3>Donor Registration</h3>
            <p>Register as a kidney donor and help save a life through our secure system.</p>
            <span class="card-link">Get Started →</span>
        </a>

        <a href="recipient/register.php" class="home-card">
            <div class="card-icon-wrap">🏨</div>
            <h3>Recipient Registration</h3>
            <p>Register patients in need of a kidney transplant and join the priority queue.</p>
            <span class="card-link">Register Now →</span>
        </a>

        <a href="waiting_list/view.php" class="home-card">
            <div class="card-icon-wrap">📋</div>
            <h3>Waiting List</h3>
            <p>View the current queue of recipients awaiting compatible kidney matches.</p>
            <span class="card-link">View List →</span>
        </a>

        <a href="matching/match_engine.php" class="home-card">
            <div class="card-icon-wrap">🔗</div>
            <h3>Match Results</h3>
            <p>View all successful donor-recipient compatibility matches in real time.</p>
            <span class="card-link">View Matches →</span>
        </a>

        <a href="how_it_works.php" class="home-card">
            <div class="card-icon-wrap">⚕️</div>
            <h3>How It Works</h3>
            <p>Learn how our rule-based algorithm matches donors and recipients using blood group, age, and health criteria.</p>
            <span class="card-link">Learn More →</span>
        </a>

        <a href="about.php" class="home-card">
            <div class="card-icon-wrap">ℹ️</div>
            <h3>About This System</h3>
            <p>Learn about the Smart Kidney Matching System — built as a DS2105 Capstone Project at Sabaragamuwa University.</p>
            <span class="card-link">About →</span>
        </a>

        
    </div>
</div>

<?php include 'includes/footer.php'; ?>