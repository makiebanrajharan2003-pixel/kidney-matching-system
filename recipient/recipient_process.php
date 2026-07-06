<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name      = mysqli_real_escape_string($conn, $_POST['full_name']);
    $age            = (int)$_POST['age'];
    $blood_group    = $_POST['blood_group'];
    $urgency_level  = $_POST['urgency_level'];
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    // Check duplicate email
    $check = mysqli_query($conn, "SELECT recipient_id FROM recipients WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        $error = urlencode("This email is already registered as a recipient!");
        header("Location: register.php?error=$error");
        exit();
    }

    // Insert recipient
    $sql = "INSERT INTO recipients
            (full_name, age, blood_group, urgency_level, email, contact_number, status)
            VALUES
            ('$full_name', $age, '$blood_group', '$urgency_level', '$email', '$contact_number', 'Waiting')";

    if (mysqli_query($conn, $sql)) {
        $recipient_id = mysqli_insert_id($conn);

        // Add to waiting list
        $count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM waiting_list");
        $count_row    = mysqli_fetch_assoc($count_result);
        $position     = $count_row['total'] + 1;

        mysqli_query($conn, "INSERT INTO waiting_list (recipient_id, urgency_level, position)
                             VALUES ($recipient_id, '$urgency_level', $position)");

        // Run matching algorithm
        $match_sql = "SELECT donor_id FROM donors
                      WHERE blood_group   = '$blood_group'
                      AND health_status   = 'Healthy'
                      AND ABS(age - $age) <= 15
                      AND donor_id NOT IN (SELECT donor_id FROM matches)
                      ORDER BY
                          CASE '$urgency_level'
                              WHEN 'High'   THEN 1
                              WHEN 'Medium' THEN 2
                              WHEN 'Low'    THEN 3
                          END
                      LIMIT 1";

        $match_result = mysqli_query($conn, $match_sql);

        if (mysqli_num_rows($match_result) > 0) {

            $donor    = mysqli_fetch_assoc($match_result);
            $donor_id = $donor['donor_id'];

            mysqli_query($conn, "INSERT INTO matches (donor_id, recipient_id, status)
                                 VALUES ($donor_id, $recipient_id, 'Pending')");

            mysqli_query($conn, "UPDATE recipients SET status = 'Matched'
                                 WHERE recipient_id = $recipient_id");

            mysqli_query($conn, "DELETE FROM waiting_list
                                 WHERE recipient_id = $recipient_id");

            header("Location: register.php?matched=1&name=" . urlencode($full_name) . "&blood=" . urlencode($blood_group));
            exit();

        } else {

            header("Location: register.php?waiting=1&name=" . urlencode($full_name) . "&blood=" . urlencode($blood_group) . "&urgency=" . urlencode($urgency_level));
            exit();
        }

    } else {
        $error = urlencode(mysqli_error($conn));
        header("Location: register.php?error=$error");
        exit();
    }
}
?>