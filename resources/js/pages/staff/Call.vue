<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import AppLayout from '@/layouts/staff/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, usePage } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Panggil Antrian',
    href: '/staff/panggil',
  },
]

type Queue = {
  id: number
  queue_number: string
  patient_name: string
  status: 'waiting' | 'called' | 'done'
}

const page = usePage()
const queues = page.props.currentQueue as Record<'waiting' | 'called' | 'done', Queue[]>

const waitingQueues = ref<Queue[]>(queues.waiting || [])
const calledQueue = ref<Queue | null>((queues.called || [])[0] || null)
const doneQueues = ref<Queue[]>(queues.done || [])


const callNextQueue = async () => {
  try {
    const response = await axios.post('/staff/call-next')
    if (response.data.success) {
      window.location.reload()
    } else {
      alert(response.data.message || 'Tidak ada antrian yang tersedia.')
    }
  } catch (error) {
    console.error('Gagal memanggil antrian:', error)
  }
}

const finishCurrentQueue = async () => {
  try {
    const response = await axios.post('/staff/queues/finish')
    if (response.data.success) {
      window.location.reload()
    } else {
      alert(response.data.message || 'Tidak ada antrian yang sedang dipanggil.')
    }
  } catch (error) {
    console.error('Gagal menyelesaikan antrian:', error)
  }
}


</script>



<template>
  <Head title="Antri" />

    <AppLayout :breadcrumbs="breadcrumbs">
      <div class="p-6 bg-gray-100 min-h-screen">
        <h1 class="text-3xl font-bold text-center mb-6">Manajemen Antrian</h1>
        
        <div class="flex justify-center mb-4">
          <button
            v-if="!calledQueue"
            @click="callNextQueue"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
          >
          
            Panggil Antrian Berikutnya
          </button>
        </div>

        <!-- Daftar Antrian -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Waiting -->
          <div>
            <h2 class="text-xl font-semibold mb-2 text-yellow-600">⏳ Menunggu</h2>
            <ul class="space-y-2">
              <li
                v-for="q in waitingQueues"
                :key="q.id"
                class="bg-white p-3 rounded shadow"
              >
                <p><strong>{{ q.queue_number }}</strong> - {{ q.patient_name }}</p>
              </li>
            </ul>
          </div>

          <!-- Called -->
          <div>
            <h2 class="text-xl font-semibold mb-2 text-blue-600">📞 Dipanggil</h2>
            <ul class="space-y-2">
              <li
                v-if="calledQueue"
                class="bg-blue-100 p-3 rounded shadow"
              >
                <p><strong>{{ calledQueue.queue_number }}</strong> - {{ calledQueue.patient_name }}</p>

                <!-- Tombol Selesaikan -->
                <button
                  @click="finishCurrentQueue"
                  class="mt-2 bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700"
                >
                  Selesaikan Antrian
                </button>
              </li>
            </ul>
          </div>


          <!-- Done -->
          <div>
            <h2 class="text-xl font-semibold mb-2 text-green-600">✅ Selesai</h2>
            <ul class="space-y-2">
              <li
                v-for="q in doneQueues"
                :key="q.id"
                class="bg-green-100 p-3 rounded shadow"
              >
                <p><strong>{{ q.queue_number }}</strong> - {{ q.patient_name }}</p>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </AppLayout>
</template>