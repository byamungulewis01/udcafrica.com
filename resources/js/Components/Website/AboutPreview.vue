<template>
  <section class="py-24">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
        <div>
          <div class="relative">
            <img
              src="/about1.jpg"
              alt="Team of architects"
              class="w-full h-[600px] object-cover"
            />
            <div class="absolute bottom-0 right-0 transform translate-x-6 translate-y-6 w-36 h-36 bg-udc-dark"></div>
          </div>
        </div>

        <div class="max-w-lg">
          <h2 class="text-4xl font-light mb-6 tracking-tight">
            We Provide Cost Effective <br />Solution For You
          </h2>
          <p class="text-gray-600 leading-relaxed mb-6">
            We focus on covering and meeting the needs and demands, to create living spaces, using certain tools and especially, creativity. Worldwide services
            We deal with the design, construction, and maintenance of the physical and naturally built environment.
          </p>
          <p class="text-gray-600 leading-relaxed mb-8">
            We are a dynamic architectural design and construction firm with a team of professionals who combine expertise and experience to create stunning, functional structures. We prioritize your collaboration and aim to create spaces that truly reflect your vision and dreams.
          </p>
          <div class="space-y-6">
            <div class="grid grid-cols-2 gap-6">
              <div>
                <div class="text-4xl font-light text-black mb-2">7+</div>
                <div class="text-gray-600">Years of Experience</div>
              </div>
              <div>
                <div class="text-4xl font-light text-black mb-2">200+</div>
                <div class="text-gray-600">Projects Completed</div>
              </div>
            </div>

            <Link
              href="/about"
              class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity"
            >
              Learn More About Us
              <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
            </Link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
</script>