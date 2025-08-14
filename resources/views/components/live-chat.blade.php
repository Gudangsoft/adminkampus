@php
    $config = config('live-chat');
    $isEnabled = $config['enabled'] ?? true;
    $position = $config['position'] ?? 'right';
    $buttonText = $config['button_text'] ?? 'Butuh Bantuan?';
    $welcomeMessage = $config['welcome_message'] ?? 'Halo! Ada yang bisa kami bantu?';
    $whatsappNumber = '6281234567890'; // Nomor WhatsApp kampus
@endphp

@if($isEnabled)
<!-- WhatsApp Chat Widget -->
<div class="whatsapp-chat-widget {{ $position === 'left' ? 'position-left' : 'position-right' }}">
    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($welcomeMessage) }}" 
       target="_blank" 
       class="whatsapp-chat-button"
       title="{{ $buttonText }}">
        <div class="chat-toggle-content">
            <i class="fas fa-comments"></i>
            <span class="chat-toggle-text">Butuh Bantuan?</span>
            <div class="chat-toggle-badge" x-show="hasUnreadMessages">
                <span x-text="unreadCount"></span>
            </div>
        </div>
    </div>

    <!-- Chat Window -->
    <div class="chat-window" 
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translateY(50px)"
         x-transition:enter-end="opacity-100 transform translateY(0)"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translateY(0)"
         x-transition:leave-end="opacity-0 transform translateY(50px)">
        
        <!-- Chat Header -->
        <div class="chat-header">
            <div class="chat-header-info">
                <div class="chat-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chat-header-text">
                    <h6 class="chat-title">Asisten Virtual</h6>
                    <p class="chat-status">
                        <span class="status-indicator online"></span>
                        Online - Siap Membantu
                    </p>
                </div>
            </div>
            <button class="chat-close" @click="closeChat()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Chat Messages -->
        <div class="chat-messages" x-ref="messagesContainer">
            <div class="chat-welcome" x-show="messages.length === 0">
                <div class="welcome-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <h6>Halo! 👋</h6>
                <p>Saya adalah asisten virtual kampus. Ada yang bisa saya bantu?</p>
                <div class="quick-suggestions">
                    <button class="suggestion-btn" @click="sendQuickMessage('Informasi pendaftaran')">
                        📝 Pendaftaran
                    </button>
                    <button class="suggestion-btn" @click="sendQuickMessage('Biaya kuliah')">
                        💰 Biaya Kuliah
                    </button>
                    <button class="suggestion-btn" @click="sendQuickMessage('Fasilitas kampus')">
                        🏢 Fasilitas
                    </button>
                </div>
            </div>

            <template x-for="(message, index) in messages" :key="index">
                <div class="message" :class="message.sender">
                    <div class="message-avatar" x-show="message.sender === 'bot'">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="message-content">
                        <div class="message-bubble">
                            <p x-html="formatMessage(message.content)"></p>
                            <span class="message-time" x-text="formatTime(message.timestamp)"></span>
                        </div>
                    </div>
                </div>
            </template>

            <!-- Typing Indicator -->
            <div class="message bot" x-show="isTyping">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>

            <!-- Quick Suggestions -->
            <div class="quick-suggestions" x-show="suggestions.length > 0">
                <p class="suggestions-title">Mungkin ini yang Anda cari:</p>
                <template x-for="suggestion in suggestions" :key="suggestion">
                    <button class="suggestion-btn" @click="sendQuickMessage(suggestion)" x-text="suggestion"></button>
                </template>
            </div>
        </div>

        <!-- Chat Input -->
        <div class="chat-input-wrapper">
            <div class="chat-input-container">
                <input type="text" 
                       class="chat-input" 
                       placeholder="Ketik pesan Anda..."
                       x-model="currentMessage"
                       @keydown.enter="sendMessage()"
                       :disabled="isTyping">
                <button class="chat-send-btn" 
                        @click="sendMessage()"
                        :disabled="!currentMessage.trim() || isTyping">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
            <div class="chat-input-footer">
                <small class="text-muted">Powered by AI Assistant</small>
            </div>
        </div>
    </div>
</div>

<style>
.chat-widget {
    position: fixed !important;
    bottom: 20px !important;
    right: 20px !important;
    z-index: 9999 !important;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    pointer-events: auto !important;
    visibility: visible !important;
    opacity: 1 !important;
    transition: none !important;
}

.chat-toggle {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50px;
    padding: 15px 25px;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.chat-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 30px rgba(102, 126, 234, 0.4);
}

.chat-toggle-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.chat-toggle-text {
    font-weight: 600;
    font-size: 14px;
}

.chat-toggle-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
}

.chat-window {
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: fixed !important;
    bottom: 80px !important;
    right: 20px !important;
    z-index: 10000 !important;
}

.chat-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chat-header-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chat-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}

.chat-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.chat-status {
    margin: 0;
    font-size: 12px;
    opacity: 0.9;
    display: flex;
    align-items: center;
    gap: 5px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #2ecc71;
}

.chat-close {
    background: none;
    border: none;
    color: white;
    font-size: 16px;
    cursor: pointer;
    padding: 5px;
    border-radius: 5px;
    transition: background 0.2s;
}

.chat-close:hover {
    background: rgba(255, 255, 255, 0.1);
}

.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chat-welcome {
    text-align: center;
    padding: 20px 0;
}

.welcome-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    font-size: 24px;
}

