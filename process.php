<?php
// Club Registration Form Processing

// Start session to maintain data across requests
session_start();

// Initialize registrations array in session if it doesn't exist
if (!isset($_SESSION['registrations'])) {
    $_SESSION['registrations'] = [];
}

// Check if user wants to clear all registrations
if (isset($_GET['action']) && $_GET['action'] === 'clear') {
    $_SESSION['registrations'] = [];
    header('Location: index.html');
    exit;
}

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
        // No errors - store registration and display success page

        // Store registration data in session array
        $registration = [
            'name' => $name,
            'email' => $email,
            'club' => $club,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Add to registrations array
        $_SESSION['registrations'][] = $registration;

        // Display success page with all registrations
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
        echo "            <h2>Your Registration Details</h2>";
        echo "            <div class='details'>";
        echo "                <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
        echo "                <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        echo "                <p><strong>Selected Club:</strong> " . htmlspecialchars($club) . "</p>";
        echo "                <p><strong>Registered:</strong> " . $registration['timestamp'] . "</p>";
        echo "            </div>";
        echo "        </div>";

        // Display all registrations using foreach loop
        echo "        <div class='all-registrations'>";
        echo "            <h2>All Club Registrations</h2>";
        echo "            <p><strong>Total Registrations:</strong> " . count($_SESSION['registrations']) . "</p>";

        if (!empty($_SESSION['registrations'])) {
            echo "            <div class='registrations-table'>";
            echo "                <table>";
            echo "                    <thead>";
            echo "                        <tr>";
            echo "                            <th>Name</th>";
            echo "                            <th>Email</th>";
            echo "                            <th>Club</th>";
            echo "                            <th>Registered</th>";
            echo "                        </tr>";
            echo "                    </thead>";
            echo "                    <tbody>";

            // Use foreach loop to process array data
            foreach ($_SESSION['registrations'] as $reg) {
                echo "                        <tr>";
                echo "                            <td>" . htmlspecialchars($reg['name']) . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['email']) . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['club']) . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['timestamp']) . "</td>";
                echo "                        </tr>";
            }

            echo "                    </tbody>";
            echo "                </table>";
            echo "            </div>";
        }

        echo "            <div class='actions'>";
        echo "                <a href='index.html' class='back-button'>Register Another Person</a>";
        echo "                <a href='?action=clear' class='clear-button'>Clear All Registrations</a>";
        echo "            </div>";
        echo "        </div>";
        echo "    </main>";

        echo "    <footer>";
        echo "        <p>&copy; 2024 Student Club Registration System</p>";
        echo "    </footer>";
        echo "</body>";
        echo "</html>";
    }
?>
