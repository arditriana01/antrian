<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';

import { ref } from 'vue'

const services = ['Customer Services', 'Technical Support', 'Billing']
const selectedService = ref(services[0])
const estimatedTime = ref(null)

const counters = ref([0, 0, 0])
const totalServed = ref(0)

const joinQueue = () => {
  // Logic simulasi untuk update estimasi waktu
  const wait = Math.floor(Math.random() * 10) + 1
  estimatedTime.value = `${wait} mins`
}

const serveNext = (index) => {
  counters.value[index] += 1
  totalServed.value += 1
}
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-gray-50 p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035] dark:text-[#EDEDEC] dark:hover:border-[#3E3E3A]"
                    >
                        Log in
                    </Link>
                    <Link
                        :href="route('register')"
                        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                    >
                        Register
                    </Link>
                </template>
            </nav>
        </header>
        <div class=" py-8 px-6 text-center">
            <h1 class="text-3xl font-bold mb-6">Antrian Rumah Sakit</h1>                                    

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-12 rounded-lg shadow-md text-center">
                    <div class="text-green-600 text-6xl mb-2">👤</div>
                    <div class="text-2xl font-bold text-green-600">0</div>
                    <button class="mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded">Loket 1</button>
                </div>
                <div class="bg-white p-12 rounded-lg shadow-md text-center">
                    <div class="text-green-600 text-6xl mb-2">👤</div>
                    <div class="text-2xl font-bold text-green-600">0</div>
                    <button class="mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded">Loket 2</button>
                </div>
                <div class="bg-white p-12 rounded-lg shadow-md text-center">
                    <div class="text-green-600 text-6xl mb-2">👤</div>
                    <div class="text-2xl font-bold text-green-600">0</div>
                    <button class="mt-4 bg-green-500 hover:bg-green-600 text-white font-medium px-4 py-2 rounded">Loket 3</button>
                </div>
            </div>
        </div>
        <div class="hidden h-14.5 lg:block"></div>
    </div>
</template>
