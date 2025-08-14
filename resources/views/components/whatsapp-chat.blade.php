@php
    $config = config('live-chat');
    $isEnabled = $config['enabled'] ?? true;
    $position = $config['position'] ?? 'right';
    $buttonText = $config['button_text'] ?? 'Butuh Bantuan?';
    $welcomeMessage = $config['welcome_message'] ?? 'Halo! Ada yang bisa kami bantu?';
    $whatsappNumber = $config['whatsapp_number'] ?? '6281234567890'; // Nomor WhatsApp kampus
@endphp

@if($isEnabled)
<!-- WhatsApp Chat Widget -->
<div class="whatsapp-chat-widget {{ $position === 'left' ? 'position-left' : 'position-right' }}">
    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ urlencode($welcomeMessage) }}" 
       target="_blank" 
       class="whatsapp-chat-button"
       title="{{ $buttonText }}">
        <div class="whatsapp-icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <span class="whatsapp-text">{{ $buttonText }}</span>
    </a>
</div>

<style>
.whatsapp-chat-widget {
    position: fixed;
    bottom: 20px;
    z-index: 1000;
}

.whatsapp-chat-widget.position-right {
    right: 20px;
}

.whatsapp-chat-widget.position-left {
    left: 20px;
}

.whatsapp-chat-button {
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
    padding: 12px 20px;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(37, 211, 102, 0.3);
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 14px;
    position: relative;
    overflow: hidden;
}

.whatsapp-chat-button:hover {
    background: linear-gradient(135deg, #128c7e 0%, #075e54 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(37, 211, 102, 0.4);
    color: white;
    text-decoration: none;
}

.whatsapp-icon {
    font-size: 24px;
    margin-right: 10px;
}

.whatsapp-text {
    white-space: nowrap;
}

@media (max-width: 768px) {
    .whatsapp-chat-button {
        padding: 15px;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        justify-content: center;
    }
    
    .whatsapp-icon {
        font-size: 28px;
        margin-right: 0;
    }
    
    .whatsapp-text {
        display: none;
    }
}

/* Pulse animation */
.whatsapp-chat-button::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 100%;
    border-radius: 50px;
    background: rgba(37, 211, 102, 0.3);
    transform: translate(-50%, -50%);
    animation: pulse 2s infinite;
    z-index: -1;
}

@keyframes pulse {
    0% {
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;
    }
    70% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0;
    }
    100% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 0;
    }
}

/* Shake animation on hover */
.whatsapp-chat-button:hover {
    animation: shake 0.5s ease-in-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0) translateY(-2px); }
    25% { transform: translateX(-2px) translateY(-2px); }
    75% { transform: translateX(2px) translateY(-2px); }
}
</style>
@endif
