<?php
include '../config/db.php';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>🔗 Donor-Recipient Match Results</h2>
        <p style="color: var(--dark-muted); margin-bottom: 24px; font-size: 14.5px;">
            The list below displays the cross-matching compatibility calculations. Matches are automatically paired when blood types are compatible, and ages align within 15 years.
        </p>

        <?php
        // Fetch all matches with donor and recipient details
        $sql = "SELECT 
                    m.match_id,
                    m.match_date,
                    m.status,
                    d.full_name   AS donor_name,
                    d.blood_group AS donor_blood,
                    d.age         AS donor_age,
                    r.full_name   AS recipient_name,
                    r.blood_group AS recipient_blood,
                    r.age         AS recipient_age,
                    r.urgency_level
                FROM matches m
                JOIN donors     d ON m.donor_id     = d.donor_id
                JOIN recipients r ON m.recipient_id = r.recipient_id
                ORDER BY m.match_date DESC";

        $result = mysqli_query($conn, $sql);
        ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donor Name</th>
                        <th>Recipient Name</th>
                        <th>Blood Group</th>
                        <th>Urgency</th>
                        <th>Match Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><strong><?= $i++ ?></strong></td>
                        <td><?= htmlspecialchars($row['donor_name']) ?> <span style="color: var(--dark-muted); font-size: 13px;">(Age: <?= htmlspecialchars($row['donor_age']) ?>)</span></td>
                        <td><?= htmlspecialchars($row['recipient_name']) ?> <span style="color: var(--dark-muted); font-size: 13px;">(Age: <?= htmlspecialchars($row['recipient_age']) ?>)</span></td>
                        <td><span style="font-weight: 600; color: var(--primary);"><?= htmlspecialchars($row['donor_blood']) ?></span></td>
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
        <div class="alert alert-error">
            ⚠️ No compatibility matches found yet. Please register donors and recipients to prompt the match engine.
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include '../includes/footer.php'; ?>