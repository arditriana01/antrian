<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import AppLayout from '@/layouts/staff/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Antri',
        href: '/antri',
    },
];

const page = usePage()

const form = useForm({
    patient_name: '',
    phone: '',
});

const handleSubmit = () =>{
    form.post(route('walkin.store'));
}

</script>

<template>
    <Head title="Antri" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <div v-if="page.props.flash?.message" class="alert mb-4">
                {{ page.props.flash?.message }}
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

                <Button type="submit" :disabled="form.processing">Tambah Antrian</Button>
            </form>
        </div>
    </AppLayout>
</template>
