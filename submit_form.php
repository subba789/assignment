<?php
include 'db.php';

$form_id = $_POST['form_id'];
$submission_data = json_encode($_POST['form_data']);

// Insert submission
$sql = "INSERT INTO form_submissions (form_id, submission_data, submitted_at) VALUES ('$form_id', '$submission_data', NOW())";
$conn->query($sql);

// Update submission count
$sql = "UPDATE feedback_forms SET submission_count = submission_count + 1 WHERE id = '$form_id'";
$conn->query($sql);

header("Location: thank_you.php");
?>
