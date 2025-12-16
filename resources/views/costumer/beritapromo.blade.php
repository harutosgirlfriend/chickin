<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Chat Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

<div class="bg-white w-96 h-[600px] shadow-lg rounded-lg flex flex-col overflow-hidden">
  <!-- Header -->
  <div class="bg-blue-500 text-white p-4 font-bold">
    Admin Chat
  </div>

  <!-- Pesan -->
  <div id="chat-messages" class="flex-1 p-4 overflow-y-auto space-y-2">
    <!-- Pesan akan muncul di sini -->
  </div>

  <!-- Input -->
  <div class="p-4 border-t border-gray-200 flex">
    <input id="chat-input" type="text" placeholder="Ketik pesan..." class="flex-1 p-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    <button id="send-btn" class="bg-blue-500 text-white px-4 rounded-r-md hover:bg-blue-600">Kirim</button>
  </div>
</div>

<script>
const chatMessages = document.getElementById('chat-messages');
const chatInput = document.getElementById('chat-input');
const sendBtn = document.getElementById('send-btn');

// Fungsi menambahkan pesan ke chat
function addMessage(text, type = 'admin') {
  const msgDiv = document.createElement('div');
  msgDiv.classList.add('p-2', 'rounded-md', 'max-w-[70%]', 'break-words');

  if(type === 'admin') {
    msgDiv.classList.add('bg-blue-100', 'self-end', 'text-right');
  } else {
    msgDiv.classList.add('bg-gray-200', 'self-start', 'text-left');
  }

  msgDiv.textContent = text;
  chatMessages.appendChild(msgDiv);
  chatMessages.scrollTop = chatMessages.scrollHeight; // scroll ke bawah
}

// Kirim pesan saat tombol diklik
sendBtn.addEventListener('click', () => {
  const text = chatInput.value.trim();
  if(text) {
    addMessage(text, 'admin');
    chatInput.value = '';

    // Simulasi balasan user
    setTimeout(() => {
      addMessage('Terima kasih, pesan sudah diterima!', 'user');
    }, 1000);
  }
});

// Kirim pesan saat tekan Enter
chatInput.addEventListener('keydown', (e) => {
  if(e.key === 'Enter') sendBtn.click();
});
</script>

</body>
</html>
