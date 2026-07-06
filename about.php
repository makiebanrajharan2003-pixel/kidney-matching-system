<?php include 'includes/header.php'; ?>

<div class="container">
    <div class="card">
        <h2>ℹ️ About This System</h2>

        <p style="color:var(--muted); font-size:15px; margin-bottom:30px; line-height:1.8;">
            The <strong>Smart Kidney Donor–Recipient Matching and Transplant Management System</strong>
            is a web-based decision-support prototype developed as a Capstone Project (DS2105)
            at the Department of Data Science, Faculty of Computing,
            Sabaragamuwa University of Sri Lanka.
        </p>

        <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-bottom:36px;">

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:30px; margin-bottom:10px;">🎯</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Purpose</h3>
                <p style="color:var(--muted); font-size:13.5px;">To automate the donor-recipient compatibility matching process using predefined medical rules, reducing manual workload and improving transplant coordination efficiency.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:30px; margin-bottom:10px;">🛠️</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Technologies Used</h3>
                <p style="color:var(--muted); font-size:13.5px;">HTML5, CSS3, JavaScript, PHP, MySQL, XAMPP, GitHub — all open-source tools ensuring cost-effective and accessible development.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:30px; margin-bottom:10px;">🗄️</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Database Design</h3>
                <p style="color:var(--muted); font-size:13.5px;">A normalized MySQL relational database with 5 tables: donors, recipients, matches, waiting_list, and admin — following 3NF principles.</p>
            </div>

            <div style="background:var(--teal-light); border-radius:12px; padding:24px;">
                <div style="font-size:30px; margin-bottom:10px;">🔒</div>
                <h3 style="color:var(--teal-dark); margin-bottom:8px;">Security</h3>
                <p style="color:var(--muted); font-size:13.5px;">All data is stored securely with input validation to prevent SQL injection. The admin panel is protected by session-based authentication.</p>
            </div>

        </div>

        <!-- Developer Info -->
        <div style="background:linear-gradient(135deg,var(--teal-dark),var(--teal)); border-radius:12px; padding:28px; color:white; text-align:center;">
            <div style="font-size:36px; margin-bottom:12px;">👨‍💻</div>
            <h3 style="font-size:20px; margin-bottom:8px;">Developer</h3>
            <p style="font-size:15px; margin-bottom:4px;"><strong>Rajharan Makieban</strong></p>
            <p style="font-size:13px; opacity:0.85;">Registration No: 23CDS0890</p>
            <p style="font-size:13px; opacity:0.85;">BSc (Hons) in Data Science</p>
            <p style="font-size:13px; opacity:0.85;">Sabaragamuwa University of Sri Lanka</p>
            <p style="font-size:13px; opacity:0.85; margin-top:8px;">Capstone Project — DS2105 | 2025</p>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>