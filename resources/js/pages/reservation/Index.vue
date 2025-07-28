<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Reservasi',
        href: '/reservasi',
    },
];

const page = usePage()

const form = useForm({
    patient_name: '',
    phone: '',
});

const handleSubmit = () =>{
    form.post(route('reservation.store'));
}

</script>

<template>
    <Head title="Reservasi" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div v-if="page.props.flash?.message" class="mb-4 rounded-lg border-l-4 border-green-500 bg-green-100 px-4 py-3 text-green-700 shadow">                
                <p>{{ page.props.flash.message }}</p>
            </div>
            
            <form @submit.prevent="handleSubmit" class="w-8/12 space-y-4">
                <div class="space-y-2">
                    <Label for="Paient Name">Nama Pasien</Label>
                    <Input v-model="form.patient_name" type="text" placeholder="Masukan Nama Pasien" />
                    <div class="text-sm text-red-600" v-if="form.errors.patient_name"> {{ form.errors.patient_name }} </div>
                </div>

                <div class="space-y-2">
                    <Label for="Phone">No TLP</Label>
                    <Input v-model="form.phone" type="text" placeholder="Masukan No Tlp" />
                    <div class="text-sm text-red-600" v-if="form.errors.phone"> {{ form.errors.phone }} </div>
                </div>

                <Button type="submit" :disabled="form.processing">Reservasi Antrian</Button>
            </form>
        </div>
    </AppLayout>
</template>