.message {
    margin-bottom: 15px;
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

.message.user {
    flex-direction: row-reverse;
}

.message-avatar {
    width: 30px;
    height: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
}

.message-content {
    flex: 1;
    max-width: 80%;
}

.message-bubble {
    background: white;
    padding: 12px 15px;
    border-radius: 18px;
    position: relative;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.message.user .message-bubble {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.message-bubble p {
    margin: 0;
    font-size: 14px;
    line-height: 1.4;
}

.message-time {
    font-size: 10px;
    opacity: 0.7;
    margin-top: 5px;
    display: block;
}

.typing-indicator {
    display: flex;
    gap: 4px;
    padding: 15px;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ccc;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

.quick-suggestions {
    margin-top: 15px;
}

.suggestions-title {
    font-size: 12px;
    color: #666;
    margin-bottom: 8px;
}

.suggestion-btn {
    display: inline-block;
    background: white;
    border: 1px solid #e0e0e0;
    border-radius: 20px;
    padding: 8px 15px;
    margin: 3px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.suggestion-btn:hover {
    background: #f0f0f0;
    border-color: #667eea;
}

.chat-input-wrapper {
    border-top: 1px solid #e0e0e0;
    background: white;
}

.chat-input-container {
    display: flex;
    padding: 15px;
    gap: 10px;
}

.chat-input {
    flex: 1;
    border: 1px solid #e0e0e0;
    border-radius: 25px;
    padding: 12px 20px;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s;
}

.chat-input:focus {
    border-color: #667eea;
}

.chat-send-btn {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}

.chat-send-btn:hover:not(:disabled) {
    transform: scale(1.05);
}

.chat-send-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.chat-input-footer {
    padding: 0 15px 10px;
    text-align: center;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .chat-widget {
        bottom: 10px;
        right: 10px;
    }
    
    .chat-window {
        width: calc(100vw - 20px);
        height: calc(100vh - 100px);
        max-width: 350px;
        max-height: 500px;
    }
    
    .chat-toggle {
        padding: 12px 20px;
    }
    
    .chat-toggle-text {
        display: none;
    }
}
</style>

<script>
function chatWidget(config = {}) {
    return {
        isOpen: false,
        messages: [],
        currentMessage: '',
        isTyping: false,
        suggestions: [],
        sessionId: null,
        hasUnreadMessages: false,
        unreadCount: 0,
        config: config,

        init() {
            console.log('init called. Initial isOpen:', this.isOpen);
            // Initialize session
            this.sessionId = this.generateSessionId();
            
            // Load chat history if exists
            this.loadChatHistory();
            
            // Send welcome message if no history
            if (this.messages.length === 0) {
                this.addMessage(this.config.welcomeMessage || 'Halo! Ada yang bisa kami bantu? 😊', 'bot');
            }
            console.log('init completed. Final isOpen:', this.isOpen);
        },

        toggleChat() {
            console.log('toggleChat called. Current isOpen:', this.isOpen);
            this.isOpen = !this.isOpen;
            console.log('toggleChat updated. New isOpen:', this.isOpen);
            if (this.isOpen) {
                this.hasUnreadMessages = false;
                this.unreadCount = 0;
                this.$nextTick(() => {
                    this.scrollToBottom();
                    this.focusInput();
                });
            }
        },

        closeChat() {
            this.isOpen = false;
        },

        async sendMessage() {
            if (!this.currentMessage.trim()) return;

            const userMessage = {
                sender: 'user',
                content: this.currentMessage,
                timestamp: Date.now()
            };

            this.messages.push(userMessage);
            const messageToSend = this.currentMessage;
            this.currentMessage = '';
            
            this.scrollToBottom();
            this.showTypingIndicator();

            // Generate auto response based on config
            setTimeout(() => {
                this.hideTypingIndicator();
                
                const botMessage = {
                    sender: 'bot',
                    content: this.generateAutoResponse(messageToSend),
                    timestamp: Date.now()
                };
                
                this.messages.push(botMessage);
                
                if (!this.isOpen) {
                    this.hasUnreadMessages = true;
                    this.unreadCount++;
                }
                
                this.scrollToBottom();
                this.saveChatHistory();
            }, 1000);
        },

        generateAutoResponse(message) {
            const lowerMessage = message.toLowerCase();
            
            // Check auto responses from config
            if (this.config.autoResponses) {
                for (const response of this.config.autoResponses) {
                    if (response.keyword && lowerMessage.includes(response.keyword.toLowerCase())) {
                        return response.response;
                    }
                }
            }
            
            // Return fallback response
            return this.config.fallbackResponse || 'Terima kasih atas pertanyaan Anda. Tim kami akan segera membantu.';
        },
                    timestamp: Date.now()
        sendQuickMessage(message) {
            this.currentMessage = message;
            this.sendMessage();
        },

        showTypingIndicator() {
            this.isTyping = true;
            this.scrollToBottom();
        },

        hideTypingIndicator() {
            this.isTyping = false;
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        focusInput() {
            const input = this.$el.querySelector('.chat-input');
            if (input) {
                input.focus();
            }
        },

        formatMessage(content) {
            // Convert newlines to <br> and make URLs clickable
            return content
                .replace(/\n/g, '<br>')
                .replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
        },

        formatTime(timestamp) {
            const date = new Date(timestamp);
            return date.toLocaleTimeString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        },

        generateSessionId() {
            return 'chat_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
        },

        saveChatHistory() {
            localStorage.setItem('chat_history', JSON.stringify({
                sessionId: this.sessionId,
                messages: this.messages.slice(-20) // Keep last 20 messages
            }));
        },

        loadChatHistory() {
            const history = localStorage.getItem('chat_history');
            if (history) {
                const data = JSON.parse(history);
                this.sessionId = data.sessionId;
                this.messages = data.messages || [];
            }
        }
    }
}
</script>

@endif
