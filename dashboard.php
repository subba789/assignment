<?php
include 'db.php';

$sql = "SELECT * FROM feedback_forms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Forms Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 30px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .card-body ul {
            list-style-type: none;
            padding-left: 0;
        }
        .card-body ul li {
            background-color: #e9ecef;
            padding: 10px;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Feedback Forms Dashboard</h1>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Created at:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
                            <p><strong>Viewed Count:</strong> <?php echo htmlspecialchars($row['viewed_count']); ?></p>
                            <p><strong>Submission Count:</strong> <?php echo htmlspecialchars($row['submission_count']); ?></p>

                            <?php
                            $form_id = $row['id'];
                            $sql_fields = "SELECT * FROM form_fields WHERE form_id = '$form_id' ORDER BY `order` ASC";
                            $fields_result = $conn->query($sql_fields);
                            ?>

                            <h5>Fields:</h5>
                            <ul>
                                <?php while($field_row = $fields_result->fetch_assoc()): ?>
                                    <li><?php echo htmlspecialchars($field_row['label']); ?> (<?php echo htmlspecialchars($field_row['field_type']); ?>)</li>
                                <?php endwhile; ?>
                            </ul>

                            <a href="edit_form.php?id=<?php echo $form_id; ?>" class="btn-edit">Edit Form</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
