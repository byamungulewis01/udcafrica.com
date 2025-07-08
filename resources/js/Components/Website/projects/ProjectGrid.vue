<script setup>
import { defineProps } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  projects: {
    type: Array,
    required: true,
    default: () => []
  }
})
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    <Link
      v-for="project in projects"
      :key="project.id"
      :href="`/projects/${project.id}`"
      class="group"
    >
      <div class="relative overflow-hidden h-[400px] mb-4">
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
    <div v-if="!projects.length" class="col-span-full text-center text-gray-400 py-12">
      No projects found for this category.
    </div>
  </div>
</template>