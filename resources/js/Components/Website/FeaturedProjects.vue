<template>
  <section class="py-24">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
        <div class="max-w-xl mb-8 md:mb-0">
          <h2 class="text-4xl font-light mb-6 tracking-tight">Featured Projects</h2>
          <p class="text-gray-600 leading-relaxed">
            Explore our most innovative and impactful architectural designs. These featured
            projects showcase our commitment to excellence, sustainability, and cutting-edge
            design solutions.
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

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <Link
          v-for="project in featuredProjects"
          :key="project.id"
          :href="`/projects/${project.id}`"
          class="group"
        >
          <div class="relative overflow-hidden h-[500px] mb-4">
            <img
              :src="project.coverImage"
              :alt="project.title"
              class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
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
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
import projectsData from '@/data/projectsData.js'

// Get only featured projects
const featuredProjects = computed(() => {
  return projectsData
    .filter(project => project.featured)
    .slice(0, 3)
})
</script>