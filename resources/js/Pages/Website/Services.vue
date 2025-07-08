<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import { Building2, Wrench, Map, ClipboardList, Calculator, PieChart } from 'lucide-vue-next'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'


const services = ref([
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
  },
  {
    icon: ClipboardList,
    title: "Project Management",
    description: "End-to-end project management ensuring timely delivery, cost control, and quality assurance for all project phases.",
    features: [
      "Timeline Management",
      "Quality Assurance",
      "Risk Assessment"
    ]
  },
  {
    icon: PieChart,
    title: "Property Valuation",
    description: "Professional valuation services for land, buildings, and property portfolios, supporting investment and development decisions.",
    features: [
      "Market Analysis",
      "Investment Consulting",
      "Portfolio Assessment"
    ]
  },
  {
    icon: Calculator,
    title: "Quantity Surveying",
    description: "Accurate cost estimation, tendering, and financial management to maximize value and control project budgets.",
    features: [
      "Cost Estimation",
      "Budget Control",
      "Financial Management"
    ]
  }
])
</script>

<template>
    <WebsiteLayout>
  <Head title="Services" />

  <div class="container mx-auto px-4 py-24">
    <div class="max-w-4xl mx-auto text-center mb-16">
      <h1 class="text-5xl font-light mb-6 tracking-tight">Our Services</h1>
      <p class="text-lg text-gray-600 leading-relaxed">
        We offer a comprehensive range of architectural and design services,
        tailored to meet the unique needs of each client and project.
      </p>
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

  <!-- Additional Sections -->
  <section class="py-24 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto text-center mb-16">
        <h2 class="text-3xl font-light mb-6 tracking-tight">Why Choose Us</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
          With decades of experience and a commitment to excellence, we deliver exceptional results for every project.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <div class="bg-white p-8 rounded-lg shadow-md">
          <h3 class="text-xl font-medium mb-4 text-udc-dark">Our Approach</h3>
          <ul class="space-y-4">
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Client-Centric Design</h4>
                <p class="text-gray-600 text-sm">We prioritize your vision and requirements in every design decision.</p>
              </div>
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Sustainable Solutions</h4>
                <p class="text-gray-600 text-sm">Environmentally conscious designs that reduce environmental impact.</p>
              </div>
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Innovative Technology</h4>
                <p class="text-gray-600 text-sm">Utilizing cutting-edge tools and methods for optimal results.</p>
              </div>
            </li>
          </ul>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
          <h3 class="text-xl font-medium mb-4 text-udc-dark">Our Process</h3>
          <ul class="space-y-4">
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Initial Consultation</h4>
                <p class="text-gray-600 text-sm">Understanding your needs and project requirements.</p>
              </div>
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Design Development</h4>
                <p class="text-gray-600 text-sm">Creating detailed designs and solutions.</p>
              </div>
            </li>
            <li class="flex items-start">
              <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
              <div>
                <h4 class="font-medium mb-1">Implementation</h4>
                <p class="text-gray-600 text-sm">Executing the project with precision and care.</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</WebsiteLayout>
</template>