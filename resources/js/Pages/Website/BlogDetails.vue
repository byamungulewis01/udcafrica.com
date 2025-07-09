<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import { ArrowLeft, Clock, User, Calendar, ChevronLeft, ArrowRight } from 'lucide-vue-next'

// Props from Inertia
const props = defineProps({
    blog: Object,
    prevBlog: Object,
    nextBlog: Object,
    relatedBlogs: Array
})

const blog = props.blog.data || props.blog;
const loading = ref(false)
const readingTime = ref(0)

// Calculate reading time
const calculateReadingTime = (content) => {
    const wordsPerMinute = 200
    const words = content.replace(/<[^>]*>/g, '').split(/\s+/).length
    return Math.ceil(words / wordsPerMinute)
}

onMounted(() => {
    if (!blog) {
        router.visit('/404')
    } else {
        readingTime.value = calculateReadingTime(blog.content)
    }
})

</script>

<template>
    <WebsiteLayout>

        <Head :title="blog?.title" />
        <!-- Loading state -->
        <div v-if="loading || !blog" class="container mx-auto px-4 py-24 flex justify-center items-center min-h-[60vh]">
            <div class="animate-pulse">
                <div class="h-8 w-64 bg-gray-200 mb-8 rounded"></div>
                <div class="h-96 w-full bg-gray-200 rounded"></div>
            </div>
        </div>

        <template v-else>
            <!-- Hero Section -->
            <div class="relative h-[70vh] bg-gray-900">
                <div class="absolute inset-0">
                    <img :src="blog.featured_image" :alt="blog.title" class="w-full h-full object-cover opacity-80" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                </div>
                <div class="container mx-auto px-4 h-full flex flex-col justify-end pb-16 relative z-10">
                    <div class="flex items-center text-white/80 mb-2">
                        <User :size="18" class="mr-2" />
                        <span class="font-medium">{{ blog.author }}</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl font-light text-white tracking-tight mb-4">
                        {{ blog.title }}
                    </h1>
                    <div class="text-white/90">
                        <span class="inline-block mr-6">
                            <Calendar :size="18" class="inline mr-2" />
                            {{ new Date(blog.published_at).toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }) }}
                        </span>
                        <span class="inline-block">
                            <Clock :size="18" class="inline mr-2" />
                            {{ readingTime }} min read
                        </span>
                    </div>
                </div>
            </div>

            <!-- Back to blog -->
            <div class="container mx-auto px-4 pt-8">
                <Link href="/blog" class="inline-flex items-center text-gray-600 hover:text-black transition-colors">
                <ChevronLeft :size="20" class="mr-1" />
                Back to All Articles
                </Link>
            </div>

            <!-- Blog Content -->
            <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-12 gap-12 my-12">
                <div class="md:col-span-8">
                    <div class="prose prose-lg max-w-none mb-4 text-gray-700" v-html="blog.content"></div>
                </div>

                <div class="md:col-span-4">
                    <div class="sticky top-32">
                        <!-- Related Articles -->
                        <div v-if="relatedBlogs && relatedBlogs.length > 0" class="bg-gray-50 p-6 rounded-lg mb-8">
                            <h3 class="text-xl font-medium mb-4">Related Articles</h3>
                            <div class="space-y-4">
                                <Link v-for="related in relatedBlogs.slice(0, 3)" :key="related.id"
                                    :href="`/blog/${related.slug}`" class="group cursor-pointer block">
                                <div class="flex gap-3">
                                    <img :src="related.featured_image" :alt="related.title"
                                        class="w-16 h-16 object-cover rounded-lg group-hover:scale-105 transition-transform" />
                                    <div>
                                        <h4
                                            class="font-medium text-gray-900 text-sm group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ related.title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ related.author }}</p>
                                    </div>
                                </div>
                                </Link>
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex justify-between items-center mt-12 mb-20">
                            <template v-if="prevBlog">
                                <Link :href="`/blog/${prevBlog.slug}`"
                                    class="flex items-center text-gray-700 hover:text-black transition-colors group">
                                <ArrowLeft :size="20"
                                    class="mr-2 transform group-hover:-translate-x-1 transition-transform" />
                                <span>Previous Article</span>
                                </Link>
                            </template>
                            <template v-else>
                                <div></div>
                            </template>

                            <template v-if="nextBlog">
                                <Link :href="`/blog/${nextBlog.slug}`"
                                    class="flex items-center text-gray-700 hover:text-black transition-colors group ml-auto">
                                <span>Next Article</span>
                                <ArrowRight :size="20"
                                    class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <section class="py-24 bg-udc-dark text-white">
                <div class="container mx-auto px-4">
                    <div class="max-w-3xl mx-auto text-center">
                        <h2 class="text-4xl font-light mb-6 tracking-tight">
                            Ready to take the next step?
                        </h2>
                        <p class="text-xl text-white/80 mb-10 leading-relaxed">
                            Contact UDC Africa for expert guidance on launching your construction venture in Rwanda.
                            Let's build the
                            future together!
                        </p>
                        <Link href="/contact"
                            class="bg-udc-gold text-udc-dark px-10 py-4 inline-flex items-center hover:bg-opacity-90 transition-colors group">
                        Contact Us
                        <ArrowRight :size="18" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                        </Link>
                    </div>
                </div>
            </section>
        </template>
    </WebsiteLayout>
</template>