<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roomNumber = $_POST['room-number'];
    $date = $_POST['date'];
    $howFind = $_POST['how-find'];
    $checkInOut = $_POST['check-in-out'];
    $cleanliness = $_POST['cleanliness'];
    $breakfast = $_POST['breakfast'];
    $facilities = $_POST['facilities'];
    $visitAgain = $_POST['visit-again'];

    $message = "Room Number: $roomNumber\n"
             . "Date: $date\n"
             . "How did you find out about Sipan Hotel?: $howFind\n"
             . "Check In and Out experience: $checkInOut\n"
             . "Cleanliness: $cleanliness\n"
             . "Breakfast: $breakfast\n"
             . "Facilities: $facilities\n"
             . "Will visit again: $visitAgain";

    $botToken = "7021492334:AAHkFKSAZnilFga6524Fn9Dghe7voKYqu-M";
    $chatId = "1266887534"; // Replace with your chat ID or use @username for direct messages

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

    header('Location: thanks.html');
    exit;
}
?>