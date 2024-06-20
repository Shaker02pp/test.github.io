document.getElementById('feedbackForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting normally

    // Collect form data
    var formData = new FormData(this);
    var data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    // Construct the message
    var message = `Room №: ${data['room-number']}
Date: ${data['date']}
How did you find out about Sipan Hotel?: ${data['how-find']}
Rate Check In and Out: ${data['check-in-out']}
Rate Cleanliness: ${data['cleanliness']}
Rate Breakfast: ${data['breakfast']}
Rate Facilities: ${data['facilities']}
Visit Again: ${data['visit-again']}`;

    // Send the message to the Telegram bot
    var botToken = '7021492334:AAHkFKSAZnilFga6524Fn9Dghe7voKYqu-M';
    var chatId = '1266887534'; // Replace with your Telegram chat ID
    var url = `https://api.telegram.org/bot${botToken}/sendMessage`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            chat_id: chatId,
            text: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            window.location.href = 'thanks.html'; // Redirect to the thank you page
        } else {
            alert('There was an error sending your feedback. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error sending your feedback. Please try again.');
    });
});

    
