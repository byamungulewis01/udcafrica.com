<script setup>
import { ref, onMounted } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import { ArrowLeft, Clock, User, Calendar } from 'lucide-vue-next'

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
        <main class="min-h-screen bg-gradient-to-br from-slate-50 to-white">
            <!-- Loading state -->
            <div v-if="loading || !blog"
                class="container mx-auto px-4 py-24 flex justify-center items-center min-h-[60vh]">
                <div class="animate-pulse space-y-6 w-full max-w-4xl">
                    <div class="h-8 w-3/4 bg-gray-200 rounded-lg"></div>
                    <div class="h-4 w-1/2 bg-gray-200 rounded"></div>
                    <div class="h-96 w-full bg-gray-200 rounded-xl"></div>
                    <div class="space-y-3">
                        <div class="h-4 w-full bg-gray-200 rounded"></div>
                        <div class="h-4 w-5/6 bg-gray-200 rounded"></div>
                        <div class="h-4 w-4/6 bg-gray-200 rounded"></div>
                    </div>
                </div>
            </div>

            <template v-else>


                <!-- Hero Section -->
                <div class="container mx-auto px-4 pb-8 pt-20">
                    <div class="max-w-5xl mx-auto">

                        <button @click="router.visit('/blog')"
                            class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors group">
                            <ArrowLeft :size="20"
                                class="mr-2 transform group-hover:-translate-x-1 transition-transform" />
                            Back to Blog
                        </button>

                        <!-- Title -->
                        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                            {{ blog.title }}
                        </h1>

                        <!-- Meta information -->
                        <div class="flex flex-wrap items-center gap-6 text-gray-600 mb-8">
                            <div class="flex items-center">
                                <User :size="18" class="mr-2" />
                                <span class="font-medium">{{ blog.author }}</span>
                            </div>
                            <div class="flex items-center">
                                <Calendar :size="18" class="mr-2" />
                                <span>{{ new Date(blog.published_at).toLocaleDateString('en-US', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric'
                                }) }}</span>
                            </div>
                            <div class="flex items-center">
                                <Clock :size="18" class="mr-2" />
                                <span>{{ readingTime }} min read</span>
                            </div>
                        </div>



                        <!-- Featured Image -->
                        <div class="relative mb-12 group">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl blur opacity-10 group-hover:opacity-20 transition-opacity">
                            </div>
                            <img :src="blog.featured_image" :alt="blog.title"
                                class="relative w-full h-[400px] md:h-[500px] object-cover rounded-2xl shadow-2xl transform group-hover:scale-[1.02] transition-transform duration-500" />
                            <div
                                class="absolute inset-0 bg-black/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="container mx-auto px-4 pb-20">
                    <div class="max-w-5xl mx-auto">
                        <div class="grid grid-cols-1 lg:grid-cols-7 gap-8">
                            <!-- Main Content -->
                            <div class="lg:col-span-5">
                                <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border border-gray-100">
                                    <div
                                        class="prose prose-md prose-gray max-w-none
                                               prose-headings:text-gray-900 prose-headings:font-bold
                                               prose-h1:text-4xl prose-h2:text-3xl prose-h3:text-2xl
                                               prose-p:text-gray-700 prose-p:leading-relaxed
                                               prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline
                                               prose-strong:text-gray-900 prose-strong:font-semibold
                                               prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 prose-blockquote:p-4 prose-blockquote:rounded-r-lg
                                               prose-code:bg-gray-100 prose-code:px-2 prose-code:py-1 prose-code:rounded prose-code:text-sm
                                               prose-img:rounded-xl prose-img:shadow-lg
                                               [--tw-prose-spacing:1.25rem] prose-p:mb-[0.1em] prose-h1:mb-[0.2em] prose-h2:mb-[0.7em] prose-h3:mb-[0.7em] prose-ul:mb-[0.7em] prose-ol:mb-[0.7em] prose-blockquote:mb-[0.7em]"
                                        v-html="blog.content"
                                        style="--tw-prose-spacing:1.25rem;"
                                    >
                                    </div>

                                    <!-- Tags -->
                                    <!-- <div class="mt-12 pt-8 border-t border-gray-200">
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">Architecture</span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">Design</span>
                                            <span
                                                class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">Sustainability</span>
                                        </div>
                                    </div> -->
                                </div>
                            </div>

                            <!-- Sidebar -->
                            <div class="lg:col-span-2">
                                <div class="sticky top-8 space-y-6">



                                    <!-- Related Articles -->
                                    <div v-if="relatedBlogs && relatedBlogs.length > 0"
                                        class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 mb-12">
                                        <h3 class="font-semibold text-gray-900 mb-4">Related Articles</h3>
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

                                    <!-- Next and Previous Blogs -->
                                    <div v-if="prevBlog || nextBlog" class="grid grid-cols-1 gap-8">
                                        <!-- Previous Article -->
                                        <div v-if="prevBlog" class="group">
                                            <Link :href="`/blog/${prevBlog.slug}`" class="block transition-shadow">
                                            <p class="text-sm text-gray-500 mb-2">Previous Article</p>
                                            <h3
                                                class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                {{ prevBlog.title }}
                                            </h3>
                                            </Link>
                                        </div>

                                        <!-- Next Article -->
                                        <div v-if="nextBlog" class="group">
                                            <Link :href="`/blog/${nextBlog.slug}`" class="block transition-shadow">
                                            <p class="text-sm text-gray-500 mb-2">Next Article</p>
                                            <h3
                                                class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">
                                                {{ nextBlog.title }}
                                            </h3>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </template>
        </main>
    </WebsiteLayout>
</template>