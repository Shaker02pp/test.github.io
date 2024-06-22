<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data with default values if keys are missing
    $roomNumber = isset($_POST['room-number']) ? $_POST['room-number'] : '';
    $date = date('Y-m-d');
    $howFind = isset($_POST['how-find']) ? $_POST['how-find'] : 'N/A'; // Default to 'N/A' if not set
    $receptionStaff = isset($_POST['reception-staff']) ? $_POST['reception-staff'] : 'N/A'; // Default to 'N/A' if not set
    $cleanliness = isset($_POST['cleanliness']) ? $_POST['cleanliness'] : 'N/A'; // Default to 'N/A' if not set
    $breakfast = isset($_POST['breakfast']) ? $_POST['breakfast'] : 'N/A'; // Default to 'N/A' if not set
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : 'N/A'; // Default to 'N/A' if not set
    $visitAgain = isset($_POST['visit-again']) ? $_POST['visit-again'] : 'N/A'; // Default to 'N/A' if not set
    $guestNote = isset($_POST['guest-note']) ? htmlspecialchars($_POST['guest-note']) : '';

    function generateStars($rating) {
        return str_repeat('⭐', $rating);
    }  
    $message = "Room Number:    $roomNumber\n\n"
             . "Date:           $date\n\n"
             . "How did you find out about Sipan Hotel?:\n-- $howFind --\n\n"
             . "Reception Staff:    $receptionStaff " . generateStars($receptionStaff) . "\n"
             . "Cleanliness:            $cleanliness " . generateStars($cleanliness) . "\n"
             . "Breakfast:              $breakfast " . generateStars($breakfast) . "\n"
             . "Facilities:                 $facilities " . generateStars($facilities) . "\n\n"
             . "Will visit again:\t\t $visitAgain"
             . "\n---Visitor Notes---\n $guestNote";

    // Send message to Telegram (unchanged from your original code)
    $botToken = "7021492334:AAHkFKSAZnilFga6524Fn9Dghe7voKYqu-M";
    $chatId = "1266887534";
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type:application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
        ]
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    // Store data in SQLite database
    $databasePath = '../database/hotel-rating.db'; // Path to your SQLite database file

    try {
        // Create or open the SQLite database
        $db = new SQLite3($databasePath);

        // Prepare SQL statement for insertion
        $stmt = $db->prepare("INSERT INTO hotel_ratings (room_number, date, how_find, reception_staff, cleanliness, breakfast, facilities, visit_again, guest_note) VALUES (:roomNumber, :date, :howFind, :receptionStaff, :cleanliness, :breakfast, :facilities, :visitAgain, :guestNote)");
        $stmt->bindParam(':roomNumber', $roomNumber, SQLITE3_TEXT);
        $stmt->bindParam(':date', $date, SQLITE3_TEXT);
        $stmt->bindParam(':howFind', $howFind, SQLITE3_TEXT);
        $stmt->bindParam(':receptionStaff', $receptionStaff, SQLITE3_TEXT);
        $stmt->bindParam(':cleanliness', $cleanliness, SQLITE3_TEXT);
        $stmt->bindParam(':breakfast', $breakfast, SQLITE3_TEXT);
        $stmt->bindParam(':facilities', $facilities, SQLITE3_TEXT);
        $stmt->bindParam(':visitAgain', $visitAgain, SQLITE3_TEXT);
        $stmt->bindParam(':guestNote', $guestNote, SQLITE3_TEXT);

        // Execute the statement
        $result = $stmt->execute();

        // Redirect to thank you page
        header('Location: ../thanks/thankyou.html');
        exit;

    } catch (Exception $e) {
        // Handle any exceptions
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        if (isset($db)) {
            $db->close();
        }
    }
}
?>
