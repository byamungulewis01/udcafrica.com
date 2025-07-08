<script setup>
import { ref, computed, defineProps, onMounted } from 'vue'
import { Head } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import ProjectFilter from '@/Components/Website/projects/ProjectFilter.vue'
import ProjectGrid from '@/Components/Website/projects/ProjectGrid.vue'

 defineProps({
    projects: Array,
})

// const categories = ['All', 'Residential', 'Commercial', 'Cultural', 'Urban Planning']
// const activeFilter = ref('All')

// const filteredProjects = computed(() => {
//     if (activeFilter.value === 'All') {
//         return props.projects
//     }
//     return props.projects.filter(project => project.category === activeFilter.value)
// })



</script>

<template>
    <WebsiteLayout>

        <Head title="Projects" />
        <div class="container mx-auto px-4 py-24">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h1 class="text-5xl font-light mb-6 tracking-tight">Our Projects</h1>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Explore our diverse portfolio of architectural projects spanning
                    residential, commercial, cultural, and urban design spaces.
                </p>
            </div>
            <!-- <ProjectFilter :categories="categories" :activeFilter="activeFilter"
                @update:activeFilter="activeFilter = $event" /> -->
            <ProjectGrid :projects="projects" />
        </div>
    </WebsiteLayout>
</template>