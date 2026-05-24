@extends('layouts.admin')

@section('header', 'Messages')

@section('content')
<div class="row">
    <!-- Sidebar: User List -->
    <div class="col-md-4">
        <div class="card card-outline card-pink" style="height: 600px;">
            <div class="card-header">
                <h3 class="card-title font-weight-bold text-pink">Chats</h3>
            </div>
            <div class="card-body p-0 overflow-auto" style="max-height: 520px;">
                <div class="list-group list-group-flush" id="user-list">
                    @forelse($users as $user)
                        @php
                            $initial = strtoupper(substr($user->name, 0, 1));
                            $bgClass = ($user->id % 2 === 0) ? 'bg-purple' : 'bg-pink';
                        @endphp
                        <a href="javascript:void(0)" onclick="selectUser({{ $user->id }}, '{{ addslashes($user->name) }}')" id="user-item-{{ $user->id }}" class="list-group-item list-group-item-action border-0 px-3 py-3 select-user-item {{ $loop->first ? 'active' : '' }}">
                            <div class="media">
                                <div class="d-flex mr-3 align-items-center justify-content-center {{ $bgClass }} text-white font-weight-bold rounded-circle shadow-sm" style="width: 45px; height: 45px; flex-shrink: 0;">
                                    {{ $initial }}
                                </div>
                                <div class="media-body text-truncate">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="mb-1 font-weight-bold text-dark text-sm truncate-text">{{ $user->name }}</h6>
                                        <small class="text-muted text-[10px]" id="user-time-{{ $user->id }}">{{ $user->last_message_time }}</small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 text-muted text-xs text-truncate font-medium" id="user-msg-{{ $user->id }}" style="max-width: 80%;">{{ $user->last_message }}</p>
                                        <span class="badge badge-pink text-white ml-2 {{ $user->unread_count > 0 ? '' : 'd-none' }}" id="user-unread-{{ $user->id }}" style="background-color: #e64a85; font-size: 10px;">{{ $user->unread_count }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-center text-muted">
                            No active conversations.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Active Chat Pane -->
    <div class="col-md-8">
        <div class="card card-pink card-outline direct-chat direct-chat-pink" style="height: 600px;">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title font-weight-bold mb-0" id="chat-header-name">
                    @if($users->isNotEmpty())
                        {{ $users->first()->name }}
                    @else
                        No Active Chat
                    @endif
                </h3>
                <div class="card-tools d-flex align-items-center">
                    <span class="badge badge-success px-2 py-1 mr-3">Online</span>
                    <button type="button" onclick="confirmEndChat()" class="btn btn-sm btn-outline-danger font-weight-bold d-none" id="end-chat-btn" style="border-radius: 8px;">
                        <i class="fas fa-times-circle mr-1"></i> End Chat
                    </button>
                </div>
            </div>
            
            <!-- Chat history area -->
            <div class="card-body">
                <div class="direct-chat-messages px-3 py-3" id="chat-messages-box" style="height: 460px; overflow-y: auto;">
                    <!-- Dynamic chat messages go here -->
                </div>
            </div>

            <!-- Chat input area -->
            <div class="card-footer bg-white border-top-0 relative">
                <!-- File Attachment Preview Bar -->
                <div id="file-preview-container" class="d-none align-items-center mb-3 p-3 bg-light border rounded" style="border-radius: 12px !important; border-color: rgba(230, 74, 133, 0.15) !important;">
                    <div class="d-flex align-items-center justify-content-center bg-pink text-white rounded-lg shadow-sm mr-3" style="width: 40px; height: 40px; border-radius: 8px; background-color: #e64a85;">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <p id="file-preview-name" class="font-weight-bold text-dark mb-0 text-sm text-truncate">filename.pdf</p>
                        <p id="file-preview-size" class="text-muted mb-0 text-[10px] font-weight-bold">1.2 MB</p>
                    </div>
                    <button type="button" onclick="clearFileAttachment()" class="btn btn-link text-secondary p-1">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>

                <form onsubmit="sendReply(event)" class="d-flex align-items-center">
                    <!-- Attach File Button -->
                    <button type="button" onclick="triggerFileInput()" class="btn btn-light d-flex align-items-center justify-content-center mr-2 text-secondary" style="width: 48px; height: 48px; border-radius: 12px; background-color: #f8f9fa; border: 1px solid #e9ecef;">
                        <i class="fas fa-paperclip text-lg"></i>
                    </button>
                    <input type="file" id="chat-file-input" class="d-none" onchange="handleFileSelected(event)">

                    <!-- Input Box Wrapper -->
                    <div class="position-relative flex-grow-1 mr-2" style="position: relative;">
                        <input type="text" id="chat-reply-input" placeholder="Type message to reply..." class="form-control border-pink focus-pink rounded-pill pl-4 pr-5" autocomplete="off" style="height: 48px; border-radius: 24px !important; padding-left: 20px; padding-right: 45px;">
                        
                        <button type="button" id="emoji-trigger" onclick="toggleEmojiPicker(event)" class="btn btn-link text-pink position-absolute" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); padding: 0; outline: none; z-index: 10; color: #e64a85;">
                            <i class="far fa-smile text-lg"></i>
                        </button>

                        <!-- Emoji Picker Popover (Gboard-style) -->
                        <div id="emoji-picker" class="d-none position-absolute bg-white border shadow-lg p-3 z-50 flex-column transition-all" style="display: none; height: 320px; width: 280px; bottom: 60px; right: 0; border-radius: 16px !important; border-color: rgba(230, 74, 133, 0.15) !important; position: absolute;">
                            <!-- Search Box -->
                            <div class="position-relative mb-2">
                                <input type="text" id="emoji-search" placeholder="Search emojis..." oninput="filterEmojis(this.value)" class="form-control form-control-sm pl-4 text-xs" style="border-radius: 12px; height: 32px; font-size: 12px;">
                            </div>

                            <!-- Emoji Grid Scroll Area -->
                            <div id="emoji-grid-container" class="flex-grow-1 overflow-auto pr-1" style="height: 200px; overflow-y: auto;">
                                <!-- Dynamic categories and emojis will render here -->
                            </div>

                            <!-- Category Tabs -->
                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2 text-muted" style="font-size: 13px; display: flex; justify-content: space-between;">
                                <button type="button" onclick="switchEmojiCategory('smileys')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-pink transition" style="color: #e64a85;" title="Smileys"><i class="far fa-laugh"></i></button>
                                <button type="button" onclick="switchEmojiCategory('animals')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Animals"><i class="fas fa-cat"></i></button>
                                <button type="button" onclick="switchEmojiCategory('food')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Food"><i class="fas fa-hamburger"></i></button>
                                <button type="button" onclick="switchEmojiCategory('activities')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Activities"><i class="fas fa-gamepad"></i></button>
                                <button type="button" onclick="switchEmojiCategory('travel')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Travel"><i class="fas fa-plane"></i></button>
                                <button type="button" onclick="switchEmojiCategory('objects')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Objects"><i class="fas fa-laptop"></i></button>
                                <button type="button" onclick="switchEmojiCategory('symbols')" class="btn btn-link btn-sm p-0 emoji-cat-btn text-secondary transition" title="Symbols"><i class="fas fa-heart"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Send Button -->
                    <button type="submit" class="btn btn-pink text-white font-weight-bold d-flex align-items-center justify-content-center shadow" style="width: 48px; height: 48px; border-radius: 50%; border: none; background-color: #e64a85; flex-shrink: 0;">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Direct chat customizations to override default bootstrap colors with pink */
    .btn-pink {
        background-color: #e64a85 !important;
        border-color: #e64a85 !important;
    }
    .btn-pink:hover {
        background-color: #c7376c !important;
        border-color: #c7376c !important;
    }
    .bg-pink {
        background-color: #e64a85 !important;
    }
    .bg-purple {
        background-color: #6f42c1 !important;
    }
    .text-pink {
        color: #e64a85 !important;
    }
    .border-pink {
        border-color: #e64a85 !important;
    }
    .focus-pink:focus {
        border-color: #e64a85 !important;
        box-shadow: 0 0 0 0.2rem rgba(230, 74, 133, 0.25) !important;
    }
    .list-group-item.active {
        background-color: rgba(230, 74, 133, 0.08) !important;
        border-left: 4px solid #e64a85 !important;
    }
    .truncate-text {
        max-width: 150px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    #chat-messages-box::-webkit-scrollbar {
        width: 5px;
    }
    #chat-messages-box::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    .hover-emoji:hover {
        background-color: rgba(230, 74, 133, 0.1);
        transform: scale(1.2);
    }
    @keyframes typing-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }
    .typing-dot {
        animation: typing-bounce 1s infinite ease-in-out;
    }
