<div id="chatbot-container" style="position: fixed; bottom: 20px; right: 20px; z-index: 1000; font-family: 'Inter', sans-serif;">
    <!-- Chat Toggle Button -->
    <button id="chat-toggle" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white; border: none; border-radius: 50%; width: 60px; height: 60px; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); display: flex; align-items: center; justify-content: center; transition: transform 0.2s;">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 21 1.9-5.7a8.5 8.5 0 1 1 3.8 3.8z"/></svg>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" style="display: none; width: 350px; height: 500px; background: white; border-radius: 15px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); flex-direction: column; overflow: hidden; margin-bottom: 20px;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%); color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <div style="width: 10px; height: 10px; background: #4ade80; border-radius: 50%;"></div>
                <span style="font-weight: 600;">Family AI Assistant</span>
            </div>
            <button id="chat-close" style="background: none; border: none; color: white; cursor: pointer;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" style="flex: 1; padding: 15px; overflow-y: auto; background: #f9fafb; display: flex; flex-direction: column; gap: 10px;">
            <div style="background: #e5e7eb; padding: 10px 15px; border-radius: 15px 15px 15px 0; max-width: 80%; align-self: flex-start; font-size: 14px;">
                Hello! I am your Family AI Assistant. Ask me anything about your family tree.
            </div>
        </div>

        <!-- Input Area -->
        <div style="padding: 15px; border-top: 1px solid #e5e7eb; display: flex; gap: 10px;">
            <input type="text" id="chat-input" placeholder="Type your message..." style="flex: 1; border: 1px solid #d1d5db; border-radius: 20px; padding: 8px 15px; outline: none; font-size: 14px;">
            <button id="chat-send" style="background: #6366f1; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chat-toggle');
    const chatWindow = document.getElementById('chat-window');
    const chatClose = document.getElementById('chat-close');
    const chatSend = document.getElementById('chat-send');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');

    chatToggle.onclick = () => {
        chatWindow.style.display = chatWindow.style.display === 'none' ? 'flex' : 'none';
        chatToggle.style.display = chatWindow.style.display === 'none' ? 'flex' : 'none';
    };

    chatClose.onclick = () => {
        chatWindow.style.display = 'none';
        chatToggle.style.display = 'flex';
    };

    const addMessage = (text, isUser = false) => {
        const div = document.createElement('div');
        div.style.padding = '10px 15px';
        div.style.borderRadius = isUser ? '15px 15px 0 15px' : '15px 15px 15px 0';
        div.style.maxWidth = '80%';
        div.style.alignSelf = isUser ? 'flex-end' : 'flex-start';
        div.style.background = isUser ? '#6366f1' : '#e5e7eb';
        div.style.color = isUser ? 'white' : 'black';
        div.style.fontSize = '14px';
        div.innerText = text;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    const sendMessage = async () => {
        const message = chatInput.value.trim();
        if (!message) return;

        addMessage(message, true);
        chatInput.value = '';

        // Add loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.innerText = 'AI is thinking...';
        loadingDiv.style.fontSize = '12px';
        loadingDiv.style.color = '#9ca3af';
        chatMessages.appendChild(loadingDiv);

        try {
            const response = await fetch('{{ route("chatbot.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            });

            const data = await response.json();
            chatMessages.removeChild(loadingDiv);

            if (data.response) {
                addMessage(data.response);
            } else {
                addMessage('Error: ' + (data.error || 'Unknown error'));
            }
        } catch (error) {
            chatMessages.removeChild(loadingDiv);
            addMessage('Error: Could not connect to the server.');
        }
    };

    chatSend.onclick = sendMessage;
    chatInput.onkeypress = (e) => { if (e.key === 'Enter') sendMessage(); };
});
</script>
