<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $full_name      = mysqli_real_escape_string($conn, $_POST['full_name']);
    $age            = (int)$_POST['age'];
    $blood_group    = $_POST['blood_group'];
    $health_status  = $_POST['health_status'];
    $email          = mysqli_real_escape_string($conn, $_POST['email']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);

    $sql = "INSERT INTO donors (full_name, age, blood_group, health_status, email, contact_number)
            VALUES ('$full_name', $age, '$blood_group', '$health_status', '$email', '$contact_number')";

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT donor_id FROM donors WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
    $error = urlencode("This email is already registered as a donor!");
    header("Location: register.php?error=$error");
    exit();
    }
    if (mysqli_query($conn, $sql)) {
        $donor_id = mysqli_insert_id($conn);

        // ── Run Matching Algorithm ──
        $match_sql = "SELECT recipient_id FROM recipients
              WHERE blood_group    = '$blood_group'
              AND   status         = 'Waiting'
              AND   ABS(age - $age) <= 15
              ORDER BY 
                  CASE urgency_level 
                      WHEN 'High'   THEN 1 
                      WHEN 'Medium' THEN 2 
                      WHEN 'Low'    THEN 3 
                  END
              LIMIT 1";

        $match_result = mysqli_query($conn, $match_sql);

        if (mysqli_num_rows($match_result) > 0) {
            $recipient = mysqli_fetch_assoc($match_result);
            $recipient_id = $recipient['recipient_id'];

            // Save match
            $insert_match = "INSERT INTO matches (donor_id, recipient_id, status)
                             VALUES ($donor_id, $recipient_id, 'Pending')";
            mysqli_query($conn, $insert_match);

            // Update recipient status
            $update_recipient = "UPDATE recipients SET status = 'Matched'
                                 WHERE recipient_id = $recipient_id";
            mysqli_query($conn, $update_recipient);

            // Remove from waiting list
            $remove_waiting = "DELETE FROM waiting_list
                               WHERE recipient_id = $recipient_id";
            mysqli_query($conn, $remove_waiting);
        }

        header("Location: register.php?success=1");
        exit();

    } else {
        $error = urlencode(mysqli_error($conn));
        header("Location: register.php?error=$error");
        exit();
    }
}
?>