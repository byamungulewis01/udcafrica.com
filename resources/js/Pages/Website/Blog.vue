<script setup>
import { Head } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import BlogCard from '@/Components/Website/blog/BlogCard.vue'
defineProps({
    blogs: Array,
})


</script>

<template>
    <WebsiteLayout>

        <Head title="Blog" />
        <main>
            <div class="container mx-auto px-4 py-24">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <h1 class="text-5xl font-light mb-6 tracking-tight">Our Journal</h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        Explore our thoughts on architecture, design trends, sustainability,
                        and behind-the-scenes insights into our projects.
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <BlogCard v-for="post in blogs" :key="post.id" :post="post" />
                </div>
            </div>
        </main>
    </WebsiteLayout>
</template>