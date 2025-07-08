<script setup>
import { ref, onMounted } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'

// Props from Inertia
const props = defineProps({
    blog: Object,
    prevBlog: Object,
    nextBlog: Object,
    relatedBlogs: Array
})
const blog = props.blog.data || props.blog;
const loading = ref(false)

onMounted(() => {
    if (!blog) {
        router.visit('/404')
    }
})
</script>

<template>
    <WebsiteLayout>

        <Head :title="blog?.title" />
        <main class="pb-20">
            <!-- Loading state -->
            <div v-if="loading || !blog"
                class="container mx-auto px-4 py-24 flex justify-center items-center min-h-[60vh]">
                <div class="animate-pulse">
                    <div class="h-8 w-64 bg-gray-200 mb-8 rounded"></div>
                    <div class="h-96 w-full bg-gray-200 rounded"></div>
                </div>
            </div>

            <template v-else>
                <!-- Featured Image with Title Overlay -->
                <div class="w-full bg-gray-100 relative">
                    <img :src="blog.featured_image" :alt="blog.title"
                        class="w-full max-h-[420px] object-cover object-center mx-auto" />
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <h1
                            class="text-3xl md:text-5xl font-bold text-white drop-shadow-lg bg-black/40 px-6 py-4 rounded-lg text-left max-w-5xl mx-auto">
                            {{ blog.title }}
                        </h1>
                    </div>
                </div>


                <!-- Blog Content -->
                <div class="container mx-auto px-4 mt-12">
                    <div class="max-w-5xl mx-auto">
                        <div class="prose prose-lg max-w-none mb-12 text-gray-800" v-html="blog.content"></div>
                    </div>
                </div>

            </template>
        </main>
    </WebsiteLayout>
</template>
