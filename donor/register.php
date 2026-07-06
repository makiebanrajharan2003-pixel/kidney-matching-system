<?php include '../includes/header.php'; ?>

<div class="container" style="max-width: 700px;">
    <div class="card">
        <h2>🩸 Donor Registration</h2>
        <p style="color: var(--dark-muted); margin-bottom: 20px; font-size: 14px;">
            Please enter the donor's medical and contact information. The system will automatically search for compatible matches on submission.
        </p>

        <?php
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">✅ Donor registered successfully! Matching process completed.</div>';
        }
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-error">❌ Error: ' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>

        <form action="donor_process.php" method="POST">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="Enter full name" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" placeholder="Age (18-65)" min="18" max="65" required>
                </div>

                <div class="form-group">
                    <label>Blood Group</label>
                    <select name="blood_group" required>
                        <option value="">-- Select Blood Group --</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Health Status</label>
                <select name="health_status" required>
                    <option value="">-- Select Health Status --</option>
                    <option value="Healthy">Healthy</option>
                    <option value="Not Healthy">Not Healthy</option>
                </select>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" placeholder="Enter contact number" required>
            </div>

            <button type="submit" class="btn btn-primary" style="margin-top: 10px; width: 100%;">
                🩸 Register as Donor
            </button>

        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>