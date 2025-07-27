<script setup lang="ts">
import { ref, onMounted } from 'vue'

const currentQueue = ref(null)
const lastAnnouncedNumber = ref(null)

const fetchCurrentQueue = async () => {
  try {
    const response = await fetch('/display-queue')
    const data = await response.json()

    if (data.success && data.queue.queue_number !== lastAnnouncedNumber.value) {
      currentQueue.value = data.queue
      announceQueue(data.queue)
      lastAnnouncedNumber.value = data.queue.queue_number
    }
  } catch (error) {
    console.error('Gagal mengambil data antrian:', error)
  }
}

const announceQueue = (queue) => {
  const messageParts = [`Nomor antrian ${queue.queue_number}`]

  if (queue.locket_counter) {
    messageParts.push(`silakan menuju loket ${queue.locket_counter}`)
  }

  if (queue.staff_name) {
    messageParts.push(`bersama ${queue.staff_name}`)
  }

  const message = messageParts.join(', ')
  const utterance = new SpeechSynthesisUtterance(message)
  utterance.lang = 'id-ID'
  utterance.rate = 1
  utterance.pitch = 1

  window.speechSynthesis.speak(utterance)
}

onMounted(() => {
  fetchCurrentQueue()
  setInterval(fetchCurrentQueue, 5000)
})
</script>


<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-xl p-10 text-center max-w-lg w-full">
      <h1 class="text-3xl font-bold mb-6">Antrian Sedang Dipanggil</h1>

      <div v-if="currentQueue" class="space-y-4">
        <div class="text-5xl font-extrabold text-blue-600">
          {{ currentQueue.queue_number }}
        </div>
        <div class="text-lg text-gray-700">
          Jenis: {{ currentQueue.type_queue === 'reservation' ? 'Reservasi' : 'Walk-in' }}
        </div>
        <div class="text-lg text-gray-700">
          Loket: {{ currentQueue.locket_counter || '-' }}
        </div>
        <div v-if="currentQueue.staff_name" class="text-lg text-gray-700">
          Petugas: {{ currentQueue.staff_name }}
        </div>
      </div>

      <div v-else class="text-gray-500 mt-6">
        Belum ada antrian yang sedang dipanggil.
      </div>
    </div>
  </div>
</template>



