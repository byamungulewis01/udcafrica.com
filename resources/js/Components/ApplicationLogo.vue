<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const props = defineProps({
    height: {
        type: String,
        default: 'h-20'
    },
    logo: {
        type: String,
        default: null
    },
    appName: {
        type: String,
        default: null
    }
});

const logoUrl = computed(() => props.logo || page.props.settings.site.logo);
const siteName = computed(() => props.appName || page.props.settings.site.site_title);
</script>

<template>
    <img :src="logoUrl" :alt="siteName" :class="[height, 'fill-current text-gray-500']" />
</template>
