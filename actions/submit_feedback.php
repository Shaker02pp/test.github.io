<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $roomNumber = $_POST['room-number'];
    $howFind = $_POST['how-find'];
    // Add other fields as per your form

    // Print received data for debugging
    echo "<h2>Received Data:</h2>";
    echo "<p>Room Number: $roomNumber</p>";
    echo "<p>How did you find us?: $howFind</p>";
    // Print other fields as needed for debugging

    // Example: Insert data into SQLite database
    $databasePath = '../database/hotel-rating.db'; // Adjust path as necessary

    try {
        // Create or open the SQLite database
        $db = new SQLite3($databasePath);

        // Prepare SQL statement
        $stmt = $db->prepare("INSERT INTO hotel_ratings (room_number, how_find) VALUES (:roomNumber, :howFind)");
        $stmt->bindValue(':roomNumber', $roomNumber, SQLITE3_TEXT);
        $stmt->bindValue(':howFind', $howFind, SQLITE3_TEXT);

        // Execute the statement
        $result = $stmt->execute();

        // Check if insertion was successful
        if ($result) {
            echo "<p>Data inserted successfully into SQLite database!</p>";
        } else {
            echo "<p>Error inserting data into SQLite database.</p>";
        }

        // Close database connection
        $db->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
