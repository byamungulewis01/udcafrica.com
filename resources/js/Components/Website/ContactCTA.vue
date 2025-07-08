<template>
  <section class="py-24 bg-udc-dark text-white">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-4xl font-light mb-6 tracking-tight">
          Ready to Transform Your Vision Into Reality?
        </h2>
        <p class="text-xl text-white/80 mb-10 leading-relaxed">
          Let's discuss your project. Our team of experts is ready to help you create
          spaces that inspire, function beautifully, and stand the test of time.
        </p>
        <Link
          href="/contact"
          class="bg-udc-gold text-udc-dark px-10 py-4 inline-flex items-center hover:bg-opacity-90 transition-colors group"
        >
          Contact Us
          <ArrowRight :size="18" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
        </Link>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
</script>