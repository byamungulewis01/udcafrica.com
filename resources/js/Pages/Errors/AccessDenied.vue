<script setup>
import { Head } from '@inertiajs/vue3';
import { ShieldAlert, ArrowLeft } from 'lucide-vue-next';
import { Button } from '@/Components/ui/button';

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";

const props = defineProps({
    message: {
        type: String,
        default: 'You do not have permission to access this resource.'
    },
    userRole: String,
    requiredRoles: Array
});

function goBack() {
    window.history.back();
}
</script>

<template>
    <Head title="Access Denied" />

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <Card class="w-full max-w-md">
            <CardHeader class="pb-4">
                <div class="flex justify-center mb-4">
                    <div class="bg-red-100 p-3 rounded-full">
                        <ShieldAlert class="h-10 w-10 text-red-600" />
                    </div>
                </div>
                <CardTitle class="text-center text-2xl font-bold text-gray-900">Access Denied</CardTitle>
                <CardDescription class="text-center mt-2">{{ message }}</CardDescription>
            </CardHeader>

            <CardFooter class="flex justify-center">
                <Button @click="goBack" variant="outline" class="flex items-center gap-2">
                    <ArrowLeft class="h-4 w-4" />
                    Go Back
                </Button>
            </CardFooter>
        </Card>
    </div>
</template>
