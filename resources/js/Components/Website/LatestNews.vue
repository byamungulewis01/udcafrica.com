<template>
    <section class="py-24 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
                <div class="max-w-xl mb-8 md:mb-0">
                    <h2 class="text-4xl font-light mb-6 tracking-tight">Latest Articles</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Whether you're a developer, stakeholder, student, or simply passionate about buildings and
                        housing this is where purpose-driven construction meets thought leadership.
                    </p>
                </div>
                <Link href="/blog"
                    class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity">
                View All Articles
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
                <p class="text-red-600 mb-4">Failed to load blogs. Please try again.</p>
                <button @click="fetchFeaturedBlogs"
                    class="inline-flex items-center px-4 py-2 bg-black text-white hover:bg-gray-800 transition-colors">
                    Retry
                </button>
            </div>

            <div v-else-if="latestPosts.length > 0" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <Link v-for="post in latestPosts" :key="post.id" :href="`/blog/${post.slug}`" class="group">
                <div class="bg-white overflow-hidden">
                    <div class="relative h-60 overflow-hidden">
                        <img :src="post.featured_image" :alt="post.title" @error="handleImageError"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" />
                    </div>
                    <div class="p-6">
                        <span class="text-sm text-gray-500">{{ new Date(post.published_at).toLocaleDateString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                            }) }}</span>
                        <h3 class="text-xl font-medium mb-3 group-hover:text-gray-700 transition-colors">
                            {{ post.title }}
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            {{ post.excerpt }}
                        </p>
                        <span
                            class="inline-flex items-center text-gray-900 font-medium group-hover:opacity-70 transition-opacity">
                            Read More
                            <ArrowRight :size="16"
                                class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                        </span>
                    </div>
                </div>
                </Link>
            </div>

            <!-- Empty state -->
            <div v-else class="text-center py-12">
                <p class="text-gray-600">No featured blogs available at the moment.</p>
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
const latestPosts = ref([])
const loading = ref(true)
const error = ref(false)

// Fetch featured blogs from API
const fetchFeaturedBlogs = async () => {
    try {
        loading.value = true
        error.value = false

        const response = await axios.get('/api/featured-blogs')
        latestPosts.value = response.data
    } catch (err) {
        console.error('Error fetching featured blogs:', err)
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
    fetchFeaturedBlogs()
})
</script>
