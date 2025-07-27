<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Display Antrian</title>
    <script>
        let lastQueueNumber = null;

        async function fetchQueue() {
            try {
                const res = await fetch('/display-queue');
                const data = await res.json();

                if (data.success && data.queue) {
                    const queue = data.queue;

                    document.getElementById('queueNumber').innerText = queue.queue_number;
                    document.getElementById('loket').innerText = queue.locket_counter || '-';
                    document.getElementById('petugas').innerText = queue.staff_name || '-';
                    document.getElementById('type').innerText = queue.type_queue === 'reservation' ? 'Reservasi' : 'Walk-in';

                    if (queue.queue_number !== lastQueueNumber) {
                        announce(queue);
                        lastQueueNumber = queue.queue_number;
                    }
                }
            } catch (err) {
                console.error('Gagal fetch:', err);
            }
        }

        function announce(queue) {
            const message = `Nomor antrian ${queue.queue_number}, silakan menuju loket ${queue.locket_counter}, bersama ${queue.staff_name}`;
            const speech = new SpeechSynthesisUtterance(message);
            speech.lang = 'id-ID';
            window.speechSynthesis.speak(speech);
        }

        setInterval(fetchQueue, 5000);
        window.onload = fetchQueue;
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .display-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .queue-number {
            font-size: 60px;
            font-weight: bold;
            color: #2563eb;
        }

        .info {
            font-size: 24px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="display-box">
        <h1>Antrian Dipanggil</h1>
        <div class="queue-number" id="queueNumber">-</div>
        <div class="info">Jenis: <span id="type">-</span></div>
        <div class="info">Loket: <span id="loket">-</span></div>
        <div class="info">Petugas: <span id="petugas">-</span></div>
    </div>
</body>
</html>
