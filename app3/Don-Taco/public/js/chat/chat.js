$(document).ready(function () {

    // Delete message handler
    $(document).on('click', '.delete-message-btn', function () {
        const $msgElem = $(this).closest('li');
        const msgId = $msgElem.data('msg-id');
        const senderId = $msgElem.data('sender-id');

        if (senderId != currentUserId) {
            toast.warning("You can only delete your own messages.");
            return;
        }

        if (!confirm("Are you sure you want to delete this message?")) return;

        $.post('chat/deleteMessage', { messageId: msgId }, res => {
            // Expect res.success true/false
            if (res.success) {
                $msgElem.remove();
            } else {
                toast.error(res.error || "Failed to delete message.");
            }
        }, 'json').fail(() => toast.error("Failed to delete message."));
    });

    // Edit message handler
    $(document).on('click', '.edit-message-btn', function () {
        const $msgElem = $(this).closest('li');
        const msgId = $msgElem.data('msg-id');
        const senderId = $msgElem.data('sender-id');

        if (senderId != currentUserId) {
            toast.warning("You can only edit your own messages.");
            return;
        }

        // Show prompt with current message text
        const currentText = $msgElem.find('p').text();

        const newText = prompt("Edit your message:", currentText);
        if (newText === null) return; // User cancelled

        if (newText.trim() === "") {
            toast.warning("Message cannot be empty.");
            return;
        }

        $.post('chat/editMessage', {
            message_id: msgId,
            new_message: newText.trim()
        }, res => {
            if (res.success) {
                $msgElem.find('p').html(newText.trim().replace(/\n/g, '<br>'));
            } else {
                toast.error(res.error || "Failed to edit message.");
            }
        }, 'json');
    });

    let selectedFile = null; // Hold selected file

    // Handle click on the plus icon to select a PDF
    $('.add-file-button').on('click', function () {
        $('#chatFileInput').click();
    });

    // Handle file selection
    $('#chatFileInput').on('change', function () {
        const file = this.files[0];
        if (!file || !selectedUserId) return;

        const formData = new FormData();
        formData.append('file', file);
        formData.append('to', selectedUserId);

        $.ajax({
            url: 'chat/uploadFile',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                try {
                    const result = typeof res === 'string' ? JSON.parse(res) : res;
                    if (result.success && result.message) {
                        // Send the JSON message as string
                        $.post('chat/sendMessage', {
                            to: selectedUserId,
                            message: result.message
                        }, () => {
                            lastMessageTimestamp = null;
                            fetchMessages(selectedUserId, scrollToBottom);
                        });
                    } else {
                        toast.error(result.error || 'File upload failed.');
                    }
                } catch (e) {
                    console.error('Upload failed:', e);
                    toast.error('Upload failed.');
                }
            }
        });

        // Clear file input
        $(this).val('');
    });

    const $chatMessages = $('.chat-messages');
    const $messageInput = $('#messageInput');
    const $sendBtn = $('#sendBtn');
    const $chatbox = $('.chatbox');
    const $userList = $('#userList');
    const $newChatModal = $('#newChatModal');

    const DEFAULT_AVATAR = '/uploads/default-avatar.png';
    const currentUserId = $('#currentUserId').val() || null;

    let selectedUserId = null;
    let selectedUserInfo = null;
    let lastMessageTimestamp = null; // For fetching only new messages

    // Polling config
    const POLL_INTERVAL_ACTIVE = 5000;
    const POLL_INTERVAL_INACTIVE = 30000;
    let pollInterval = document.hasFocus() ? POLL_INTERVAL_ACTIVE : POLL_INTERVAL_INACTIVE;
    let pollTimer = null;

    // === Utility Functions ===

    const capitalize = str =>
        typeof str === 'string' && str.length
            ? str.charAt(0).toUpperCase() + str.slice(1).toLowerCase()
            : '';

    const formatTime = dateString => {
        const date = new Date(dateString);
        let hours = date.getHours();
        const minutes = date.getMinutes().toString().padStart(2, '0');
        const ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12 || 12;
        return `${hours}:${minutes} ${ampm}`;
    };

    function scrollToBottom() {
        const el = document.querySelector('.chat-messages');
        el.scrollTo({ top: el.scrollHeight, behavior: 'smooth' });
    }

    const updateChatHeader = ({ username, avatar, status }) => {
        $('#chatUsername').text(capitalize(username));
        $('#chatUserAvatar').attr('src', avatar || DEFAULT_AVATAR);
        $('#chatStatus').text(status?.toLowerCase() || 'offline');
    };

    const fetchAllUsers = callback => {
        $.get('chat/fetchUsers', data => {
            try {
                const users = JSON.parse(data);
                callback(users);
            } catch (e) {
                console.error('Failed to parse user data:', e);
                callback([]);
            }
        });
    };

    const fetchUserInfo = (userId, callback) => {
        fetchAllUsers(users => {
            const user = users.find(u => u.id == userId);
            if (!user) return callback(null);

            callback({
                username: user.username,
                avatar: user.avatar || DEFAULT_AVATAR,
                status: user.status || 'offline'
            });
        });
    };

    function renderMessageContent(msgString) {
        try {
            const obj = JSON.parse(msgString);
            if (obj.type === 'file' && obj.url && obj.name) {
                return `
                <a href="${obj.url}" target="_blank" class="chat-file-link">
                    📄 ${obj.name}
                </a>
            `;
            }
        } catch (e) {
            // Not JSON? Just return plain text
        }

        // Regular message fallback
        return msgString.replace(/\n/g, '<br>');
    }

    // Modified to append only new messages
    const renderMessages = (messages = [], append = false) => {
        if (!messages.length && !append) {
            $chatMessages.html('<p class="no-messages">No messages yet.</p>');
            return;
        }

        const html = messages.map(msg => {
            // Try to detect if message is a file (JSON with type=file)
            let isFile = false;
            try {
                const obj = JSON.parse(msg.msg);
                if (obj.type === 'file' && obj.url && obj.name) {
                    isFile = true;
                }
            } catch {
                // Not JSON, ignore
            }

            return `
        <li class="${msg.outgoing_msg_id == currentUserId ? 'repaly' : 'sender'}"
                data-msg-id="${msg.msg_id}" 
                data-sender-id="${msg.outgoing_msg_id}"
                data-created-at="${msg.created_at}">
                <p>${renderMessageContent(msg.msg)}</p>
                <span class="time">${formatTime(msg.created_at)}</span>
                ${msg.outgoing_msg_id == currentUserId
                    ? (() => {
                        const msgTime = new Date(msg.created_at).getTime();
                        const now = Date.now();
                        const minutesPassed = (now - msgTime) / (1000 * 60);

                        const canEdit = minutesPassed <= 15;
                        const editBtn = (!isFile && canEdit) ? '<button class="edit-message-btn">Edit</button>' : '';
                        return `${editBtn}<button class="delete-message-btn">Delete</button>`;
                    })()
                    : ''}
        </li>`;
        }).join('');

        if (append) {
            let $ul = $chatMessages.find('ul');
            if ($ul.length === 0) {
                $chatMessages.html('<ul></ul>');
                $ul = $chatMessages.find('ul');
            }
            $ul.append(html);
        } else {
            $chatMessages.html(`<ul>${html}</ul>`);
        }

        scrollToBottom();
    };

    // Check periodically for expired edit windows and disable Edit buttons accordingly
    function refreshEditButtons() {
        const now = Date.now();

        $('.chat-messages li[data-msg-id]').each(function () {
            const $msgElem = $(this);
            const createdAt = new Date($msgElem.data('created-at')).getTime();

            const minutesPassed = (now - createdAt) / (1000 * 60);

            const $editBtn = $msgElem.find('.edit-message-btn');

            if ($editBtn.length > 0 && minutesPassed > 15) {
                // More than 15 minutes passed, remove Edit button
                $editBtn.remove();
            }
        });
    }

    // Run every 30 seconds (adjust as you like)
    setInterval(refreshEditButtons, 30000);

    // Also run once immediately on load (in case messages already loaded)
    refreshEditButtons();

    // Fetch only new messages since lastMessageTimestamp
    const fetchMessages = (userId, callback, append = false) => {
        if (!userId || !selectedUserInfo) return;

        updateChatHeader(selectedUserInfo);

        const sinceParam = lastMessageTimestamp ? `?since=${encodeURIComponent(lastMessageTimestamp)}` : '';

        $.get(`chat/fetchMessages/${userId}${sinceParam}`, data => {
            try {
                const messages = JSON.parse(data);

                if (append) {
                    if (messages.length) {
                        renderMessages(messages, true);
                        lastMessageTimestamp = messages[messages.length - 1].created_at;
                    }
                    // ⚠️ Don't re-render if no new messages on append
                } else {
                    renderMessages(messages, false);
                    if (messages.length) {
                        lastMessageTimestamp = messages[messages.length - 1].created_at;
                    }
                }

            } catch (e) {
                console.error('Error parsing messages:', e);
                if (!append) renderMessages([]);
            }
            callback?.();
        });
    };

    // User sidebar caching and rendering with search
    let allUsersCache = [];

    const renderSidebarUsers = (users) => {
        const grouped = { online: '', offline: '' };

        users.forEach(({ id, username, avatar, status }) => {
            if (!id) return;

            const userHtml = `
            <div class="chat-user d-flex align-items-center p-2 border-bottom" data-id="${id}">
                <div class="flex-shrink-0">
                    <img src="${avatar || DEFAULT_AVATAR}" class="rounded-circle" width="40" height="40" />
                </div>
                <div class="flex-grow-1 ms-3">
                    <h3>${capitalize(username)}</h3>
                    <p>${status}</p>
                </div>
            </div>
        `;

            grouped[status === 'online' ? 'online' : 'offline'] += userHtml;
        });

        $('#Online').html(grouped.online);
        $('#Offline').html(grouped.offline);
    };

    const getCurrentSearchKeyword = () => $('#inlineFormInputGroup').val().trim();

    const loadSidebarUsers = () => {
        fetchAllUsers(users => {
            allUsersCache = users;
            const keyword = getCurrentSearchKeyword();
            if (keyword) {
                filterSidebarUsers(keyword);
            } else {
                renderSidebarUsers(users);
            }
        });
    };

    const filterSidebarUsers = (keyword) => {
        if (!keyword) {
            renderSidebarUsers(allUsersCache);
            return;
        }

        const lowerKeyword = keyword.toLowerCase();

        const filtered = allUsersCache.filter(user =>
            user.username.toLowerCase().includes(lowerKeyword)
        );

        renderSidebarUsers(filtered);
    };

    $('#inlineFormInputGroup').on('input', function () {
        const keyword = $(this).val().trim();
        filterSidebarUsers(keyword);
    });

    const sendMessage = () => {
        const message = $messageInput.val().trim();

        if (!message && !selectedFile) return;
        if (!selectedUserId) return;

        const formData = new FormData();
        formData.append('to', selectedUserId);
        formData.append('message', message);

        if (selectedFile) {
            formData.append('file', selectedFile);
        }

        $.ajax({
            url: 'chat/sendMessage',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: () => {
                $messageInput.val('');
                $('#chatFileInput').val('');
                $('#chatFileName').text('');
                selectedFile = null;
                lastMessageTimestamp = null;
                fetchMessages(selectedUserId, scrollToBottom);
            },
            error: () => {
                toast.error('Failed to send message.');
            }
        });
    };

    const validateStoredUser = (userId) => {
        fetchAllUsers(users => {
            const user = users.find(u => u.id == userId);
            if (user) {
                selectedUserId = user.id;
                selectedUserInfo = {
                    username: user.username,
                    avatar: user.avatar || DEFAULT_AVATAR,
                    status: user.status || 'offline'
                };
                lastMessageTimestamp = null;
                updateChatHeader(selectedUserInfo);
                fetchMessages(userId, () => $chatbox.addClass('showbox'));
                startPolling();
            } else {
                localStorage.removeItem('lastSelectedUserId');
            }
        });
    };

    // Polling helpers
    const startPolling = () => {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = setInterval(() => {
            if (!selectedUserId) return;

            loadSidebarUsers(); // updates user list
            setTimeout(() => {
                fetchMessages(selectedUserId, null, true); // delay fetch after users are loaded
            }, 300); // delay in ms
        }, pollInterval);
    };

    const stopPolling = () => {
        if (pollTimer) clearInterval(pollTimer);
        pollTimer = null;
    };

    // Window focus/blur handling
    $(window).on('focus', () => {
        pollInterval = POLL_INTERVAL_ACTIVE;
        if (selectedUserId) startPolling();
    });

    $(window).on('blur', () => {
        pollInterval = POLL_INTERVAL_INACTIVE;
        if (selectedUserId) startPolling();
    });

    // === Event Handlers ===

    $(document).on('click', '.chat-user', function () {
        const userId = $(this).data('id');
        if (!userId) {
            return;
        }

        selectedUserId = userId;
        localStorage.setItem('lastSelectedUserId', userId);
        lastMessageTimestamp = null; // reset timestamp on chat switch

        fetchUserInfo(userId, userInfo => {
            if (!userInfo) return;

            selectedUserId = userId;
            selectedUserInfo = userInfo;
            localStorage.setItem('lastSelectedUserId', userId);
            lastMessageTimestamp = null;

            updateChatHeader(userInfo);
            fetchMessages(userId, () => $chatbox.addClass('showbox'));
            startPolling();
        });
        startPolling();
        scrollToBottom();
    });

    $(document).on('click', '#userList .choose-user', function () {
        const userId = $(this).data('id');
        if (!userId) return;

        localStorage.setItem('lastSelectedUserId', userId);
        lastMessageTimestamp = null;

        fetchUserInfo(userId, userInfo => {
            if (!userInfo) return;

            selectedUserId = userId;
            selectedUserInfo = userInfo;

            updateChatHeader(userInfo);
            fetchMessages(userId, scrollToBottom);
            $newChatModal.modal('hide');
            $chatbox.addClass('showbox');
            startPolling();
            scrollToBottom();
        });
    });

    $(document).on('mouseenter', '#userList .choose-user', function () {
        const userId = $(this).data('id');
        if (userId) {
            localStorage.setItem('lastSelectedUserId', userId);
        }
    });

    $sendBtn.on('click', sendMessage);

    $messageInput.on('keypress', e => {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    $('.add').on('click', e => {
        e.preventDefault();
        $newChatModal.modal('show');

        fetchAllUsers(users => {
            const html = users.map(({ id, username, avatar }) => `
                <li class="list-group-item choose-user" data-id="${id}" data-username="${username}">
                    <img src="${avatar || DEFAULT_AVATAR}" width="30" height="30" alt="${username} avatar" class="me-2 rounded-circle" />
                    <p class="listU">${capitalize(username)}</p>
                </li>
            `).join('');

            $userList.html(html);
        });
    });

    $('.chat-list a').on('click', function () {
        $chatbox.addClass('showbox');
        return false;
    });

    $('.chat-icon').on('click', function () {
        $chatbox.removeClass('showbox');
        stopPolling();
    });

    // === Initial Load ===

    loadSidebarUsers();

    const storedUserId = localStorage.getItem('lastSelectedUserId');
    if (storedUserId) validateStoredUser(storedUserId);

    // Start polling only if chat is open and user selected
    if (selectedUserId) startPolling();
});

// Toggle between tabs chat (online/offline)
jQuery(document).ready(function () {
    $(".chat-list a").click(function () {
        $(".chatbox").addClass("showbox");
        return false;
    });

    $(".chat-icon").click(function () {
        $(".chatbox").removeClass("showbox");
    });
});
