<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Get statistics
$total_donors     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM donors"))['total'];
$total_recipients = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM recipients"))['total'];
$total_matches    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM matches"))['total'];
$total_waiting    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM waiting_list"))['total'];

// Get recent matches
$recent_matches = mysqli_query($conn, "SELECT 
        m.match_id,
        m.match_date,
        m.status,
        d.full_name   AS donor_name,
        d.blood_group AS blood_group,
        r.full_name   AS recipient_name,
        r.urgency_level
    FROM matches m
    JOIN donors     d ON m.donor_id     = d.donor_id
    JOIN recipients r ON m.recipient_id = r.recipient_id
    ORDER BY m.match_date DESC
    LIMIT 5");

// Get recent donors
$recent_donors = mysqli_query($conn, "SELECT * FROM donors ORDER BY registered_at DESC LIMIT 5");

// Get recent recipients
$recent_recipients = mysqli_query($conn, "SELECT * FROM recipients ORDER BY registered_at DESC LIMIT 5");
?>

<?php include '../includes/header.php'; ?>

<div class="container">

    <!-- Welcome Bar -->
    <div class="card" style="display:flex; justify-content:space-between; align-items:center; padding:15px 25px;">
        <h2 style="margin:0;">👋 Welcome, <?= $_SESSION['admin_name'] ?>!</h2>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="number"><?= $total_donors ?></div>
            <div class="label">Total Donors</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= $total_recipients ?></div>
            <div class="label">Total Recipients</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= $total_matches ?></div>
            <div class="label">Total Matches</div>
        </div>
        <div class="stat-card">
            <div class="number"><?= $total_waiting ?></div>
            <div class="label">Waiting List</div>
        </div>
    </div>

    <!-- Recent Matches -->
    <div class="card">
        <h2>🔗 Recent Matches</h2>
        <?php if (mysqli_num_rows($recent_matches) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Donor</th>
                    <th>Recipient</th>
                    <th>Blood Group</th>
                    <th>Urgency</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($recent_matches)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['donor_name'] ?></td>
                    <td><?= $row['recipient_name'] ?></td>
                    <td><?= $row['blood_group'] ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['urgency_level']) ?>">
                            <?= $row['urgency_level'] ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['match_date'])) ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['status']) ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No matches found yet.</div>
        <?php endif; ?>
    </div>

    <!-- Recent Donors -->
    <div class="card">
        <h2>🩸 Recent Donors</h2>
        <?php if (mysqli_num_rows($recent_donors) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Health Status</th>
                    <th>Contact</th>
                    <th>Registered</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($recent_donors)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['blood_group'] ?></td>
                    <td>
                        <span class="badge <?= $row['health_status'] == 'Healthy' ? 'badge-matched' : 'badge-high' ?>">
                            <?= $row['health_status'] ?>
                        </span>
                    </td>
                    <td><?= $row['contact_number'] ?></td>
                    <td><?= date('Y-m-d', strtotime($row['registered_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No donors registered yet.</div>
        <?php endif; ?>
    </div>

    <!-- Recent Recipients -->
    <div class="card">
        <h2>🏨 Recent Recipients</h2>
        <?php if (mysqli_num_rows($recent_recipients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Urgency</th>
                    <th>Status</th>
                    <th>Registered</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($recent_recipients)): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['blood_group'] ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['urgency_level']) ?>">
                            <?= $row['urgency_level'] ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['status']) ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['registered_at'])) ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No recipients registered yet.</div>
        <?php endif; ?>
    </div>

    <!-- Manage Button -->
    <div style="text-align:center; margin-bottom:30px;">
        <a href="manage.php" class="btn btn-primary">⚙️ Manage All Records</a>
    </div>

</div>

<?php include '../includes/footer.php'; ?>