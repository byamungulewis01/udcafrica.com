<template>
  <section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
        <div class="max-w-xl mb-8 md:mb-0">
          <h2 class="text-4xl font-light mb-6 tracking-tight">Latest Articles</h2>
          <p class="text-gray-600 leading-relaxed">
            Insights, inspiration, and ideas from our team of architects and designers. Explore our
            latest thoughts on architecture, design trends, and sustainable building practices.
          </p>
        </div>
        <Link
          href="/blog"
          class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity"
        >
          View All Articles
          <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
        </Link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <Link
          v-for="post in latestPosts"
          :key="post.id"
          :href="`/blog/${post.id}`"
          class="group"
        >
          <div class="bg-white overflow-hidden">
            <div class="relative h-60 overflow-hidden">
              <img
                :src="post.coverImage"
                :alt="post.title"
                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
              />
            </div>
            <div class="p-6">
              <span class="text-sm text-gray-500">{{ post.date }}</span>
              <h3 class="text-xl font-medium mb-3 group-hover:text-gray-700 transition-colors">
                {{ post.title }}
              </h3>
              <p class="text-gray-600 mb-4 line-clamp-2">
                {{ post.excerpt }}
              </p>
              <span class="inline-flex items-center text-gray-900 font-medium group-hover:opacity-70 transition-opacity">
                Read More
                <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
              </span>
            </div>
          </div>
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
import blogData from '@/data/blogData.js'

const latestPosts = computed(() => blogData.slice(0, 3))
</script>