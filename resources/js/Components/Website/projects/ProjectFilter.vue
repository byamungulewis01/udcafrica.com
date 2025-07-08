<script setup>
import { defineProps, defineEmits } from 'vue'

const props = defineProps({
  categories: {
    type: Array,
    required: true
  },
  activeFilter: {
    type: String,
    required: true
  }
})

const emit = defineEmits(['update:activeFilter'])

function setActiveFilter(category) {
  emit('update:activeFilter', category)
}
</script>

<template>
  <div class="flex flex-wrap justify-center mb-12 space-x-1 md:space-x-4">
    <button
      v-for="category in categories"
      :key="category"
      @click="setActiveFilter(category)"
      class="px-6 py-2 mb-2 transition-colors"
      :class="activeFilter === category
        ? 'bg-udc-dark text-white'
        : 'bg-yellow-100 text-udc-dark hover:bg-yellow-200'"
    >
      {{ category }}
    </button>
  </div>
</template>