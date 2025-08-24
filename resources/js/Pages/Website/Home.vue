<script setup>
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import Hero from '@/Components/Website/Hero.vue'
import FeaturedProjects from '@/Components/Website/FeaturedProjects.vue'
import Services from '@/Components/Website/Services.vue'
import AboutPreview from '@/Components/Website/AboutPreview.vue'
// import LatestNews from '@/Components/Website/LatestNews.vue'
import ContactCTA from '@/Components/Website/ContactCTA.vue'
import { Head } from '@inertiajs/vue3'
defineProps({
    seo: Object,
})
</script>
<template>
    <WebsiteLayout>

        <Head :title="seo.title" />
        <Hero />
        <FeaturedProjects />
        <Services />
        <AboutPreview />
        <!-- <LatestNews /> -->
        <ContactCTA />
    </WebsiteLayout>
</template>
