<template>
  <div class="mt-10">
    <h2 class="text-2xl font-medium mb-6">Project Gallery</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div
        v-for="(image, index) in images"
        :key="index"
        class="cursor-pointer overflow-hidden"
        @click="openLightbox(index)"
      >
        <img
          :src="image"
          :alt="`Project view ${index + 1}`"
          class="w-full h-full object-cover transition-transform hover:scale-105 duration-300"
        />
      </div>
    </div>

    <!-- Lightbox -->
    <div
      v-if="lightboxOpen"
      class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center"
      @click="closeLightbox"
    >
      <button
        class="absolute top-6 right-6 text-white p-2 hover:opacity-80 z-10"
        @click.stop="closeLightbox"
        aria-label="Close lightbox"
      >
        <XIcon :size="24" />
      </button>

      <button
        class="absolute left-6 text-white p-4 hover:opacity-80 z-10"
        @click.stop="goToPrevious"
        aria-label="Previous image"
      >
        <ChevronLeftIcon :size="32" />
      </button>

      <div class="relative max-w-5xl max-h-[80vh] mx-auto">
        <img
          :src="images[currentImageIndex]"
          :alt="`Project view ${currentImageIndex + 1}`"
          class="max-w-full max-h-[80vh] object-contain"
          @click.stop
        />
      </div>

      <button
        class="absolute right-6 text-white p-4 hover:opacity-80 z-10"
        @click.stop="goToNext"
        aria-label="Next image"
      >
        <ChevronRightIcon :size="32" />
      </button>

      <div class="absolute bottom-6 text-white text-sm">
        {{ currentImageIndex + 1 }} / {{ images.length }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'

// You can use lucide-vue or your own icon components
import { X as XIcon, ChevronLeft as ChevronLeftIcon, ChevronRight as ChevronRightIcon } from 'lucide-vue-next' // or 'lucide-vue' if you use that

// Props
const props = defineProps({
  images: {
    type: Array,
    required: true,
  },
})

const lightboxOpen = ref(false)
const currentImageIndex = ref(0)

function openLightbox(index) {
  currentImageIndex.value = index
  lightboxOpen.value = true
  document.body.style.overflow = 'hidden'
}

function closeLightbox() {
  lightboxOpen.value = false
  document.body.style.overflow = 'auto'
}

function goToPrevious(e) {
  if (e) e.stopPropagation()
  currentImageIndex.value =
    currentImageIndex.value === 0
      ? props.images.length - 1
      : currentImageIndex.value - 1
}

function goToNext(e) {
  if (e) e.stopPropagation()
  currentImageIndex.value =
    currentImageIndex.value === props.images.length - 1
      ? 0
      : currentImageIndex.value + 1
}

// Keyboard navigation
function handleKeyDown(e) {
  if (!lightboxOpen.value) return

  if (e.key === 'Escape') {
    closeLightbox()
  } else if (e.key === 'ArrowLeft') {
    goToPrevious()
  } else if (e.key === 'ArrowRight') {
    goToNext()
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown)
})

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeyDown)
})

// Ensure body scroll is reset if component is destroyed while lightbox is open
watch(lightboxOpen, (val) => {
  if (!val) {
    document.body.style.overflow = 'auto'
  }
})
</script>