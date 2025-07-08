<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

const counts = ref({
  projects: 0,
  ongoing: 0,
  clients: 0,
  years: 0
})

const targets = {
  projects: 300,
  ongoing: 15,
  clients: 100,
  years: 10
}

let timer = null

onMounted(() => {
  const duration = 2000 // 2 seconds
  const steps = 50
  const interval = duration / steps

  let currentStep = 0

  function incrementCounts(step) {
    counts.value.projects = Math.min(Math.floor((targets.projects * step) / steps), targets.projects)
    counts.value.ongoing = Math.min(Math.floor((targets.ongoing * step) / steps), targets.ongoing)
    counts.value.clients = Math.min(Math.floor((targets.clients * step) / steps), targets.clients)
    counts.value.years = Math.min(Math.floor((targets.years * step) / steps), targets.years)
  }

  timer = setInterval(() => {
    currentStep++
    if (currentStep <= steps) {
      incrementCounts(currentStep)
    } else {
      clearInterval(timer)
    }
  }, interval)
})

onBeforeUnmount(() => {
  if (timer) clearInterval(timer)
})
</script>

<template>
  <section class="py-20 bg-udc-dark border-t">
    <div class="container mx-auto px-4 ">
      <h3 class="text-4xl font-light mb-6 tracking-tight text-center text-udc-gold">SIGNIFICANT MILESTONES</h3>

      <div class="mb-10">
        <p class="text-udc-gold leading-relaxed text-center max-w-4xl mx-auto">
          UDC Africa has made paper presentations of key staff on architecture and the environment; Awarded a contract to design an environmentally sound system; Consulted widely by the Government of Rwanda
        </p>
      </div>

      <!-- Statistics Grid -->
      <div class="flex flex-col md:flex-row justify-between space-y-6 md:space-y-0">
        <div class="flex-1 relative group">
          <div class="absolute inset-0 bg-udc-gold/10 transform skew-x-3 -skew-y-3 transition-transform group-hover:skew-x-6 group-hover:-skew-y-6"></div>
          <div class="relative p-8 text-center">
            <span class="block text-5xl font-light text-udc-gold mb-3">{{ counts.projects }}+</span>
            <span class="text-udc-gold/80 uppercase tracking-wider text-sm">Complete Projects</span>
          </div>
        </div>

        <div class="w-px h-20 bg-udc-gold/20 hidden md:block self-center"></div>

        <div class="flex-1 relative group">
          <div class="absolute inset-0 bg-udc-gold/10 transform skew-x-3 -skew-y-3 transition-transform group-hover:skew-x-6 group-hover:-skew-y-6"></div>
          <div class="relative p-8 text-center">
            <span class="block text-5xl font-light text-udc-gold mb-3">{{ counts.ongoing }}+</span>
            <span class="text-udc-gold/80 uppercase tracking-wider text-sm">Ongoing Projects</span>
          </div>
        </div>

        <div class="w-px h-20 bg-udc-gold/20 hidden md:block self-center"></div>

        <div class="flex-1 relative group">
          <div class="absolute inset-0 bg-udc-gold/10 transform skew-x-3 -skew-y-3 transition-transform group-hover:skew-x-6 group-hover:-skew-y-6"></div>
          <div class="relative p-8 text-center">
            <span class="block text-5xl font-light text-udc-gold mb-3">{{ counts.clients }}+</span>
            <span class="text-udc-gold/80 uppercase tracking-wider text-sm">Happy Clients</span>
          </div>
        </div>
        <div class="w-px h-20 bg-udc-gold/20 hidden md:block self-center"></div>

        <div class="flex-1 relative group">
          <div class="absolute inset-0 bg-udc-gold/10 transform skew-x-3 -skew-y-3 transition-transform group-hover:skew-x-6 group-hover:-skew-y-6"></div>
          <div class="relative p-8 text-center">
            <span class="block text-5xl font-light text-udc-gold mb-3">{{ counts.years }}+</span>
            <span class="text-udc-gold/80 uppercase tracking-wider text-sm">Years of Experience</span>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>