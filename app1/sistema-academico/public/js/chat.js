const form = document.querySelector(".typing-area"),
    incoming_id = form.querySelector(".incoming_id").value,
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault();
}

inputField.focus();
inputField.onkeyup = () => {
    if (inputField.value != "") {
        sendBtn.classList.add("active");
    } else {
        sendBtn.classList.remove("active");
    }
}

sendBtn.onclick = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = "";
                scrollToBottom();
            }
        }
    }

    // Get the current date and time
    const currentDate = new Date();
    const formattedDate = `${currentDate.getDate()} ${getMonthName(currentDate.getMonth())} ${currentDate.getHours()}:${currentDate.getMinutes()} ${currentDate.getHours() >= 12 ? 'pm' : 'am'}`;

    // Create the message with the <img> tag and current date/time
    const message = `<div class="direct-chat-msg">
                          <div class="direct-chat-info clearfix">
                             <span class="direct-chat-name pull-left">Noemi Martínez</span>
                             <span class="direct-chat-timestamp pull-right">${formattedDate}</span>
                          </div>
                          <img class="direct-chat-img" src="https://localhost/public/img/avatars/female.png" alt="message user image">
                          <div class="direct-chat-text">${inputField.value}</div>
                      </div>`;

    // Append the message to the chat container
    chatContainer.innerHTML += message;

    // Scroll to the bottom of the chat
    scrollToBottom();

    // Send the message to the server
    let formData = new FormData(form);
    xhr.send(formData);
}

// Helper function to get the month name
function getMonthName(month) {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    return months[month];
}

chatBox.onmouseenter = () => {
    chatBox.classList.add("active");
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

/*setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                if (!chatBox.classList.contains("active")) {
                    scrollToBottom();
                }
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("incoming_id=" + incoming_id);
}, 500);*/

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}