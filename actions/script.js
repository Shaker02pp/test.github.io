function autoResize() {
    const textarea = document.getElementById('guest-note');
    textarea.style.height = 'auto'; // Reset height to auto to calculate the actual height needed
    textarea.style.height = textarea.scrollHeight - 30 + 'px'; // Set the height to the scrollHeight of the content
}
