<?php
include '../config/db.php';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>🔗 Donor-Recipient Match Results</h2>

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
                    <td><?= $i++ ?></td>
                    <td><?= $row['donor_name'] ?> (Age: <?= $row['donor_age'] ?>)</td>
                    <td><?= $row['recipient_name'] ?> (Age: <?= $row['recipient_age'] ?>)</td>
                    <td><?= $row['donor_blood'] ?></td>
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
        <div class="alert alert-error">
            No matches found yet. Register donors and recipients to begin matching.
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include '../includes/footer.php'; ?>