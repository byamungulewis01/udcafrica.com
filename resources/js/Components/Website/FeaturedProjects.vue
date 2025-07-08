<template>
    <section class="py-24">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
          <div class="max-w-xl mb-8 md:mb-0">
            <h2 class="text-4xl font-light mb-6 tracking-tight">Featured Projects</h2>
            <p class="text-gray-600 leading-relaxed">
              We are proud to have delivered diverse projects across residential, commercial, and public sectors. Our work speaks for itself; combining visionary design with hardheaded engineering.
            </p>
          </div>
          <Link
            href="/projects"
            class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity"
          >
            View All Projects
            <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
          </Link>
        </div>

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
          <button
            @click="fetchFeaturedProjects"
            class="inline-flex items-center px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors"
          >
            Retry
          </button>
        </div>

        <!-- Projects grid -->
        <div v-else-if="featuredProjects.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <Link
            v-for="project in featuredProjects"
            :key="project.id"
            :href="`/projects/${project.slug}`"
            class="group"
          >
            <div class="relative overflow-hidden h-[500px] mb-4">
              <img
                :src="project.coverImage"
                :alt="project.title"
                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                @error="handleImageError"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
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

        <!-- Empty state -->
        <div v-else class="text-center py-12">
          <p class="text-gray-600">No featured projects available at the moment.</p>
        </div>
      </div>
    </section>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue'
  import { Link } from '@inertiajs/vue3'
  import { ArrowRight } from 'lucide-vue-next'
  import axios from 'axios'

  // Reactive data
  const featuredProjects = ref([])
  const loading = ref(true)
  const error = ref(false)

  // Fetch featured projects from API
  const fetchFeaturedProjects = async () => {
    try {
      loading.value = true
      error.value = false

      const response = await axios.get('/api/featured-projects')
      featuredProjects.value = response.data
    } catch (err) {
      console.error('Error fetching featured projects:', err)
      error.value = true
    } finally {
      loading.value = false
    }
  }

  // Handle image load errors
  const handleImageError = (event) => {
    event.target.src = '/udc-africa-opengraph.jpg' // Fallback image
  }

  // Fetch data on component mount
  onMounted(() => {
    fetchFeaturedProjects()
  })
  </script>

  <style scoped>
  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
  </style>