</style>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var activeUserId = {{ $users->isNotEmpty() ? $users->first()->id : 'null' }};
    var activeUserName = "{{ $users->isNotEmpty() ? addslashes($users->first()->name) : '' }}";
    var chatPollInterval = null;
    var userListPollInterval = null;
    var localUnreadCounts = {};
    var lastActiveMessageCount = null;

    // Initialize local unread counts
    @foreach($users as $user)
        localUnreadCounts[{{ $user->id }}] = {{ $user->unread_count }};
    @endforeach

    function playNotificationSound() {
        try {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const osc1 = context.createOscillator();
            const gain1 = context.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(587.33, context.currentTime); // D5
            gain1.gain.setValueAtTime(0.08, context.currentTime);
            gain1.gain.exponentialRampToValueAtTime(0.001, context.currentTime + 0.15);
            osc1.connect(gain1);
            gain1.connect(context.destination);
            osc1.start();
            osc1.stop(context.currentTime + 0.15);
            
            setTimeout(() => {
                const osc2 = context.createOscillator();
                const gain2 = context.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(880, context.currentTime); // A5
                gain2.gain.setValueAtTime(0.08, context.currentTime);
                gain2.gain.exponentialRampToValueAtTime(0.001, context.currentTime + 0.25);
                osc2.connect(gain2);
                gain2.connect(context.destination);
                osc2.start();
                osc2.stop(context.currentTime + 0.25);
            }, 100);
        } catch (e) {
            console.error("Audio Context error:", e);
        }
    }

    function selectUser(userId, userName) {
        activeUserId = userId;
        activeUserName = userName;
        lastActiveMessageCount = null;
        
        // Update user list UI active state
        document.querySelectorAll('.select-user-item').forEach(item => {
            item.classList.remove('active');
        });
        const activeItem = document.getElementById(`user-item-${userId}`);
        if (activeItem) {
            activeItem.classList.add('active');
        }

        // Update header details
        document.getElementById('chat-header-name').textContent = userName;

        // Toggle End Chat button visibility
        const endChatBtn = document.getElementById('end-chat-btn');
        if (endChatBtn) {
            if (userId) {
                endChatBtn.classList.remove('d-none');
            } else {
                endChatBtn.classList.add('d-none');
            }
        }

        // Reset badge on list item UI
        const badge = document.getElementById(`user-unread-${userId}`);
        if (badge) {
            badge.classList.add('d-none');
            badge.textContent = '0';
        }
        localUnreadCounts[userId] = 0;

        // Load chat history immediately
        loadAndRenderMessages();
    }

    function loadAndRenderMessages() {
        if (!activeUserId) return;

        $.get(`/admin/messages/fetch/${activeUserId}`, function(data) {
            const messages = data.messages || [];
            const isTyping = data.is_typing || false;

            if (lastActiveMessageCount !== null && messages.length > lastActiveMessageCount) {
                const lastMsg = messages[messages.length - 1];
                if (lastMsg.sender_id === activeUserId) {
                    playNotificationSound();
                }
            }
            lastActiveMessageCount = messages.length;
            renderChatHistory(messages);

            // Render or remove typing indicator
            const box = document.getElementById('chat-messages-box');
            let typingEl = document.getElementById('user-typing-indicator-bubble');
            if (isTyping) {
                if (!typingEl && box) {
                    typingEl = document.createElement('div');
                    typingEl.id = "user-typing-indicator-bubble";
                    typingEl.className = "direct-chat-msg d-flex align-items-center mb-3";
                    typingEl.innerHTML = `
                        <div class="direct-chat-text bg-light text-dark border-0 px-3 py-2" style="border-radius: 16px; margin-left: 0; display: inline-flex; align-items: center; gap: 4px;">
                            <span class="w-1.5 h-1.5 bg-secondary typing-dot" style="width: 6px; height: 6px; background-color: #6c757d; border-radius: 50%; display: inline-block; animation-delay: 0s"></span>
                            <span class="w-1.5 h-1.5 bg-secondary typing-dot" style="width: 6px; height: 6px; background-color: #6c757d; border-radius: 50%; display: inline-block; animation-delay: 0.2s"></span>
                            <span class="w-1.5 h-1.5 bg-secondary typing-dot" style="width: 6px; height: 6px; background-color: #6c757d; border-radius: 50%; display: inline-block; animation-delay: 0.4s"></span>
                        </div>
                    `;
                    box.appendChild(typingEl);
                    box.scrollTo({
                        top: box.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            } else {
                if (typingEl) {
                    typingEl.remove();
                }
            }
        }).fail(function(err) {
            console.error("Error fetching messages:", err);
        });
    }

    function confirmEndChat() {
        if (!activeUserId) return;
        
        if (confirm("Apakah Anda yakin ingin mengakhiri sesi chat ini? Semua riwayat pesan dengan pelanggan ini akan dihapus.")) {
            $.post('/admin/messages/clear', {
                user_id: activeUserId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function(res) {
                lastActiveMessageCount = null;
                const box = document.getElementById('chat-messages-box');
                if (box) {
                    box.innerHTML = '<div class="text-center text-muted p-4">Chat ended. History cleared.</div>';
                }
                pollUserList();
            }).fail(function(err) {
                console.error("Error ending chat:", err);
                alert("Gagal mengakhiri chat. Silakan coba lagi.");
            });
        }
    }

    function renderChatHistory(messages) {
        const box = document.getElementById('chat-messages-box');
        if (!box) return;

        // Track if scrolled to bottom before appending
        const isScrolledToBottom = box.scrollHeight - box.clientHeight <= box.scrollTop + 50;

        box.innerHTML = ''; // clear

        if (messages.length === 0) {
            box.innerHTML = '<div class="text-center text-muted p-4">No messages yet. Say hello!</div>';
            return;
        }

        messages.forEach(msg => {
            const wrapper = document.createElement('div');
            
            // Format time
            const time = new Date(msg.created_at);
            const timeStr = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            const initial = activeUserName ? activeUserName[0].toUpperCase() : 'U';
            const bgClass = (activeUserId % 2 === 0) ? 'bg-purple' : 'bg-pink';

            if (msg.sender_id === activeUserId) {
                // User Message (Left alignment in Admin view)
                wrapper.className = "direct-chat-msg mb-4";
                wrapper.innerHTML = `
                    <div class="direct-chat-infos clearfix mb-1" style="max-width: 70%; margin-left: 42px;">
                        <span class="direct-chat-name float-left font-weight-bold text-secondary text-xs">${activeUserName}</span>
                        <span class="direct-chat-timestamp float-right text-muted text-[10px]">${timeStr}</span>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="d-flex align-items-center justify-content-center rounded-circle font-weight-bold text-white text-xs ${bgClass}" style="width: 32px; height: 32px; flex-shrink: 0; margin-top: 2px;">
                            ${initial}
                        </div>
                        <div class="direct-chat-text ml-2 bg-light border border-secondary-50 text-dark px-3 py-2 text-sm rounded-lg" style="margin: 0; max-width: 70%; position: relative; border-radius: 0 12px 12px 12px !important; border: 1px solid #e9ecef !important; background-color: #f8f9fa !important; word-break: break-word;">
                            ${escapeHtml(msg.message)}
                        </div>
                    </div>
                `;
            } else {
                // Admin Message (Right alignment in Admin view)
                wrapper.className = "direct-chat-msg right mb-4";
                wrapper.innerHTML = `
                    <div class="direct-chat-infos clearfix mb-1" style="max-width: 70%; margin-right: 42px; margin-left: auto;">
                        <span class="direct-chat-name float-right font-weight-bold text-pink text-xs" style="color: #e64a85;">Admin</span>
                        <span class="direct-chat-timestamp float-left text-muted text-[10px]">${timeStr}</span>
                    </div>
                    <div class="d-flex align-items-start justify-content-end">
                        <div class="direct-chat-text mr-2 text-white px-3 py-2 text-sm rounded-lg" style="margin: 0; max-width: 70%; position: relative; background-color: #e64a85; border-radius: 12px 0 12px 12px !important; word-break: break-word;">
                            ${escapeHtml(msg.message)}
                        </div>
                        <div class="d-flex align-items-center justify-content-center rounded-circle font-weight-bold text-white text-xs bg-dark" style="width: 32px; height: 32px; flex-shrink: 0; margin-top: 2px;">
                            A
                        </div>
                    </div>
                `;
            }

            box.appendChild(wrapper);
        });

        // Scroll to bottom if user was already at bottom or on initial render
        if (isScrolledToBottom || box.scrollTop === 0) {
            box.scrollTo({
                top: box.scrollHeight,
                behavior: 'smooth'
            });
        }
    }

    function sendReply(event) {
        event.preventDefault();
        if (!activeUserId) return;

        const input = document.getElementById('chat-reply-input');
        let text = input.value.trim();
        
        if (selectedFile && !text) {
            text = `📎 [Attached File: ${selectedFile.name}]`;
        } else if (selectedFile && text) {
            text = `📎 [Attached File: ${selectedFile.name}]\n${text}`;
        }

        if (!text) return;

        // Clear input and attachment immediately for UX responsiveness
        input.value = '';
        clearFileAttachment();

        $.post('/admin/messages/send', {
            receiver_id: activeUserId,
            message: text
        }, function(msg) {
            loadAndRenderMessages();
        }).fail(function(err) {
            console.error("Error sending reply:", err);
            // Put text back in input if it failed
            input.value = text;
        });
    }

    function pollUserList() {
        $.get('/admin/messages', function(users) {
            users.forEach(u => {
                // Update last message & time
                const timeEl = document.getElementById(`user-time-${u.id}`);
                const msgEl = document.getElementById(`user-msg-${u.id}`);
                const unreadEl = document.getElementById(`user-unread-${u.id}`);

                if (timeEl) timeEl.textContent = u.last_message_time;
                if (msgEl) msgEl.textContent = u.last_message;

                if (unreadEl) {
                    if (u.id === activeUserId) {
                        unreadEl.classList.add('d-none');
                        unreadEl.textContent = '0';
                        localUnreadCounts[u.id] = 0;
                    } else {
                        if (u.unread_count > 0) {
                            unreadEl.classList.remove('d-none');
                            unreadEl.textContent = u.unread_count;

                            // Trigger toast notification if there's a new message
                            const prevCount = localUnreadCounts[u.id] || 0;
                            if (u.unread_count > prevCount) {
                                showToastNotification(u.name, u.last_message);
                                playNotificationSound();
                            }
                        } else {
                            unreadEl.classList.add('d-none');
                            unreadEl.textContent = '0';
                        }
                        localUnreadCounts[u.id] = u.unread_count;
                    }
                }
            });
        });
    }

    function showToastNotification(senderName, messageText) {
        const container = document.getElementById('toast-container') || createToastContainer();
        
        const toast = document.createElement('div');
        toast.className = "toast-notification bg-white border shadow-lg p-3 mb-3 d-flex align-items-center transition-all duration-300";
        toast.style.cssText = "width: 320px; border-left: 5px solid #e64a85 !important; border-radius: 12px; transform: translateX(120%);";
        toast.innerHTML = `
            <div class="d-flex align-items-center justify-content-center rounded-circle text-white font-weight-bold mr-3 bg-pink" style="width: 36px; height: 36px; flex-shrink: 0; font-size: 14px; background-color: #e64a85;">
                ${senderName[0].toUpperCase()}
            </div>
            <div style="flex: 1; min-width: 0;">
                <strong class="text-dark d-block text-sm" style="font-size: 13px; line-height: 1.2; margin-bottom: 2px;">${senderName}</strong>
                <span class="text-muted text-xs d-block text-truncate" style="font-size: 11px; max-width: 220px;">${messageText}</span>
            </div>
            <button type="button" class="close ml-auto" style="font-size: 16px; color: #aaa; border: none; background: none; outline: none;" onclick="this.parentElement.remove()">
                &times;
            </button>
        `;

        container.appendChild(toast);

        // Slide in
        setTimeout(() => {
            toast.style.transform = "translateX(0)";
        }, 50);

        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.style.transform = "translateX(120%)";
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
    }

    var selectedFile = null;

    const emojiCategories = {
        smileys: ['😊', '😂', '🤣', '😍', '😘', '😜', '😎', '😉', '😢', '😭', '😱', '😡', '👍', '👎', '❤️', '🔥', '✨', '👏', '🤝', '🙌', '🎉', '💩', '🤡'],
        animals: ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐸', '🐵', '🐔', '🐧', '🐦', '🦄', '🐝', '🐛', '🦋'],
        food: ['🍎', '🍌', '🍉', '🍓', '🍕', '🍔', '🍟', '🌭', '🍰', '🍩', '🍪', '🍫', '🍦', '🍨', '🍿', '🥤', '🍺', '☕', '🍙', '🍣', '🍜', '🍱'],
        activities: ['⚽', '🏀', '🏈', '⚾', '🎾', '🏐', '🏉', '🎱', '🏓', '🎮', '🕹️', '🎯', '🎨', '🎬', '🎤', '🎧', '🎸', '🎹', '🏆', '🎫'],
        travel: ['🚗', '🚕', '🚙', '🚌', '🏎️', '🚓', '🚑', '🚒', '🚲', '🛴', '🛵', '🏍️', '✈️', '🚀', '🛸', '🗺️', '🗼', '🗽', '⛺', '🎡', '🎢'],
        objects: ['💻', '📱', '⌚', '📷', '🎥', '📞', '📠', '🔋', '🔌', '💡', '🔦', '🔑', '🔨', '🛠️', '📦', '🎁', '🎈', '📚', '✏️', '🔒', '🔔'],
        symbols: ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💤', '💢', '🚫', '⚠️']
    };

    const emojiNameMap = {
        'smile': '😊😂🤣😍😘😜😎😉',
        'laugh': '😂🤣',
        'love': '😍😘❤️💕💞💓💗💖💘💝',
        'sad': '😢😭💔',
        'cry': '😢😭',
        'angry': '😡',
        'like': '👍',
        'good': '👍',
        'bad': '👎',
        'yes': '👍',
        'no': '👎',
        'fire': '🔥',
        'spark': '✨',
        'clap': '👏',
        'dog': '🐶',
        'cat': '🐱',
        'mouse': '🐭',
        'burger': '🍔',
        'pizza': '🍕',
        'cake': '🍰',
        'beer': '🍺',
        'coffee': '☕',
        'game': '🎮🕹️',
        'sport': '⚽ basketball football baseball tennis volleyball',
        'car': '🚗🚕🚙🏎️',
        'plane': '✈️',
        'laptop': '💻',
        'phone': '📱',
        'light': '💡',
        'gift': '🎁',
        'book': '📚'
    };

    function renderEmojiPicker() {
        const gridContainer = document.getElementById('emoji-grid-container');
        if (!gridContainer) return;
        gridContainer.innerHTML = '';
        for (const [catName, emojis] of Object.entries(emojiCategories)) {
            const section = document.createElement('div');
            section.id = `emoji-section-${catName}`;
            section.className = "emoji-category-section mb-3";
            const displayTitle = catName.charAt(0).toUpperCase() + catName.slice(1);
            section.innerHTML = `
                <h6 class="text-[10px] uppercase font-weight-bold text-muted mb-1 sticky-top bg-white py-1" style="font-size: 10px; font-weight: bold; color: #888; position: sticky; top: 0; background-color: #fff; z-index: 5;">${displayTitle}</h6>
                <div class="d-flex flex-wrap text-xl select-none">
                    ${emojis.map(e => `<span class="cursor-pointer text-center hover-emoji p-1 rounded transition" style="cursor: pointer; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 20px;" onclick="insertEmoji('${e}')">${e}</span>`).join('')}
                </div>
            `;
            gridContainer.appendChild(section);
        }
    }

    function toggleEmojiPicker(event) {
        event.stopPropagation();
        const picker = document.getElementById('emoji-picker');
        if (picker) {
            if (picker.style.display === 'none' || picker.classList.contains('d-none')) {
                picker.style.display = 'flex';
                picker.classList.remove('d-none');
            } else {
                picker.style.display = 'none';
                picker.classList.add('d-none');
            }
        }
    }

    function insertEmoji(emoji) {
        const input = document.getElementById('chat-reply-input');
        if (input) {
            input.value += emoji;
            input.focus();
        }
    }

    function switchEmojiCategory(catName) {
        document.querySelectorAll('.emoji-cat-btn').forEach(btn => {
            btn.classList.remove('text-pink');
            btn.classList.add('text-secondary');
        });
        const eventTarget = window.event ? window.event.currentTarget : null;
        if (eventTarget) {
            eventTarget.classList.add('text-pink');
            eventTarget.classList.remove('text-secondary');
        }
        const section = document.getElementById(`emoji-section-${catName}`);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function filterEmojis(query) {
        query = query.toLowerCase().trim();
        const gridContainer = document.getElementById('emoji-grid-container');
        if (!gridContainer) return;
        if (!query) {
            renderEmojiPicker();
            return;
        }
        let matchedEmojis = [];
        const allEmojis = Array.from(new Set(Object.values(emojiCategories).flat()));
        allEmojis.forEach(emoji => {
            let match = false;
            for (const [keyword, emojisInKeyword] of Object.entries(emojiNameMap)) {
                if (keyword.includes(query) && emojisInKeyword.includes(emoji)) {
                    match = true;
                    break;
                }
            }
            if (!match) {
                for (const [catName, emojisInCat] of Object.entries(emojiCategories)) {
                    if (catName.includes(query) && emojisInCat.includes(emoji)) {
                        match = true;
                        break;
                    }
                }
            }
            if (match) {
                matchedEmojis.push(emoji);
            }
        });
        gridContainer.innerHTML = `
            <div class="emoji-category-section">
                <h6 class="text-[10px] uppercase font-weight-bold text-muted mb-2" style="font-size: 10px; font-weight: bold; color: #888;">Search Results</h6>
                <div class="d-flex flex-wrap text-xl select-none">
                    ${matchedEmojis.length > 0 ? 
                        matchedEmojis.map(e => `<span class="cursor-pointer text-center hover-emoji p-1 rounded transition" style="cursor: pointer; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 20px;" onclick="insertEmoji('${e}')">${e}</span>`).join('') 
                        : '<div class="w-100 text-center text-xs text-muted py-3">No matching emojis found</div>'
                    }
                </div>
            </div>
        `;
    }

    // Close emoji picker when clicking anywhere else
    document.addEventListener('click', (e) => {
        const picker = document.getElementById('emoji-picker');
        if (picker && picker.style.display !== 'none' && !picker.classList.contains('d-none') && !e.target.closest('#emoji-picker') && !e.target.closest('#emoji-trigger')) {
            picker.style.display = 'none';
            picker.classList.add('d-none');
        }
    });

    function triggerFileInput() {
        const fileInput = document.getElementById('chat-file-input');
        if (fileInput) fileInput.click();
    }

    function handleFileSelected(event) {
        const file = event.target.files[0];
        if (!file) return;

        selectedFile = file;

        // Format file size
        let sizeStr = '';
        if (file.size < 1024 * 1024) {
            sizeStr = (file.size / 1024).toFixed(1) + ' KB';
        } else {
            sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
        }

        const nameEl = document.getElementById('file-preview-name');
        const sizeEl = document.getElementById('file-preview-size');
        const containerEl = document.getElementById('file-preview-container');

        if (nameEl) nameEl.textContent = file.name;
        if (sizeEl) sizeEl.textContent = sizeStr;
        if (containerEl) {
            containerEl.classList.remove('d-none');
            containerEl.classList.add('d-flex');
        }
    }

    function clearFileAttachment() {
        selectedFile = null;
        const fileInput = document.getElementById('chat-file-input');
        const containerEl = document.getElementById('file-preview-container');
        
        if (fileInput) fileInput.value = '';
        if (containerEl) {
            containerEl.classList.add('d-none');
            containerEl.classList.remove('d-flex');
        }
    }

    function escapeHtml(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Initial load
    $(document).ready(function() {
        loadAndRenderMessages();
        renderEmojiPicker();

        // Toggle End Chat button visibility on load
        const endChatBtn = document.getElementById('end-chat-btn');
        if (endChatBtn) {
            if (activeUserId) {
                endChatBtn.classList.remove('d-none');
            } else {
                endChatBtn.classList.add('d-none');
            }
        }

        // Listen for input to broadcast typing state
        let lastTypingSent = 0;
        const chatInput = document.getElementById('chat-reply-input');
        if (chatInput) {
            chatInput.addEventListener('input', () => {
                if (!activeUserId) return;
                const now = Date.now();
                if (now - lastTypingSent > 3000) {
                    lastTypingSent = now;
                    $.post('/admin/messages/typing', {
                        receiver_id: activeUserId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    }).fail(function(err) {
                        console.error("Error sending typing status:", err);
                    });
                }
            });
        }

        // Poll messages of the active chat room every 3 seconds
        chatPollInterval = setInterval(loadAndRenderMessages, 3000);

        // Poll sidebar user list and unread notifications every 3 seconds
        userListPollInterval = setInterval(pollUserList, 3000);
    });
</script>
@endsection
