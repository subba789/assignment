<?php
include 'db.php';

// Logic to display form based on logic set in the admin panel
$sql = "SELECT * FROM feedback_forms WHERE logic LIKE '%homepage%'"; // Example for specific page logic
$result = $conn->query($sql);
$form = $result->fetch_assoc();

if ($form) {
    $form_id = $form['id'];
    $sql_fields = "SELECT * FROM form_fields WHERE form_id = '$form_id' ORDER BY `order` ASC";
    $fields_result = $conn->query($sql_fields);
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Feedback Form</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            #feedback-modal {
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: 50px auto;
            }
            #feedback-modal form div {
                margin-bottom: 15px;
            }
            #feedback-modal label {
                display: block;
                font-weight: bold;
                margin-bottom: 5px;
            }
            #feedback-modal textarea, #feedback-modal input {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
                box-sizing: border-box; /* Ensure padding does not affect width */
            }
            .error {
                color: red;
                font-size: 12px;
                display: block; /* Ensure the error message is on a new line */
                margin-top: 5px;
            }
            .star-rating {
                display: inline-block;
                font-size: 1.5rem;
                color: gold;
                margin: 5px 0;
            }
            button[type="submit"] {
                background-color: #007bff;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            button[type="submit"]:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div id="feedback-modal" class="shadow-lg">
            <form action="submit_form.php" method="POST">
                <input type="hidden" name="form_id" value="<?php echo htmlspecialchars($form_id); ?>">
                <?php while($field_row = $fields_result->fetch_assoc()) { ?>
                    <div>
                        <label><?php echo htmlspecialchars($field_row['label']); ?></label>
                        <!-- Render field based on type -->
                        <?php if ($field_row['field_type'] == 'text_area') { ?>
                            <textarea name="field_<?php echo htmlspecialchars($field_row['id']); ?>" 
                                      <?php echo $field_row['required'] ? 'required' : ''; ?>></textarea>
                        <?php } else if ($field_row['field_type'] == 'star_rating') { ?>
                            <div class="star-rating">
                                <!-- Implement Star Rating UI -->
                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                    <span>&#9733;</span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <!-- Implement other fields here as needed -->
                        <span class="error"><?php echo htmlspecialchars($field_row['error_message']); ?></span>
                    </div>
                <?php } ?>
                <button type="submit">Submit Feedback</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
}
?>
