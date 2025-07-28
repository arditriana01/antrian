<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="min-h-screen bg-black text-white flex flex-col items-center justify-center px-6">

    <!-- Main Content -->
    <main class="text-center mt-24">
      <h2 class="text-4xl font-extrabold mb-4">Sistem Antrian Digital</h2>
      <p class="text-gray-400 mb-10">Mudah, cepat, dan efisien</p>


      <div class="flex flex-col sm:flex-row gap-6 justify-center mb-10">
        <Link
            v-if="$page.props.auth.user"
            :href="route('dashboard')"
            class="bg-white text-black hover:bg-gray-200 transition-all px-8 py-3 rounded-full text-lg font-semibold shadow-lg">
            Reservasi Online
        </Link>
        <template v-else>
            <Link
                :href="route('login')"
                class="bg-transparent border border-white hover:bg-white hover:text-black transition-all px-8 py-3 rounded-full text-lg font-semibold">
                Reservasi Online
            </Link>
        </template>
      </div>

      <div class="text-sm text-gray-400">
        <p>Jam Operasional: 08.00 - 16.00 WITA</p>
        <p>Alamat: Jl. Contoh No. 123, Denpasar</p>
        <p>Telp: 0812-3456-7890</p>
      </div>
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 text-xs text-gray-500">
      &copy; {{ new Date().getFullYear() }} All rights reserved.
    </footer>
  </div>
</template>
