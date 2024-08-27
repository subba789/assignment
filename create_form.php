<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_name = $_POST['form_name'];
    $logic = $_POST['logic'];

    // Insert the form
    $sql = "INSERT INTO feedback_forms (name, created_at, logic) VALUES ('$form_name', NOW(), '$logic')";
    $conn->query($sql);
    $form_id = $conn->insert_id;

    // Insert fields
    $fields = $_POST['fields']; // Array of fields with properties
    foreach ($fields as $order => $field) {
        $field_type = $field['type'];
        $label = $field['label'];
        $required = $field['required'] ? 1 : 0;
        $error_message = $field['error_message'];
        $options = isset($field['options']) ? json_encode($field['options']) : '';

        $sql = "INSERT INTO form_fields (form_id, field_type, label, required, error_message, options, `order`)
                VALUES ('$form_id', '$field_type', '$label', '$required', '$error_message', '$options', '$order')";
        $conn->query($sql);
    }

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Feedback Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
        }
        .card {
            margin-top: 50px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .btn-add-field {
            margin-top: 15px;
        }
        .field-group {
            border: 1px solid #ced4da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .remove-field-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3>Create Feedback Form</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="form_name" class="form-label">Form Name</label>
                        <input type="text" name="form_name" id="form_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="logic" class="form-label">Logic</label>
                        <textarea name="logic" id="logic" class="form-control" rows="3" required></textarea>
                    </div>
                    <!-- Dynamically add fields here with JavaScript -->
                    <div id="fields-container">
                        <!-- Fields will be added here dynamically -->
                    </div>
                    <button type="button" class="btn btn-secondary btn-add-field">Add Field</button>
                    <button type="submit" class="btn btn-primary">Save Form</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // JavaScript for adding and removing fields dynamically
        $('.btn-add-field').on('click', function() {
            const fieldHTML = `
                <div class="field-group">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="field_type" class="form-label">Field Type</label>
                            <select name="fields[][type]" class="form-select">
                                <option value="star_rating">Star Rating</option>
                                <option value="smile_rating">Smile Rating</option>
                                <option value="text_area">Text Area</option>
                                <option value="radio_buttons">Radio Buttons</option>
                                <option value="categories">Categories</option>
                                <option value="numeric_rating">Numeric Rating</option>
                                <option value="single_line_input">Single Line Input</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="label" class="form-label">Label</label>
                            <input type="text" name="fields[][label]" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="required" class="form-label">Required</label>
                            <select name="fields[][required]" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="error_message" class="form-label">Error Message</label>
                            <input type="text" name="fields[][error_message]" class="form-control">
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-field-btn">Remove Field</button>
                </div>
            `;
            $('#fields-container').append(fieldHTML);
        });

        // Remove field group
        $(document).on('click', '.remove-field-btn', function() {
            $(this).closest('.field-group').remove();
        });
    </script>
</body>
</html>
