<script setup>
import { ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import axios from 'axios'

// Reactive data
const projects = ref([])
const loading = ref(true)
const error = ref(false)

// Fetch featured projects from API
const fetchProjects = async () => {
    try {
        loading.value = true
        error.value = false

        const response = await axios.get('/api/projects')
        projects.value = response.data
    } catch (err) {
        console.error('Error fetching projects:', err)
        error.value = true
    } finally {
        loading.value = false
    }
}

// Handle image load errors
const handleImageError = (event) => {
    event.target.src = '/UDC-LOGO.png' // Fallback image
}

// Fetch data on component mount
onMounted(() => {
    fetchProjects()
})

</script>

<template>
    <!-- Loading state -->
    <div v-if="loading" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div v-for="i in 3" :key="i" class="animate-pulse">
            <div class="bg-gray-200 h-[500px] mb-4 rounded"></div>
            <div class="space-y-2">
                <div class="h-4 bg-gray-200 rounded w-1/4"></div>
                <div class="h-6 bg-gray-200 rounded w-3/4"></div>
                <div class="h-4 bg-gray-200 rounded w-full"></div>
                <div class="h-4 bg-gray-200 rounded w-2/3"></div>
            </div>
        </div>
    </div>

    <!-- Error state -->
    <div v-else-if="error" class="text-center py-12">
        <p class="text-red-600 mb-4">Failed to load projects. Please try again.</p>
        <button @click="fetchProjects"
            class="inline-flex items-center px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors">
            Retry
        </button>
    </div>
    <div v-else-if="projects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <Link v-for="project in projects" :key="project.id" :href="`/projects/${project.slug}`" class="group">
        <div class="relative overflow-hidden h-[400px] mb-4">
            <img
                :src="project.coverImage"
                :alt="project.title"
                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                @error="handleImageError"
            />
            <div
                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                <div class="text-white">
                    <span class="text-sm text-white/80">{{ project.category }}</span>
                    <h3 class="text-xl font-medium">{{ project.title }}</h3>
                </div>
            </div>
        </div>
        <div>
            <span class="text-sm text-gray-500">{{ project.category }}</span>
            <h3 class="text-xl font-medium mb-2">{{ project.title }}</h3>
            <p class="text-gray-600 line-clamp-2">{{ project.shortDescription }}</p>
        </div>
        </Link>
    </div>
    <div v-else class="text-center py-12">
        <p class="text-gray-600">No projects available at the moment.</p>
    </div>
</template>
