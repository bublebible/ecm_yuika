<x-app-layout>
    <div
        class="min-h-screen bg-pink-50/50 font-sans text-gray-900 py-6 px-4 md:py-12 md:px-12 flex items-center justify-center">
        <!-- Main Chat Wrapper -->
        <div
            class="max-w-6xl w-full bg-white rounded-3xl shadow-xl border border-pink-100 overflow-hidden flex h-[650px] relative">

            <!-- Sidebar Panel: Conversations List -->
            <div id="chat-sidebar"
                class="w-full md:w-80 border-r border-pink-100 flex flex-col h-full bg-white z-10 transition-all duration-300">
                <!-- Sidebar Header -->
                <div class="p-6 border-b border-pink-50 flex items-center justify-between">
                    <h2 class="text-3xl font-black text-pink-600 tracking-tight">MESSAGES</h2>
                </div>

                <!-- Search Bar -->
                <div class="px-6 py-4">
                    <div class="relative">
                        <input type="text" placeholder="Search chats..."
                            class="w-full pl-10 pr-4 py-2.5 bg-pink-50/50 border border-pink-100/50 rounded-2xl text-sm focus:ring-2 focus:ring-pink-400 focus:border-transparent text-gray-700 placeholder-gray-400 transition-all">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-pink-400 text-sm"></i>
                    </div>
                </div>

                <!-- Conversations Scrollable Area -->
                <div class="flex-1 overflow-y-auto px-4 pb-6 space-y-2 no-scrollbar">

                    <!-- Chat Item: Admin -->
                    <div onclick="selectChat('admin')" id="chat-item-admin"
                        class="flex items-center gap-4 p-4 rounded-2xl hover:bg-pink-50/30 transition-all cursor-pointer border border-transparent">
                        <div class="relative flex-shrink-0">
                            <div
                                class="h-12 w-12 bg-pink-500 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-pink-200">
                                Y
                            </div>
                            <span
                                class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h3 class="font-bold text-gray-800 text-sm truncate">Yuika Rentcos Admin</h3>
                                <span id="admin-chat-time" class="text-[10px] font-semibold text-gray-400">
                                    {{ $lastMessage ? $lastMessage->created_at->format('h:i A') : 'No messages' }}
                                </span>
                            </div>
                            <p id="admin-chat-last-msg" class="text-xs text-gray-500 truncate font-medium">
                                {{ $lastMessage ? $lastMessage->message : 'Start a conversation...' }}
                            </p>
                        </div>
                    </div>

                    <!-- Chat Item: System -->
                    <div onclick="selectChat('system')" id="chat-item-system"
                        class="flex items-center gap-4 p-4 rounded-2xl hover:bg-pink-50/30 transition-all cursor-pointer border border-transparent">
                        <div class="relative flex-shrink-0">
                        </div>
                    </div>

                </div>
            </div>

            <!-- Active Chat Window -->
            <div id="chat-window" class="flex-1 flex flex-col h-full bg-pink-50/10 z-0">

                <!-- Chat Window Header -->
                <div class="p-6 border-b border-pink-100 bg-white flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4">
                        <!-- Mobile Back Button -->
                        <button onclick="toggleMobileSidebar(true)"
                            class="md:hidden text-pink-600 text-lg mr-2 p-1 hover:bg-pink-50 rounded-xl transition">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="relative">
                            <div id="active-avatar"
                                class="h-12 w-12 bg-pink-500 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-pink-200">
                                Y
                            </div>
                            <span id="active-status-dot"
                                class="absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div>
                            <h3 id="active-chat-name" class="font-extrabold text-gray-800 tracking-tight">Yuika Rentcos
                                Admin</h3>
                            <p id="active-chat-status"
                                class="text-xs text-pink-600 font-semibold uppercase tracking-wider">Online</p>
                        </div>
                    </div>

                    <!-- Header Options -->
                    <div class="flex items-center gap-3">
                        <button
                            class="w-10 h-10 bg-pink-50 hover:bg-pink-100 text-pink-600 rounded-xl transition flex items-center justify-center">
                            <i class="fas fa-phone-alt text-sm"></i>
                        </button>
                        <button
                            class="w-10 h-10 bg-pink-50 hover:bg-pink-100 text-pink-600 rounded-xl transition flex items-center justify-center">
                            <i class="fas fa-info-circle text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Messages Display Panel -->
                <div id="chat-messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar">
                    <!-- Dynamic Messages will load here -->
                </div>

                <!-- Chat Input Panel -->
                <div class="p-6 bg-white border-t border-pink-100 relative">
                    <!-- File Attachment Preview Bar -->
                    <div id="file-preview-container"
                        class="hidden items-center gap-3 p-3 bg-pink-50/50 rounded-2xl mb-3 border border-pink-100/50">
                        <div class="h-10 w-10 bg-pink-500 rounded-xl flex items-center justify-center text-white">
                            <i class="fas fa-file-alt text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="file-preview-name" class="text-xs font-bold text-gray-800 truncate">filename.pdf</p>
                            <p id="file-preview-size" class="text-[10px] text-gray-400 font-semibold">1.2 MB</p>
                        </div>
                        <button type="button" onclick="clearFileAttachment()"
                            class="text-gray-400 hover:text-pink-600 p-1">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <!-- Chatbot Quick Reply Menu -->
                    <div id="chatbot-chips-container"
                        class="flex gap-2 overflow-x-auto pb-3 mb-2 no-scrollbar scroll-smooth">
                        <button type="button" onclick="triggerChatbot('rent_flow')"
                            class="chatbot-chip px-4 py-2 text-xs font-bold text-pink-600 bg-white border border-pink-200 hover:border-pink-500 rounded-full transition-all flex items-center gap-1.5 whitespace-nowrap shadow-sm hover:shadow-md hover:bg-pink-50/20 active:scale-95">
                            <i class="fas fa-question-circle"></i> Cara Pinjam
                        </button>
                        <button type="button" onclick="triggerChatbot('rental_status')"
                            class="chatbot-chip px-4 py-2 text-xs font-bold text-pink-600 bg-white border border-pink-200 hover:border-pink-500 rounded-full transition-all flex items-center gap-1.5 whitespace-nowrap shadow-sm hover:shadow-md hover:bg-pink-50/20 active:scale-95">
                            <i class="fas fa-box"></i> Status Sewa
                        </button>
                        <button type="button" onclick="triggerChatbot('pricing')"
                            class="chatbot-chip px-4 py-2 text-xs font-bold text-pink-600 bg-white border border-pink-200 hover:border-pink-500 rounded-full transition-all flex items-center gap-1.5 whitespace-nowrap shadow-sm hover:shadow-md hover:bg-pink-50/20 active:scale-95">
                            <i class="fas fa-dollar-sign"></i> Biaya & Denda
                        </button>
                        <button type="button" onclick="triggerChatbot('location')"
                            class="chatbot-chip px-4 py-2 text-xs font-bold text-pink-600 bg-white border border-pink-200 hover:border-pink-500 rounded-full transition-all flex items-center gap-1.5 whitespace-nowrap shadow-sm hover:shadow-md hover:bg-pink-50/20 active:scale-95">
                            <i class="fas fa-map-marker-alt"></i> Lokasi Toko
                        </button>
                    </div>

                    <form id="chat-form" onsubmit="sendMessage(event)" class="flex items-center gap-4">
                        <!-- Attach File Button -->
                        <button type="button" onclick="triggerFileInput()"
                            class="w-12 h-12 bg-pink-50 hover:bg-pink-100 text-pink-500 rounded-2xl transition flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-paperclip text-lg"></i>
                        </button>
                        <input type="file" id="chat-file-input" class="hidden" onchange="handleFileSelected(event)">

                        <!-- Input Box -->
                        <div class="relative flex-1">
                            <input type="text" id="chat-input" placeholder="Type your message..." autocomplete="off"
                                class="w-full pl-5 pr-12 py-3.5 bg-pink-50/30 border border-pink-100 rounded-2xl focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm text-gray-700 placeholder-gray-400 transition-all">

                            <button type="button" id="emoji-trigger" onclick="toggleEmojiPicker(event)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-pink-400 hover:text-pink-600 transition">
                                <i class="far fa-smile text-lg"></i>
                            </button>

                            <!-- Emoji Picker Popover (Gboard-style) -->
                            <div id="emoji-picker"
                                class="hidden absolute bottom-16 right-0 bg-white border border-pink-100 shadow-2xl rounded-3xl p-4 z-50 w-72 flex flex-col transition-all duration-200"
                                style="height: 320px;">
                                <!-- Search Box -->
                                <div class="relative mb-3 flex-shrink-0">
                                    <input type="text" id="emoji-search" placeholder="Search emojis..."
                                        oninput="filterEmojis(this.value)"
                                        class="w-full pl-8 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-2xl text-xs focus:ring-2 focus:ring-pink-400 focus:border-transparent text-gray-700 placeholder-gray-400 transition-all">
                                    <i
                                        class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
                                </div>

                                <!-- Emoji Grid Scroll Area -->
                                <div id="emoji-grid-container"
                                    class="flex-1 overflow-y-auto pr-1 no-scrollbar space-y-4">
                                    <!-- Dynamic categories and emojis will render here -->
                                </div>

                                <!-- Category Tabs -->
                                <div
                                    class="flex justify-between items-center border-t border-gray-100 pt-3 mt-2 flex-shrink-0 text-gray-400">
                                    <button type="button" onclick="switchEmojiCategory('smileys')"
                                        class="emoji-cat-btn text-pink-600 transition" title="Smileys"><i
                                            class="far fa-laugh"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('animals')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Animals"><i
                                            class="fas fa-cat"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('food')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Food"><i
                                            class="fas fa-hamburger"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('activities')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Activities"><i
                                            class="fas fa-gamepad"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('travel')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Travel"><i
                                            class="fas fa-plane"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('objects')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Objects"><i
                                            class="fas fa-laptop"></i></button>
                                    <button type="button" onclick="switchEmojiCategory('symbols')"
                                        class="emoji-cat-btn hover:text-pink-600 transition" title="Symbols"><i
                                            class="fas fa-heart"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Send Button -->
                        <button type="submit" id="chat-send-btn"
                            class="w-12 h-12 bg-pink-600 hover:bg-pink-700 text-white rounded-2xl transition flex items-center justify-center shadow-lg shadow-pink-200 flex-shrink-0">
                            <i class="fas fa-paper-plane text-base"></i>
                        </button>
                    </form>

                    <!-- Notification Panel (when system chat is selected) -->
                    <div id="chat-system-info"
                        class="hidden text-center text-xs font-semibold text-gray-400 py-3 bg-gray-50 border border-gray-100 rounded-2xl uppercase tracking-wider">
                        You cannot reply to system notifications
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- FontAwesome & Custom CSS to hide scrollbars -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes typing-bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-4px);
            }
        }

        .typing-dot {
            animation: typing-bounce 1s infinite ease-in-out;
        }
    </style>

    <!-- JavaScript Live Chat System -->
    <script>
        // In-memory system messages (mock notifications)
        const systemNotifications = [
            { id: 1, sender: 'system', text: 'Your payment of Rp 150.000 for Spiderman Costume has been verified successfully.', time: '3 Days Ago' },
            { id: 2, sender: 'system', text: 'Rental #4459 has been marked as COMPLETED. Don\'t forget to leave a review of the costume!', time: 'Yesterday' }
        ];

        var currentActiveChat = 'admin';
        var chatPollInterval = null;
        var lastMessageCount = null;

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

        function selectChat(chatId) {
            currentActiveChat = chatId;

            // 1. Toggle Sidebar Active Highlights
            const adminItem = document.getElementById('chat-item-admin');
            const systemItem = document.getElementById('chat-item-system');

            if (chatId === 'admin') {
                adminItem.className = "flex items-center gap-4 p-4 rounded-2xl bg-pink-100/40 border border-pink-100 transition-all cursor-pointer shadow-sm";
                systemItem.className = "flex items-center gap-4 p-4 rounded-2xl hover:bg-pink-50/30 transition-all cursor-pointer border border-transparent";
            } else {
                systemItem.className = "flex items-center gap-4 p-4 rounded-2xl bg-pink-100/40 border border-pink-100 transition-all cursor-pointer shadow-sm";
                adminItem.className = "flex items-center gap-4 p-4 rounded-2xl hover:bg-pink-50/30 transition-all cursor-pointer border border-transparent";
            }

            // 2. Update Header details
            const activeAvatar = document.getElementById('active-avatar');
            const activeStatusDot = document.getElementById('active-status-dot');
            const activeName = document.getElementById('active-chat-name');
            const activeStatus = document.getElementById('active-chat-status');

            if (chatId === 'admin') {
                activeAvatar.textContent = 'Y';
                activeAvatar.className = "h-12 w-12 bg-pink-500 rounded-2xl flex items-center justify-center text-white font-extrabold text-lg shadow-md shadow-pink-200";
                activeStatusDot.className = "absolute -bottom-1 -right-1 h-3.5 w-3.5 bg-green-500 border-2 border-white rounded-full";
                activeName.textContent = 'Yuika Rentcos Admin';
                activeStatus.textContent = 'Online';
                activeStatus.className = "text-xs text-pink-600 font-semibold uppercase tracking-wider";
            } else {
                activeAvatar.textContent = 'S';
                activeAvatar.className = "h-12 w-12 bg-gray-200 rounded-2xl flex items-center justify-center text-gray-600 font-extrabold text-lg";
                activeStatusDot.className = "hidden";
                activeName.textContent = 'System Notification';
                activeStatus.textContent = 'Official Announcement';
                activeStatus.className = "text-xs text-gray-400 font-semibold uppercase tracking-wider";
            }

            // 3. Toggle Input field or Notification panel
            const chatForm = document.getElementById('chat-form');
            const systemInfo = document.getElementById('chat-system-info');
            const chatbotChips = document.getElementById('chatbot-chips-container');
            if (chatId === 'admin') {
                chatForm.classList.remove('hidden');
                if (chatbotChips) chatbotChips.classList.remove('hidden');
                systemInfo.classList.add('hidden');
            } else {
                chatForm.classList.add('hidden');
                if (chatbotChips) chatbotChips.classList.add('hidden');
                systemInfo.classList.remove('hidden');
            }

            // 4. Render message bubbles
            loadAndRenderMessages();

            // 5. Hide sidebar on mobile view when active chat selected
            toggleMobileSidebar(false);
        }

        function loadAndRenderMessages() {
            if (currentActiveChat === 'system') {
                renderBubbles(systemNotifications);
                return;
            }

            // Fetch from database using AJAX
            fetch('/user/messages/fetch')
                .then(res => res.json())
                .then(data => {
                    const messages = data.messages || [];
                    const isTyping = data.is_typing || false;

                    const formattedMessages = messages.map(msg => {
                        const time = new Date(msg.created_at);
                        const timeStr = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        return {
                            id: msg.id,
                            sender: msg.sender_id === {{ Auth::id() }} ? 'user' : 'admin',
                            text: msg.message,
                            time: timeStr
                        };
                    });

                    // Play sound on new incoming message
                    if (lastMessageCount !== null && messages.length > lastMessageCount) {
                        const lastMsg = messages[messages.length - 1];
                        if (lastMsg.sender_id !== {{ Auth::id() }}) {
                            playNotificationSound();
                        }
                    }
                    lastMessageCount = messages.length;

                    renderBubbles(formattedMessages);

                    // Render or remove typing indicator
                    const container = document.getElementById('chat-messages-container');
                    let typingEl = document.getElementById('admin-typing-bubble');
                    if (isTyping) {
                        if (!typingEl && container) {
                            typingEl = document.createElement('div');
                            typingEl.id = "admin-typing-bubble";
                            typingEl.className = "flex justify-start items-end gap-2.5";
                            typingEl.innerHTML = `
                                <div class="h-8 w-8 bg-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0 self-start mt-1">
                                    Y
                                </div>
                                <div class="flex flex-col items-start max-w-[70%]">
                                    <div class="bg-white border border-pink-50 text-gray-800 rounded-2xl rounded-bl-none px-4 py-3 text-sm shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0s"></span>
                                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0.2s"></span>
                                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0.4s"></span>
                                    </div>
                                </div>
                            `;
                            container.appendChild(typingEl);
                            scrollToBottom();
                        }
                    } else {
                        if (typingEl) {
                            typingEl.remove();
                        }
                    }

                    // Update sidebar admin item snippet dynamically
                    if (messages.length > 0) {
                        const lastMsg = messages[messages.length - 1];
                        const lastTime = new Date(lastMsg.created_at);
                        const lastTimeStr = lastTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                        const timeEl = document.getElementById('admin-chat-time');
                        const msgEl = document.getElementById('admin-chat-last-msg');
                        if (timeEl) timeEl.textContent = lastTimeStr;
                        if (msgEl) msgEl.textContent = lastMsg.message;
                    }
                })
                .catch(err => console.error("Error fetching messages:", err));
        }

        function renderBubbles(messages) {
            const container = document.getElementById('chat-messages-container');

            // Keep track of scroll position before rendering to prevent aggressive jumps
            const isScrolledToBottom = container.scrollHeight - container.clientHeight <= container.scrollTop + 50;

            container.innerHTML = ''; // clear

            messages.forEach(msg => {
                const bubble = document.createElement('div');

                if (msg.sender === 'user') {
                    // User Message (Right Side)
                    bubble.className = "flex justify-end items-end gap-2.5";
                    bubble.innerHTML = `
                        <div class="flex flex-col items-end max-w-[70%]">
                            <div class="bg-pink-600 text-white rounded-2xl rounded-br-none px-4 py-2.5 text-sm shadow-md shadow-pink-100 leading-relaxed font-medium">
                                ${msg.text}
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1 font-semibold flex items-center gap-1">
                                ${msg.time} <i class="fas fa-check-double text-pink-500 text-[8px]"></i>
                            </span>
                        </div>
                    `;
                } else if (msg.sender === 'admin') {
                    // Admin Message (Left Side)
                    bubble.className = "flex justify-start items-end gap-2.5";
                    bubble.innerHTML = `
                        <div class="h-8 w-8 bg-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0 self-start mt-1">
                            Y
                        </div>
                        <div class="flex flex-col items-start max-w-[70%]">
                            <div class="bg-white border border-pink-50 text-gray-800 rounded-2xl rounded-bl-none px-4 py-2.5 text-sm shadow-sm leading-relaxed font-medium">
                                ${msg.text}
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1 font-semibold">
                                ${msg.time}
                            </span>
                        </div>
                    `;
                } else {
                    // System Message
                    bubble.className = "flex justify-start items-end gap-2.5";
                    bubble.innerHTML = `
                        <div class="h-8 w-8 bg-gray-200 rounded-xl flex items-center justify-center text-gray-600 font-bold text-xs flex-shrink-0 self-start mt-1">
                            S
                        </div>
                        <div class="flex flex-col items-start max-w-[70%]">
                            <div class="bg-gray-50 border border-gray-100 text-gray-600 rounded-2xl rounded-bl-none px-4 py-2.5 text-sm leading-relaxed font-medium">
                                ${msg.text}
                            </div>
                            <span class="text-[9px] text-gray-400 mt-1 font-semibold">
                                ${msg.time}
                            </span>
                        </div>
                    `;
                }

                container.appendChild(bubble);
            });

            if (isScrolledToBottom) {
                scrollToBottom();
            }
        }

        function scrollToBottom() {
            const container = document.getElementById('chat-messages-container');
            container.scrollTo({
                top: container.scrollHeight,
                behavior: 'smooth'
            });
        }

        function sendMessage(event) {
            event.preventDefault();
            const input = document.getElementById('chat-input');
            let messageText = input.value.trim();

            if (selectedFile && !messageText) {
                messageText = `📎 [Attached File: ${selectedFile.name}]`;
            } else if (selectedFile && messageText) {
                messageText = `📎 [Attached File: ${selectedFile.name}]\n${messageText}`;
            }

            if (!messageText) return;

            // Clear input and attachment immediately for responsiveness
            input.value = '';
            clearFileAttachment();

            // Send via POST AJAX request
            fetch('/user/messages/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: messageText })
            })
                .then(res => res.json())
                .then(message => {
                    loadAndRenderMessages();
                    // Trigger scroll to bottom on new message
                    setTimeout(scrollToBottom, 100);
                })
                .catch(err => console.error("Error sending message:", err));
        }

        // Mobile responsive sidebar toggle
        function toggleMobileSidebar(showSidebar) {
            const sidebar = document.getElementById('chat-sidebar');
            const chatWindow = document.getElementById('chat-window');

            if (window.innerWidth < 768) {
                if (showSidebar) {
                    sidebar.classList.remove('hidden');
                    sidebar.classList.add('w-full');
                    chatWindow.classList.add('hidden');
                } else {
                    sidebar.classList.add('hidden');
                    chatWindow.classList.remove('hidden');
                    chatWindow.classList.add('w-full');
                }
            }
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
                section.className = "emoji-category-section mb-4";
                const displayTitle = catName.charAt(0).toUpperCase() + catName.slice(1);
                section.innerHTML = `
                    <h4 class="text-[10px] uppercase font-bold text-gray-400 mb-2 tracking-wider sticky top-0 bg-white py-1">${displayTitle}</h4>
                    <div class="grid grid-cols-6 gap-2 text-xl select-none">
                        ${emojis.map(e => `<span class="cursor-pointer text-center hover:scale-125 hover:bg-pink-50/50 active:scale-95 p-1 rounded-lg transition duration-150" onclick="insertEmoji('${e}')">${e}</span>`).join('')}
                    </div>
                `;
                gridContainer.appendChild(section);
            }
        }

        function toggleEmojiPicker(event) {
            event.stopPropagation();
            const picker = document.getElementById('emoji-picker');
            if (picker) {
                picker.classList.toggle('hidden');
            }
        }

        function insertEmoji(emoji) {
            const input = document.getElementById('chat-input');
            if (input) {
                input.value += emoji;
                input.focus();
            }
        }

        function switchEmojiCategory(catName) {
            document.querySelectorAll('.emoji-cat-btn').forEach(btn => {
                btn.classList.remove('text-pink-600');
                btn.classList.add('hover:text-pink-600');
            });
            const eventTarget = window.event ? window.event.currentTarget : null;
            if (eventTarget) {
                eventTarget.classList.add('text-pink-600');
                eventTarget.classList.remove('hover:text-pink-600');
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
                    <h4 class="text-[10px] uppercase font-bold text-gray-400 mb-2 tracking-wider">Search Results</h4>
                    <div class="grid grid-cols-6 gap-2 text-xl select-none">
                        ${matchedEmojis.length > 0 ?
                    matchedEmojis.map(e => `<span class="cursor-pointer text-center hover:scale-125 hover:bg-pink-50/50 active:scale-95 p-1 rounded-lg transition duration-150" onclick="insertEmoji('${e}')">${e}</span>`).join('')
                    : '<div class="col-span-6 text-center text-xs text-gray-400 py-4">No matching emojis found</div>'
                }
                    </div>
                </div>
            `;
        }

        // Close emoji picker when clicking anywhere else
        document.addEventListener('click', (e) => {
            const picker = document.getElementById('emoji-picker');
            if (picker && !picker.classList.contains('hidden') && !e.target.closest('#emoji-picker') && !e.target.closest('#emoji-trigger')) {
                picker.classList.add('hidden');
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
                containerEl.classList.remove('hidden');
                containerEl.classList.add('flex');
            }
        }

        function clearFileAttachment() {
            selectedFile = null;
            const fileInput = document.getElementById('chat-file-input');
            const containerEl = document.getElementById('file-preview-container');

            if (fileInput) fileInput.value = '';
            if (containerEl) {
                containerEl.classList.add('hidden');
                containerEl.classList.remove('flex');
            }
        }

        // Handle resize events to prevent hidden panels
        window.addEventListener('resize', () => {
            const sidebar = document.getElementById('chat-sidebar');
            const chatWindow = document.getElementById('chat-window');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('hidden', 'w-full');
                chatWindow.classList.remove('hidden', 'w-full');
            } else {
                if (!sidebar.classList.contains('hidden') && !chatWindow.classList.contains('hidden')) {
                    toggleMobileSidebar(true);
                }
            }
        });

        function triggerChatbot(action) {
            const userMsgText = {
                'rent_flow': '❓ Cara Pinjam Kostum',
                'rental_status': '📦 Cek Status Rental',
                'pricing': '💰 Informasi Harga & Denda',
                'location': '📍 Lokasi Toko & Kontak'
            }[action];

            if (!userMsgText) return;

            // 1. Disable all chips to prevent spam
            document.querySelectorAll('.chatbot-chip').forEach(btn => {
                btn.setAttribute('disabled', 'true');
                btn.classList.add('opacity-50', 'pointer-events-none');
            });

            const container = document.getElementById('chat-messages-container');
            const timeNow = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

            // 2. Append temporary user question bubble
            const userBubble = document.createElement('div');
            userBubble.className = "flex justify-end items-end gap-2.5 user-temp-bubble";
            userBubble.innerHTML = `
                <div class="flex flex-col items-end max-w-[70%]">
                    <div class="bg-pink-600 text-white rounded-2xl rounded-br-none px-4 py-2.5 text-sm shadow-md shadow-pink-100 leading-relaxed font-medium">
                        ${userMsgText}
                    </div>
                    <span class="text-[9px] text-gray-400 mt-1 font-semibold flex items-center gap-1">
                        ${timeNow} <i class="fas fa-check-double text-pink-500 text-[8px]"></i>
                    </span>
                </div>
            `;
            container.appendChild(userBubble);
            scrollToBottom();

            // 3. Append temporary chatbot typing bubble
            const typingBubble = document.createElement('div');
            typingBubble.id = "chatbot-typing-bubble";
            typingBubble.className = "flex justify-start items-end gap-2.5";
            typingBubble.innerHTML = `
                <div class="h-8 w-8 bg-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-sm flex-shrink-0 self-start mt-1">
                    Y
                </div>
                <div class="flex flex-col items-start max-w-[70%]">
                    <div class="bg-white border border-pink-50 text-gray-800 rounded-2xl rounded-bl-none px-4 py-3 text-sm shadow-sm flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0s"></span>
                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0.2s"></span>
                        <span class="w-1.5 h-1.5 bg-pink-500 rounded-full typing-dot" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            `;
            container.appendChild(typingBubble);
            scrollToBottom();

            const startTime = Date.now();

            // 4. Send AJAX request to chatbot endpoint
            fetch('/user/messages/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ action: action })
            })
                .then(res => res.json())
                .then(data => {
                    const elapsed = Date.now() - startTime;
                    const delay = Math.max(0, 1000 - elapsed);
                    setTimeout(() => {
                        // Remove typing bubble
                        const typingEl = document.getElementById('chatbot-typing-bubble');
                        if (typingEl) typingEl.remove();

                        // Refresh chat history from server to update database state
                        loadAndRenderMessages();

                        // Scroll to bottom
                        setTimeout(scrollToBottom, 100);

                        // Re-enable chips
                        document.querySelectorAll('.chatbot-chip').forEach(btn => {
                            btn.removeAttribute('disabled');
                            btn.classList.remove('opacity-50', 'pointer-events-none');
                        });
                    }, delay);
                })
                .catch(err => {
                    console.error("Chatbot error:", err);
                    // Remove typing bubble & user temp bubble on error
                    const typingEl = document.getElementById('chatbot-typing-bubble');
                    if (typingEl) typingEl.remove();

                    // Re-enable chips
                    document.querySelectorAll('.chatbot-chip').forEach(btn => {
                        btn.removeAttribute('disabled');
                        btn.classList.remove('opacity-50', 'pointer-events-none');
                    });
                });
        }

        // Initialize state on page load
        window.addEventListener('load', () => {
            selectChat('admin');
            renderEmojiPicker();

            // Listen for input to broadcast typing state
            let lastTypingSent = 0;
            const chatInput = document.getElementById('chat-input');
            if (chatInput) {
                chatInput.addEventListener('input', () => {
                    const now = Date.now();
                    if (now - lastTypingSent > 3000) {
                        lastTypingSent = now;
                        fetch('/messages/typing', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        }).catch(err => console.error("Error sending typing status:", err));
                    }
                });
            }

            // Poll for new messages every 3 seconds
            chatPollInterval = setInterval(() => {
                if (currentActiveChat === 'admin') {
                    loadAndRenderMessages();
                }
            }, 3000);

            if (window.innerWidth < 768) {
                toggleMobileSidebar(true);
            }
        });
    </script>
</x-app-layout>