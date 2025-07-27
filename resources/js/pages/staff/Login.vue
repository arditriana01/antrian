<script setup lang="ts">
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3'
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Staff',
        href: '/staff/login',
    },
];

const page = usePage()

const form = useForm({
    username: '',
    password: '',
})

const submit = () => {
    form.post('/staff/login')
}

</script>


<template>
    <AuthBase title="Staff Login" description="Masukan Email dan Passowrd">
        <Head title="Log in" />
        
        <form @submit.prevent="submit">
            
            <input v-model="form.username" type="text" placeholder="Username" class="border p-2 w-full mb-2" />

            <input v-model="form.password" type="password" placeholder="Password" class="border p-2 w-full mb-2" />
            
            <button class="bg-blue-600 text-white px-4 py-2 w-full">Login</button>            
        </form>

        <div v-if="form.errors.username" class="text-red-600 mt-2">{{ form.errors.username }}</div>
    </AuthBase>
</template>
