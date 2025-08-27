<?php
// Club Registration Form Processing

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract form data from $_POST
    $name = $_POST['name'];
    $email = $_POST['email'];
    $club = $_POST['club'];

    // Display submitted information to user
    echo "<!DOCTYPE html>";
    echo "<html lang='en'>";
    echo "<head>";
    echo "    <meta charset='UTF-8'>";
    echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "    <title>Registration Successful</title>";
    echo "    <link rel='stylesheet' href='styles.css'>";
    echo "</head>";
    echo "<body>";
    echo "    <header>";
    echo "        <h1>Club Registration Successful!</h1>";
    echo "        <p>Thank you for registering for a club</p>";
    echo "    </header>";

    echo "    <main>";
    echo "        <div class='registration-summary'>";
    echo "            <h2>Registration Details</h2>";
    echo "            <div class='details'>";
    echo "                <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
    echo "                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
    echo "                <p><strong>Selected Club:</strong> " . htmlspecialchars($club) . "</p>";
    echo "            </div>";
    echo "            <div class='actions'>";
    echo "                <a href='index.html' class='back-button'>Register Another Person</a>";
    echo "            </div>";
    echo "        </div>";
    echo "    </main>";

    echo "    <footer>";
    echo "        <p>&copy; 2024 Student Club Registration System</p>";
    echo "    </footer>";
    echo "</body>";
    echo "</html>";
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
