<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gemini</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        #chat-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: linear-gradient(to right, #4FC3F7, #BA68C8);
            color: white;
            border: none;
            border-radius: 30px;
            padding: 10px 18px;
            font-weight: bold;
            box-shadow: 0 4px 12px rgba(186, 104, 200, 0.4);
            display: flex;
            align-items: center;
            gap: 6px;
            /* z-index biar selalu ada di atas konten2 lain */
            z-index: 999;
        }

        #chat-box {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 320px;
            height: 420px;
            background-color: #2B2B2B;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(186, 104, 200, 0.3);
            display: none;
            flex-direction: column;
            /* overflow hidden biar isi teks gak keluar dari kotak */
            overflow: hidden;
            z-index: 999;
        }

        #chat-box-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .msg-bot, .msg-user {
            padding: 10px 16px;
            border-radius: 20px;
            max-width: 80%;
            line-height: 1.4;
            font-size: 14px;
            word-wrap: break-word;
        }

        .msg-bot {
            background: linear-gradient(to right, #4FC3F7, #BA68C8);
            color: white;
            align-self: flex-start;
        }

        .msg-user {
            background: #29B6F6;
            color: white;
            align-self: flex-end;
        }

        #chat-box-input {
            display: flex;
            border-top: 1px solid #444;
            padding: 10px;
            background-color: #2B2B2B;
        }

        #chat-input {
            flex: 1;
            padding: 8px 12px;
            border-radius: 20px;
            border: none;
            outline: none;
            background: white;
            color: black;
        }

        #send-button {
            background: transparent;
            border: none;
            color: #BA68C8;
            font-size: 20px;
            margin-left: 10px;
        }
    </style>
</head>
<body>

    @yield('content')

    <!-- Tombol -->
    <div id="chat-icon">
        <span>Ask Gemini</span> ✨
    </div>

    <!-- Kotak Chat -->
    <div id="chat-box">
        <div id="chat-box-messages">
            <div class="msg-bot">Selamat datang! Ada yang bisa dibantu?</div>
        </div>
        <div id="chat-box-input">
            <input type="text" id="chat-input" placeholder="Tulis pesan...">
            <button id="send-button">➤</button>
        </div>
    </div>

    <script>
        document.getElementById('chat-icon').addEventListener('click', function () {
            const chatBox = document.getElementById('chat-box');
            chatBox.style.display = chatBox.style.display === 'none' ? 'flex' : 'none';
        });
    document.getElementById('send-button').addEventListener('click', function () {
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (text !== '') {
            const messages = document.getElementById('chat-box-messages');

            // Tampilkan pesan user
            const userMsg = document.createElement('div');
            userMsg.className = 'msg-user';
            userMsg.textContent = text;
            messages.appendChild(userMsg);
            input.value = '';

            // Scroll ke bawah
            messages.scrollTop = messages.scrollHeight;

            // Loading state (opsional)
            const loadingMsg = document.createElement('div');
            loadingMsg.className = 'msg-bot';
            loadingMsg.textContent = 'Mengetik...';
            messages.appendChild(loadingMsg);
            messages.scrollTop = messages.scrollHeight;

            // Kirim ke Laravel
            fetch('/ask-gemini', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: text })
            })
            .then(res => res.json())
            .then(data => {
                loadingMsg.remove(); // hapus loading
                const botMsg = document.createElement('div');
                botMsg.className = 'msg-bot';
                botMsg.textContent = data.reply;
                messages.appendChild(botMsg);
                messages.scrollTop = messages.scrollHeight;
            })
            .catch(() => {
                loadingMsg.remove();
                const botMsg = document.createElement('div');
                botMsg.className = 'msg-bot';
                botMsg.textContent = 'Ups, gagal mendapatkan balasan.';
                messages.appendChild(botMsg);
                messages.scrollTop = messages.scrollHeight;
            });
        }
    });
</script>

</body>
</html>
