<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue'

// Timeline events data
const timelineEvents = [
  {
    year: "2005",
    title: "Foundation",
    description: "ARCHIQ was founded in New York by three partners with a vision to create innovative, sustainable architecture."
  },
  {
    year: "2008",
    title: "First Major Project",
    description: "Completed our first UDC Africa project, the Riverside Cultural Center, which won several design awards."
  },
  {
    year: "2012",
    title: "International Expansion",
    description: "Opened our second office in Copenhagen, Denmark, expanding our reach into European markets."
  },
  {
    year: "2015",
    title: "Sustainability Focus",
    description: "Launched our sustainability initiative, committing to carbon-neutral designs in all future projects."
  },
  {
    year: "2018",
    title: "Major Recognition",
    description: "Received the International Architecture Award for our innovative approach to urban residential design."
  },
  {
    year: "2022",
    title: "Digital Innovation",
    description: "Pioneered the integration of virtual reality and parametric design into our architectural practice."
  },
  {
    year: "2025",
    title: "Today",
    description: "Continuing to push boundaries with over 200 completed projects across 15 countries worldwide."
  }
]

// Use an array of refs, one for each event
import { onBeforeMount } from 'vue'
const visibleEvents = ref([])
const timelineRefs = []

let observer = null

onMounted(async () => {
  await nextTick()
  // Only create observer if window.IntersectionObserver is available
  if (typeof window !== 'undefined' && 'IntersectionObserver' in window) {
    observer = new window.IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const index = timelineRefs.findIndex(ref => ref === entry.target)
            if (index !== -1 && !visibleEvents.value.includes(index)) {
              visibleEvents.value.push(index)
            }
          }
        })
      },
      { threshold: 0.3 }
    )

    timelineRefs.forEach((ref) => {
      if (ref) observer.observe(ref)
    })
  }
})

onBeforeUnmount(() => {
  if (observer) observer.disconnect()
})
</script>

<template>
  <section class="py-24 bg-white">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-light mb-6 tracking-tight">Our Journey</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
          From our humble beginnings to becoming a globally recognized architecture firm,
          our journey has been defined by creativity, resilience, and a commitment to excellence.
        </p>
      </div>
      <div class="relative">
        <!-- Timeline Line -->
        <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-gray-300"></div>
        <!-- Timeline Events -->
        <div class="relative">
          <div
            v-for="(event, index) in timelineEvents"
            :key="index"
            :ref="el => { if (el) timelineRefs[index] = el }"
            :class="[
              'flex items-center mb-16 last:mb-0 transition-opacity duration-700',
              index % 2 === 0 ? 'flex-row' : 'flex-row-reverse',
              visibleEvents.includes(index) ? 'opacity-100' : 'opacity-0'
            ]"
          >
            <div class="w-1/2 px-8">
              <div :class="index % 2 === 0 ? 'text-right' : 'text-left'">
                <span class="text-4xl font-light text-gray-300">{{ event.year }}</span>
                <h3 class="text-xl font-medium mt-2 mb-3">{{ event.title }}</h3>
                <p class="text-gray-600">{{ event.description }}</p>
              </div>
            </div>
            <div
              :class="[
                'absolute left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-black border-4 border-white transition-all duration-500',
                visibleEvents.includes(index) ? 'scale-100' : 'scale-0'
              ]"
            ></div>
            <div class="w-1/2"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>