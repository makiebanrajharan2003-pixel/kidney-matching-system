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

// Blood group chart data
$blood_data = [];
$blood_result = mysqli_query($conn, "SELECT blood_group, COUNT(*) as count FROM donors GROUP BY blood_group");
while ($row = mysqli_fetch_assoc($blood_result)) {
    $blood_data[$row['blood_group']] = $row['count'];
}

// Match status chart data
$match_status = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM matches GROUP BY status");
$match_labels = [];
$match_counts = [];
while ($row = mysqli_fetch_assoc($match_status)) {
    $match_labels[] = $row['status'];
    $match_counts[] = $row['count'];
}

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
    <div class="card" style="display: flex; justify-content: space-between; align-items: center; padding: 20px 28px; margin-bottom: 24px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 28px;">👋</span>
            <div>
                <h2 style="margin: 0; padding: 0; border: none; font-size: 20px; font-weight: 700;">Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?>!</h2>
                <p style="color: var(--dark-muted); font-size: 13px; margin: 0;">Matching System Administrator</p>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="manage.php" class="btn btn-primary">⚙️ System Control Panel</a>
            <a href="logout.php" class="btn btn-danger">Sign Out</a>
        </div>
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

    <!-- Charts Section -->
   <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:30px;">

    <!-- Pie Chart -->
        <div class="card">
          <h2>📊 System Overview</h2>
          <canvas id="overviewChart" height="200"></canvas>
        </div>

    <!-- Bar Chart -->
        <div class="card">
         <h2>🩸 Donors by Blood Group</h2>
         <canvas id="bloodChart" height="200"></canvas>
        </div>

    </div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── Pie Chart — System Overview ──
const overviewCtx = document.getElementById('overviewChart').getContext('2d');
new Chart(overviewCtx, {
    type: 'doughnut',
    data: {
        labels: ['Total Donors', 'Total Recipients', 'Matches Found', 'Waiting List'],
        datasets: [{
            data: [
                <?= $total_donors ?>,
                <?= $total_recipients ?>,
                <?= $total_matches ?>,
                <?= $total_waiting ?>
            ],
            backgroundColor: ['#0B6E5C','#C77B2E','#2E9E5E','#E05444'],
            borderWidth: 0,
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    font: { family: 'Poppins', size: 12 },
                    padding: 16
                }
            }
        },
        cutout: '65%'
    }
});

// ── Bar Chart — Blood Groups ──
const bloodCtx = document.getElementById('bloodChart').getContext('2d');
new Chart(bloodCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_keys($blood_data)) ?>,
        datasets: [{
            label: 'Number of Donors',
            data: <?= json_encode(array_values($blood_data)) ?>,
            backgroundColor: [
                '#0B6E5C','#C77B2E','#2E9E5E','#E05444',
                '#084D40','#A05A20','#1E7A46','#B83A2C'
            ],
            borderRadius: 8,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    font: { family: 'Poppins', size: 11 }
                },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                ticks: { font: { family: 'Poppins', size: 11 } },
                grid: { display: false }
            }
        }
    }
});
</script>

    <!-- Recent Matches -->
    <div class="card">
        <h2>🔗 Recent Match Operations</h2>
        <?php if (mysqli_num_rows($recent_matches) > 0): ?>
        <div class="table-responsive">
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
                        <td><strong><?= $i++ ?></strong></td>
                        <td><?= htmlspecialchars($row['donor_name']) ?></td>
                        <td><?= htmlspecialchars($row['recipient_name']) ?></td>
                        <td><span style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($row['blood_group']) ?></span></td>
                        <td>
                            <span class="badge badge-<?= strtolower($row['urgency_level']) ?>">
                                <?= htmlspecialchars($row['urgency_level']) ?>
                            </span>
                        </td>
                        <td><?= date('Y-m-d', strtotime($row['match_date'])) ?></td>
                        <td>
                            <span class="badge badge-<?= strtolower($row['status']) ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-error">No matching records found yet.</div>
        <?php endif; ?>
    </div>

    <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-bottom: 30px;">
        <!-- Recent Donors -->
        <div class="card" style="margin-bottom: 0;">
            <h2>🩸 Recent Registered Donors</h2>
            <?php if (mysqli_num_rows($recent_donors) > 0): ?>
            <div class="table-responsive">
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
                            <td><strong><?= $i++ ?></strong></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['age']) ?> yrs</td>
                            <td><span style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($row['blood_group']) ?></span></td>
                            <td>
                                <span class="badge <?= $row['health_status'] == 'Healthy' ? 'badge-matched' : 'badge-high' ?>">
                                    <?= htmlspecialchars($row['health_status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['contact_number']) ?></td>
                            <td><?= date('Y-m-d', strtotime($row['registered_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-error">No donors registered yet.</div>
            <?php endif; ?>
        </div>

        <!-- Recent Recipients -->
        <div class="card" style="margin-bottom: 0;">
            <h2>🏨 Recent Registered Recipients</h2>
            <?php if (mysqli_num_rows($recent_recipients) > 0): ?>
            <div class="table-responsive">
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
                            <td><strong><?= $i++ ?></strong></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['age']) ?> yrs</td>
                            <td><span style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($row['blood_group']) ?></span></td>
                            <td>
                                <span class="badge badge-<?= strtolower($row['urgency_level']) ?>">
                                    <?= htmlspecialchars($row['urgency_level']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?= strtolower($row['status']) ?>">
                                    <?= htmlspecialchars($row['status']) ?>
                                </span>
                            </td>
                            <td><?= date('Y-m-d', strtotime($row['registered_at'])) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-error">No recipients registered yet.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Manage Button -->
    <div style="text-align: center; margin-bottom: 40px;">
        <a href="manage.php" class="btn btn-primary" style="padding: 14px 40px; font-size: 16px;">⚙️ Admin Records Control Panel</a>
    </div>

</div>

<?php include '../includes/footer.php'; ?>