<?php
// Club Registration Form Processing

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize error array
    $errors = [];

    // Extract and validate form data from $_POST
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $club = $_POST['club'];

    // Validate required fields are not empty
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    }

    if (empty($club)) {
        $errors[] = "Please select a club";
    }

    // Validate email format using filter_var()
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address";
    }

    // Check if there are validation errors
    if (!empty($errors)) {
        // Display error page
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "    <meta charset='UTF-8'>";
        echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "    <title>Validation Error</title>";
        echo "    <link rel='stylesheet' href='styles.css'>";
        echo "</head>";
        echo "<body>";
        echo "    <header>";
        echo "        <h1>Registration Error</h1>";
        echo "        <p>Please fix the following errors:</p>";
        echo "    </header>";

        echo "    <main>";
        echo "        <div class='error-summary'>";
        echo "            <h2>Validation Errors</h2>";
        echo "            <ul class='error-list'>";
        foreach ($errors as $error) {
            echo "                <li>" . htmlspecialchars($error) . "</li>";
        }
        echo "            </ul>";
        echo "            <div class='actions'>";
        echo "                <a href='index.html' class='back-button'>Go Back to Form</a>";
        echo "            </div>";
        echo "        </div>";
        echo "    </main>";

    echo "    <footer>";
    echo "        <p>&copy; 2024 Student Club Registration System</p>";
    echo "    </footer>";
    echo "</body>";
    echo "</html>";
    }
} else {
    // If someone accesses this page directly without submitting the form
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "    <meta charset='UTF-8'>";
    echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "    <title>Access Denied</title>";
    echo "    <link rel='stylesheet' href='styles.css'>";
    echo "</head>";
    echo "<body>";
    echo "    <header>";
    echo "        <h1>Please Use the Form</h1>";
    echo "    </header>";
    echo "    <main>";
    echo "        <p>Please fill out the registration form first.</p>";
    echo "        <a href='index.html'>Go to Registration Form</a>";
    echo "    </main>";
    echo "</body>";
    echo "</html>";
}
?>
