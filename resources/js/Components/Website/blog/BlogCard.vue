<template>
    <Link :href="`/blog/${post.slug}`" class="group">
    <div class="bg-white overflow-hidden h-full flex flex-col">
        <div class="relative h-60 overflow-hidden">
            <img :src="post.featured_image" :alt="post.title"
                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" />
        </div>
        <div class="p-6 flex flex-col flex-grow">
            <span class="text-sm text-gray-500 mb-2">{{ new Date(post.published_at).toLocaleDateString('en-US', {
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
            <div class="mt-auto">
                <span class="text-sm text-gray-500 block mb-4">By {{ post.author }}</span>
                <span
                    class="inline-flex items-center text-gray-900 font-medium group-hover:opacity-70 transition-opacity">
                    Read More
                    <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                </span>
            </div>
        </div>
    </div>
    </Link>
</template>

<script setup>
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'

const props = defineProps({
    post: {
        type: Object,
        required: true,
        // Optionally, you can define the shape here for better type safety
        // validator: (obj) => ['id', 'title', 'excerpt', 'date', 'author', 'coverImage'].every(k => k in obj)
    }
})
</script>