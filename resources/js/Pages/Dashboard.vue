<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <div class="space-y-6 p-6">
            <h3>Dashboard Page</h3>
        </div>
    </AuthenticatedLayout>
</template>
