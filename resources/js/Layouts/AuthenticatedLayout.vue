<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import { computed, watch } from 'vue';

import Toaster from '@/Components/ui/toast/Toaster.vue'
import { useToast } from '@/Components/ui/toast/use-toast'
const { toast } = useToast()

const page = usePage();
const user = computed(() => page.props.auth.user);

const appName = computed(() => page.props.settings.site.site_title || "Admin Panel");

const props = computed(() => page.props);
watch(props, (newProps) => {
    if (newProps.flash.success) {
        toast({
            description: newProps.flash.success,
            variant: 'success',
        });
    }
    if (newProps.flash.warning) {
        toast({
            description: newProps.flash.warning,
            variant: 'warning',
        });
    }
    if (newProps.flash.error) {
        toast({
            description: newProps.flash.error,
            variant: 'destructive',
        });
    }
    if (newProps.flash.info) {
        toast({
            description: newProps.flash.info,
            variant: 'info',
        });
    }
}, { immediate: true });

</script>

<template>
    <div class="admin-panel min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-500">
        <Toaster />
        <!-- Mobile Menu Button -->
        <Sidebar :user.value :appName />
        <!-- Main Content Area -->
        <div class="lg:pl-72 flex flex-col min-h-screen">
            <!-- Top Navigation Bar -->
            <Navbar :user.value :appName />

            <!-- Page Content -->
            <main class="p-6 min-h-screen">
                <slot />
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 shadow mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
                        <div>© {{ new Date().getFullYear() }} {{ appName }}. All rights reserved.</div>
                        <div class="flex space-x-4">
                            <Link href="/terms" class="hover:text-primary">Terms</Link>
                            <Link href="/privacy" class="hover:text-primary">Privacy</Link>
                            <Link href="/contact" class="hover:text-primary">Contact</Link>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>
