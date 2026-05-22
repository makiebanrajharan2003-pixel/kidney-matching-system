<?php
include '../config/db.php';
include '../includes/header.php';
?>

<div class="container">
    <div class="card">
        <h2>📋 Kidney Transplant Waiting List</h2>

        <?php
        // Fetch waiting list ordered by urgency then date
        $sql = "SELECT 
                    w.list_id,
                    w.position,
                    w.date_added,
                    r.full_name,
                    r.age,
                    r.blood_group,
                    r.urgency_level,
                    r.status
                FROM waiting_list w
                JOIN recipients r ON w.recipient_id = r.recipient_id
                ORDER BY
                    CASE w.urgency_level
                        WHEN 'High'   THEN 1
                        WHEN 'Medium' THEN 2
                        WHEN 'Low'    THEN 3
                    END,
                    w.date_added ASC";

        $result = mysqli_query($conn, $sql);
        ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Recipient Name</th>
                    <th>Age</th>
                    <th>Blood Group</th>
                    <th>Urgency Level</th>
                    <th>Date Added</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['position'] ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['blood_group'] ?></td>
                    <td>
                        <span class="badge badge-<?= strtolower($row['urgency_level']) ?>">
                            <?= $row['urgency_level'] ?>
                        </span>
                    </td>
                    <td><?= date('Y-m-d', strtotime($row['date_added'])) ?></td>
                    <td>
                        <span class="badge badge-waiting">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php else: ?>
        <div class="alert alert-success">
            ✅ No recipients currently on the waiting list.
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include '../includes/footer.php'; ?>