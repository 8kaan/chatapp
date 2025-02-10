<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sohbet Uygulaması</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="chat-list">
            <div class="chat-header">
                <h2>Sohbetler</h2>
            </div>
            <div class="chat-items">
                <div class="chat-item active" onclick="openChat('Ahmet')">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Ahmet">
                    <div class="chat-info">
                        <h3>Ahmet</h3>
                        <p>Son mesaj: Merhaba, nasılsın?</p>
                    </div>
                </div>
                <div class="chat-item" onclick="openChat('Ayşe')">
                    <img src="https://i.pravatar.cc/150?img=2" alt="Ayşe">
                    <div class="chat-info">
                        <h3>Ayşe</h3>
                        <p>Son mesaj: Görüşmek üzere!</p>
                    </div>
                </div>
                <div class="chat-item" onclick="openChat('Mehmet')">
                    <img src="https://i.pravatar.cc/150?img=3" alt="Mehmet">
                    <div class="chat-info">
                        <h3>Mehmet</h3>
                        <p>Son mesaj: Tamam, anlaştık.</p>
                    </div>
                </div>
                <div class="chat-item" onclick="openChat('Zeynep')">
                    <img src="https://i.pravatar.cc/150?img=4" alt="Zeynep">
                    <div class="chat-info">
                        <h3>Zeynep</h3>
                        <p>Son mesaj: Yarın görüşelim mi?</p>
                    </div>
                </div>
                <div class="chat-item" onclick="openChat('Can')">
                    <img src="https://i.pravatar.cc/150?img=5" alt="Can">
                    <div class="chat-info">
                        <h3>Can</h3>
                        <p>Son mesaj: Teşekkürler!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="chat-window">
            <div class="chat-header">
                <div class="chat-header-info">
                    <img src="https://i.pravatar.cc/150?img=1" alt="Ahmet" id="current-chat-img">
                    <h3 id="current-chat-name">Ahmet</h3>
                </div>
            </div>
            <div class="chat-messages" id="chat-messages">
                <!-- Mesajlar buraya gelecek -->
            </div>
            <div class="chat-input">
                <div class="emoji-picker">
                    <button onclick="toggleEmojiPicker()">😊</button>
                    <div class="emoji-list" id="emoji-list">
                        <span onclick="addEmoji('😊')">😊</span>
                        <span onclick="addEmoji('❤️')">❤️</span>
                        <span onclick="addEmoji('😂')">😂</span>
                        <span onclick="addEmoji('👍')">👍</span>
                        <span onclick="addEmoji('🎉')">🎉</span>
                    </div>
                </div>
                <input type="text" id="message-input" placeholder="Mesaj yazın...">
                <button onclick="sendMessage()">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentChat = 'Ahmet';
        const messages = {};

        function openChat(name) {
            currentChat = name;
            document.getElementById('current-chat-name').textContent = name;
            document.getElementById('current-chat-img').src = `https://i.pravatar.cc/150?img=${getImageNumber(name)}`;
            displayMessages();
            
            // Aktif sohbeti güncelle
            document.querySelectorAll('.chat-item').forEach(item => {
                item.classList.remove('active');
                if(item.querySelector('h3').textContent === name) {
                    item.classList.add('active');
                }
            });
        }

        function getImageNumber(name) {
            const nameMap = {
                'Furkan': 1,
                'Şayli': 2,
                'Emir': 3,
                'Musa': 4,
                'Alper': 5
            };
            return nameMap[name] || 1;
        }

        function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            
            if(message) {
                if(!messages[currentChat]) {
                    messages[currentChat] = [];
                }
                
                messages[currentChat].push({
                    text: message,
                    sent: true,
                    time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                });
                
                input.value = '';
                displayMessages();
                
                // Otomatik cevap
                setTimeout(() => {
                    messages[currentChat].push({
                        text: getRandomResponse(),
                        sent: false,
                        time: new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
                    });
                    displayMessages();
                }, 1000);
            }
        }

        function getRandomResponse() {
            const responses = [
                "Tamam, anladım.",
                "Harika!",
                "Bence de öyle.",
                "Birazdan görüşürüz.",
                "Teşekkür ederim!",
                "Evet, katılıyorum.",
                "Bu çok güzel!"
            ];
            return responses[Math.floor(Math.random() * responses.length)];
        }

        function displayMessages() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.innerHTML = '';
            
            if(messages[currentChat]) {
                messages[currentChat].forEach(msg => {
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `message ${msg.sent ? 'sent' : 'received'}`;
                    messageDiv.innerHTML = `
                        <div class="message-content">
                            ${msg.text}
                            <span class="message-time">${msg.time}</span>
                        </div>
                    `;
                    chatMessages.appendChild(messageDiv);
                });
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function toggleEmojiPicker() {
            const emojiList = document.getElementById('emoji-list');
            emojiList.style.display = emojiList.style.display === 'none' ? 'flex' : 'none';
        }

        function addEmoji(emoji) {
            const input = document.getElementById('message-input');
            input.value += emoji;
            input.focus();
        }

        // Enter tuşu ile mesaj gönderme
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Sayfa yüklendiğinde emoji listesini gizle
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('emoji-list').style.display = 'none';
        });
    </script>
</body>
</html>
