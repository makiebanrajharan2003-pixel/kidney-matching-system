<?php
session_start();
include '../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Handle delete donor
if (isset($_GET['delete_donor'])) {
    $id = (int)$_GET['delete_donor'];
    mysqli_query($conn, "DELETE FROM matches WHERE donor_id = $id");
    mysqli_query($conn, "DELETE FROM donors WHERE donor_id = $id");
    header("Location: manage.php?msg=donor_deleted");
    exit();
}

// Handle delete recipient
if (isset($_GET['delete_recipient'])) {
    $id = (int)$_GET['delete_recipient'];
    mysqli_query($conn, "DELETE FROM matches WHERE recipient_id = $id");
    mysqli_query($conn, "DELETE FROM waiting_list WHERE recipient_id = $id");
    mysqli_query($conn, "DELETE FROM recipients WHERE recipient_id = $id");
    header("Location: manage.php?msg=recipient_deleted");
    exit();
}

// Handle approve match
if (isset($_GET['approve_match'])) {
    $id = (int)$_GET['approve_match'];
    mysqli_query($conn, "UPDATE matches SET status = 'Approved',
                         approved_by = {$_SESSION['admin_id']}
                         WHERE match_id = $id");
    header("Location: manage.php?msg=match_approved");
    exit();
}

// Fetch all donors
$donors = mysqli_query($conn, "SELECT * FROM donors ORDER BY registered_at DESC");

// Fetch all recipients
$recipients = mysqli_query($conn, "SELECT * FROM recipients ORDER BY registered_at DESC");

// Fetch all matches
$matches = mysqli_query($conn, "SELECT
        m.match_id, m.status, m.match_date,
        d.full_name AS donor_name, d.blood_group,
        r.full_name AS recipient_name, r.urgency_level
    FROM matches m
    JOIN donors d     ON m.donor_id     = d.donor_id
    JOIN recipients r ON m.recipient_id = r.recipient_id
    ORDER BY m.match_date DESC");
?>

<?php include '../includes/header.php'; ?>

<div class="container">

    <!-- Header -->
    <div class="card" style="display:flex; justify-content:space-between; align-items:center; padding:15px 25px;">
        <h2 style="margin:0;">⚙️ Manage All Records</h2>
        <a href="dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
    </div>

    <!-- Messages -->
    <?php if (isset($_GET['msg'])): ?>
        <?php $msgs = [
            'donor_deleted'     => '✅ Donor deleted successfully.',
            'recipient_deleted' => '✅ Recipient deleted successfully.',
            'match_approved'    => '✅ Match approved successfully.',
        ]; ?>
        <div class="alert alert-success">
            <?= $msgs[$_GET['msg']] ?? 'Action completed.' ?>
        </div>
    <?php endif; ?>

    <!-- Manage Donors -->
    <div class="card">
        <h2>🩸 All Donors</h2>
        <?php if (mysqli_num_rows($donors) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Health Status</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($donors)): ?>
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
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['contact_number'] ?></td>
                    <td>
                        <a href="manage.php?delete_donor=<?= $row['donor_id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Delete this donor?')"
                           style="padding:5px 12px; font-size:13px;">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No donors registered yet.</div>
        <?php endif; ?>
    </div>

    <!-- Manage Recipients -->
    <div class="card">
        <h2>🏨 All Recipients</h2>
        <?php if (mysqli_num_rows($recipients) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Urgency</th>
                    <th>Status</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($recipients)): ?>
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
                    <td><?= $row['email'] ?></td>
                    <td>
                        <a href="manage.php?delete_recipient=<?= $row['recipient_id'] ?>"
                           class="btn btn-danger"
                           onclick="return confirm('Delete this recipient?')"
                           style="padding:5px 12px; font-size:13px;">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No recipients registered yet.</div>
        <?php endif; ?>
    </div>

    <!-- Manage Matches -->
    <div class="card">
        <h2>🔗 All Matches</h2>
        <?php if (mysqli_num_rows($matches) > 0): ?>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; while ($row = mysqli_fetch_assoc($matches)): ?>
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
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                        <a href="manage.php?approve_match=<?= $row['match_id'] ?>"
                           class="btn btn-success"
                           style="padding:5px 12px; font-size:13px;">
                            Approve
                        </a>
                        <?php else: ?>
                        <span style="color:#34a853; font-size:13px;">✅ Approved</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert alert-error">No matches found yet.</div>
        <?php endif; ?>
    </div>

</div>

<?php include '../includes/footer.php'; ?>