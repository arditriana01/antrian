<script setup lang="ts">
import AppLayout from '@/layouts/staff/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/staff/dashboard',
    },
];

const data = ref(null)

const fetchMonitoring = async () => {
    try {
        const res = await fetch('/staff/dashboard/data');
        const json = await res.json();
        data.value = json;
    } catch (err) {
        console.error('Gagal mengambil data dashboard:', err);
    }
}

onMounted(fetchMonitoring)

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="p-6 space-y-6">
                <h1 class="text-2xl font-bold">Dashboard Monitoring</h1>

                <div v-if="data?.success">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-100 p-4 rounded-xl shadow">
                        <h2 class="text-lg font-semibold">Antrian Menunggu</h2>
                        <p class="text-3xl">{{ data.waiting_queues }}</p>
                        </div>

                        <div class="bg-green-100 p-4 rounded-xl shadow">
                        <h2 class="text-lg font-semibold">Staff Aktif</h2>
                        <p class="text-3xl">{{ data.active_staff }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-xl font-bold">Top 3 Staff Terbanyak Melayani</h2>
                        <ul class="list-disc pl-6 mt-2">
                            <li v-for="(s, i) in data.top_staff" :key="i">
                                {{ s.staff_name }} - {{ s.total_served }} antrian
                            </li>
                        </ul>
                    </div>

                    <div class="mt-6">
                        <h2 class="text-xl font-bold">Rata-rata Waktu Pelayanan</h2>
                        <ul class="list-disc pl-6 mt-2">
                            <li v-for="(s, i) in data.average_service_time" :key="i">
                                {{ s.staff_name }} - {{ s.avg_time_minutes }} menit
                            </li>
                        </ul>
                    </div>
                </div>

                <div v-else>
                    <p class="text-red-500">Gagal memuat data.</p>
                </div>
            </div>

        </div>
    </AppLayout>
</template>
