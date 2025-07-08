<template>
  <section class="relative h-screen overflow-hidden bg-udc-gradient">
    <!-- Background Slider -->
    <div class="absolute inset-0">
      <div
        v-for="(slide, index) in slides"
        :key="index"
        :class="`absolute inset-0 transition-opacity duration-1000 ${
          currentSlide === index ? 'opacity-100' : 'opacity-0'
        }`"
      >
        <div class="absolute inset-0 bg-udc-dark/70 z-10"></div>
        <img
          :src="slide.image"
          :alt="slide.title"
          class="w-full h-full object-cover"
        />
      </div>
    </div>

    <!-- Content -->
    <div class="container mx-auto px-4 h-full flex flex-col justify-center relative z-20 text-udc-gold">
      <div class="max-w-3xl">
        <div
          v-for="(slide, index) in slides"
          :key="index"
          :class="`transition-all duration-1000 transform ${
            currentSlide === index
              ? 'opacity-100 translate-y-0'
              : 'opacity-0 translate-y-8'
          }`"
          :style="{ display: currentSlide === index ? 'block' : 'none' }"
        >
          <h1 class="text-5xl md:text-7xl font-light tracking-tight mb-4 text-udc-gold">
            {{ slide.title }}
          </h1>
          <p class="text-xl md:text-2xl text-udc-light mb-8">
            {{ slide.subtitle }}
          </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
          <Link
            href="/projects"
            class="bg-udc-gold text-udc-dark px-8 py-3 inline-block text-center hover:bg-yellow-300 transition-colors"
          >
            View Projects
          </Link>
          <Link
            href="/contact"
            class="border border-udc-gold text-udc-gold px-8 py-3 inline-block text-center hover:bg-udc-gold hover:text-udc-dark transition-colors"
          >
            Get in Touch
          </Link>
        </div>
      </div>
    </div>

    <!-- Slide Indicators -->
    <div class="absolute bottom-16 left-1/2 transform -translate-x-1/2 z-20 flex space-x-3">
      <button
        v-for="(_, index) in slides"
        :key="index"
        @click="setCurrentSlide(index)"
        :class="`w-3 h-3 rounded-full transition-all ${
          currentSlide === index ? 'bg-udc-gold scale-100' : 'bg-udc-gold/40 scale-75'
        }`"
        :aria-label="`Go to slide ${index + 1}`"
      />
    </div>

    <!-- Scroll Down Indicator -->
    <button
      @click="scrollToContent"
      class="absolute bottom-8 right-12 z-20 text-udc-gold/80 hover:text-udc-gold animate-bounce"
      aria-label="Scroll down"
    >
      <ChevronDown :size="30" />
    </button>
  </section>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ChevronDown } from 'lucide-vue-next'

const currentSlide = ref(0)

const slides = [
  {
    title: "Universal Design & Construction Ltd",
    subtitle: "We are a dynamic architectural design and construction firm with a team of professionals . ",
    image: "/carousel-1-2-scaled-1.jpg",
  },
  {
    title: "We building for a better future",
    subtitle: "With a focus on innovation and sustainability, we bring dreams to life. Engineering,",
    image: "/Cost-Estimation (1).webp",
  },
  {
    title: "Trusted by Rwanda's Leading Institutions",
    subtitle: "Award-winning expertise in architecture, engineering, and project management",
    image: "/Land.webp",
  }
]

let interval

onMounted(() => {
  interval = setInterval(() => {
    currentSlide.value = (currentSlide.value + 1) % slides.length
  }, 6000)
})

onUnmounted(() => {
  if (interval) {
    clearInterval(interval)
  }
})

const setCurrentSlide = (index) => {
  currentSlide.value = index
}

const scrollToContent = () => {
  window.scrollTo({
    top: window.innerHeight,
    behavior: 'smooth'
  })
}
</script>