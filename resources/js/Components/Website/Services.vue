<template>
  <section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
        <div class="max-w-xl mb-8 md:mb-0">
          <h2 class="text-4xl font-light mb-6 tracking-tight">Our Services</h2>
          <p class="text-gray-600 leading-relaxed">
            We offer a comprehensive range of architectural and design services,
            tailored to meet the unique needs of each client and project.
          </p>
        </div>
        <Link
          href="/services"
          class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity"
        >
          View All Services
          <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
        </Link>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="(service, index) in services"
          :key="index"
          class="bg-white p-8 hover:shadow-lg transition-all duration-300 group cursor-pointer"
        >
          <div class="mb-6 text-black group-hover:text-udc-gold transition-colors">
            <component :is="service.icon" :size="32" />
          </div>

          <h3 class="text-xl font-medium mb-4 text-udc-dark">{{ service.title }}</h3>

          <p class="text-gray-600 leading-relaxed text-sm mb-6">{{ service.description }}</p>

          <ul class="space-y-2">
            <li
              v-for="(feature, featureIndex) in service.features"
              :key="featureIndex"
              class="flex items-start text-sm text-gray-700"
            >
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              {{ feature }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRight, Building2, Wrench, Map } from 'lucide-vue-next'

const services = [
  {
    icon: Building2,
    title: "Architecture",
    description: "Comprehensive architectural design services for residential, commercial, and institutional projects, from concept to completion.",
    features: [
      "Conceptual Design & Planning",
      "3D Modeling & Visualization",
      "Construction Documentation"
    ]
  },
  {
    icon: Wrench,
    title: "Engineering",
    description: "Integrated engineering solutions covering structural, civil, and MEP disciplines for efficient and sustainable buildings.",
    features: [
      "Structural Engineering",
      "MEP Systems Design",
      "Sustainability Solutions"
    ]
  },
  {
    icon: Map,
    title: "Master Planning",
    description: "Strategic planning and design for urban and regional development, including zoning, infrastructure, and community engagement.",
    features: [
      "Urban Development Planning",
      "Infrastructure Design",
      "Community Engagement"
    ]
  }
]
</script>