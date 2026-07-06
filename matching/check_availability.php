<?php
include '../config/db.php';

header('Content-Type: application/json');

$blood_group = mysqli_real_escape_string($conn, $_GET['blood_group']);

$sql = "SELECT COUNT(*) as count FROM donors
        WHERE blood_group = '$blood_group'
        AND health_status = 'Healthy'
        AND donor_id NOT IN (SELECT donor_id FROM matches)";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode(['count' => (int)$row['count']]);
?>