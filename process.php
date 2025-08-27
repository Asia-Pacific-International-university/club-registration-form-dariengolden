<?php
// Club Registration Form Processing

// Start session to maintain data across requests
session_start();

// Initialize registrations array in session if it doesn't exist
if (!isset($_SESSION['registrations'])) {
    $_SESSION['registrations'] = [];
}

// Custom PHP functions for enhanced functionality
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

function formatPhoneNumber($phone) {
    if (empty($phone)) return 'N/A';

    // Remove all non-digit characters
    $digits = preg_replace('/\D/', '', $phone);

    // Format as XXX-XXX-XXXX if 10 digits
    if (strlen($digits) === 10) {
        return substr($digits, 0, 3) . '-' . substr($digits, 3, 3) . '-' . substr($digits, 6);
    }

    return $phone; // Return original if not 10 digits
}

function getClubStats($registrations) {
    $stats = [];
    foreach ($registrations as $reg) {
        $club = $reg['club'];
        if (!isset($stats[$club])) {
            $stats[$club] = 0;
        }
        $stats[$club]++;
    }
    return $stats;
}

function searchRegistrations($registrations, $searchTerm) {
    if (empty($searchTerm)) {
        return $registrations;
    }

    return array_filter($registrations, function($reg) use ($searchTerm) {
        return stripos($reg['name'], $searchTerm) !== false ||
               stripos($reg['email'], $searchTerm) !== false ||
               stripos($reg['club'], $searchTerm) !== false ||
               (!empty($reg['phone']) && stripos($reg['phone'], $searchTerm) !== false);
    });
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
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $club = $_POST['club'];
    $interests = $_POST['interests'] ?? [];
    $comments = sanitizeInput($_POST['comments'] ?? '');

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

    // Validate phone number format (optional but if provided, should be valid)
    if (!empty($phone) && !preg_match('/^[\d\s\-\+\(\)]+$/', $phone)) {
        $errors[] = "Please enter a valid phone number";
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
    } else {
        // No errors - store registration and display success page

        // Store registration data in session array
        $registration = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'club' => $club,
            'interests' => $interests,
            'comments' => $comments,
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
        if (!empty($phone)) {
            echo "                <p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>";
        }
        echo "                <p><strong>Selected Club:</strong> " . htmlspecialchars($club) . "</p>";
        if (!empty($interests)) {
            echo "                <p><strong>Interests:</strong> " . htmlspecialchars(implode(', ', $interests)) . "</p>";
        }
        if (!empty($comments)) {
            echo "                <p><strong>Comments:</strong> " . htmlspecialchars($comments) . "</p>";
        }
        echo "                <p><strong>Registered:</strong> " . $registration['timestamp'] . "</p>";
        echo "            </div>";
        echo "        </div>";

        // Handle search functionality
        $searchTerm = sanitizeInput($_GET['search'] ?? '');
        $filteredRegistrations = searchRegistrations($_SESSION['registrations'], $searchTerm);

        // Display all registrations using foreach loop
        echo "        <div class='all-registrations'>";
        echo "            <h2>All Club Registrations</h2>";

        // Add search form
        echo "            <div class='search-section'>";
        echo "                <h3>Search Registrations</h3>";
        echo "                <form method='get' class='search-form'>";
        echo "                    <input type='text' name='search' value='" . htmlspecialchars($searchTerm) . "' placeholder='Search by name, email, or club...' class='search-input'>";
        echo "                    <button type='submit' class='search-button'>Search</button>";
        if (!empty($searchTerm)) {
            echo "                    <a href='process.php' class='clear-button'>Clear Search</a>";
        }
        echo "                </form>";
        echo "            </div>";

        echo "            <p><strong>Total Registrations:</strong> " . count($_SESSION['registrations']);
        if (!empty($searchTerm)) {
            echo " | <strong>Filtered Results:</strong> " . count($filteredRegistrations);
        }
        echo "</p>";

        // Display club statistics
        $clubStats = getClubStats($_SESSION['registrations']);
        if (!empty($clubStats)) {
            echo "            <div class='club-stats'>";
            echo "                <h3>Club Registration Statistics</h3>";
            echo "                <div class='stats-grid'>";
            foreach ($clubStats as $clubName => $count) {
                $percentage = round(($count / count($_SESSION['registrations'])) * 100, 1);
                echo "                    <div class='stat-item'>";
                echo "                        <span class='club-name'>" . htmlspecialchars($clubName) . "</span>";
                echo "                        <span class='club-count'>" . $count . " (" . $percentage . "%)</span>";
                echo "                    </div>";
            }
            echo "                </div>";
            echo "            </div>";
        }

        if (!empty($filteredRegistrations)) {
            echo "            <div class='registrations-table'>";
            echo "                <table>";
            echo "                    <thead>";
            echo "                        <tr>";
            echo "                            <th>Name</th>";
            echo "                            <th>Email</th>";
            echo "                            <th>Phone</th>";
            echo "                            <th>Club</th>";
            echo "                            <th>Interests</th>";
            echo "                            <th>Registered</th>";
            echo "                        </tr>";
            echo "                    </thead>";
            echo "                    <tbody>";

            // Use foreach loop to process array data
            foreach ($filteredRegistrations as $reg) {
                echo "                        <tr>";
                echo "                            <td>" . htmlspecialchars($reg['name']) . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['email']) . "</td>";
                echo "                            <td>" . formatPhoneNumber($reg['phone']) . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['club']) . "</td>";
                echo "                            <td>" . htmlspecialchars(!empty($reg['interests']) ? implode(', ', $reg['interests']) : 'None') . "</td>";
                echo "                            <td>" . htmlspecialchars($reg['timestamp']) . "</td>";
                echo "                        </tr>";
            }

            echo "                    </tbody>";
            echo "                </table>";
            echo "            </div>";
        } elseif (!empty($searchTerm)) {
            echo "            <p>No registrations found matching '" . htmlspecialchars($searchTerm) . "'.</p>";
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
}
?>
