document.addEventListener('DOMContentLoaded', function () {
    const emojiBtn = document.querySelector('.emoji-button');
    const emojiPicker = document.getElementById('emoji-picker');
    const messageInput = document.querySelector('.chat__conversation-panel__input.panel-item');

    // Make sure everything exists
    if (!emojiBtn || !emojiPicker || !messageInput) {
        console.warn('Emoji button, picker or input not found.');
        return;
    }

    // Toggle emoji picker
    emojiBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        emojiPicker.style.display = (emojiPicker.style.display === 'none' || emojiPicker.style.display === '') ? 'block' : 'none';
    });

    // Hide picker if clicked outside
    document.addEventListener('click', function () {
        emojiPicker.style.display = 'none';
    });

    // Prevent picker from closing when clicked inside
    emojiPicker.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Add emoji to input
    emojiPicker.querySelectorAll('span').forEach(function (emoji) {
        emoji.addEventListener('click', function () {
            insertAtCursor(messageInput, emoji.textContent);
            messageInput.focus();
        });
    });

    // Helper: Insert emoji at cursor position in input/textarea
    function insertAtCursor(input, textToInsert) {
        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;
        input.value = text.slice(0, start) + textToInsert + text.slice(end);
        input.selectionStart = input.selectionEnd = start + textToInsert.length;
    }
});
