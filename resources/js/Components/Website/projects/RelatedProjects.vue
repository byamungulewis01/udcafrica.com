<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
  currentProjectId: {
    type: [String, Number],
    required: true
  },
  category: {
    type: String,
    required: true
  },
  projects: {
    type: Array,
    required: true,
    default: () => []
  }
})

// Compute related projects: same category, not current, max 3
const relatedProjects = computed(() => {
  return props.projects
    .filter(
      project =>
        project.category === props.category &&
        project.id !== props.currentProjectId
    )
    .slice(0, 3)
})
</script>

<template>
  <section v-if="relatedProjects.length" class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-light mb-12 tracking-tight">Related Projects</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <Link
          v-for="project in relatedProjects"
          :key="project.id"
          :href="`/projects/${project.id}`"
          class="group"
        >
          <div class="relative overflow-hidden h-[300px] mb-4">
            <img
              :src="project.coverImage"
              :alt="project.title"
              class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
            />
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