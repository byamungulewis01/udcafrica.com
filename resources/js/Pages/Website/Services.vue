<script setup>
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import {
    Calculator,
    Ruler,
    HardHat,
    DraftingCompass,
    Landmark,
} from 'lucide-vue-next'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'

const services = ref([
    {
        icon: DraftingCompass, // More specific for architectural design
        title: "Architectural Design",
        description: "Comprehensive architectural design services for residential, commercial, and institutional buildings and more.",
        features: [
            "Conceptual Design & Planning",
            "3D Modeling & Visualization",
            "Construction Documentation"
        ]
    },
    {
        icon: Landmark, // Better represents structural engineering
        title: "Structural Engineering",
        description: "Integrated engineering solutions that ensure the structural integrity, functionality, and longevity of buildings.",
        features: [
            "Structural Design & Analysis",
            "Foundation & Framing Systems",
            "Building Services Coordination"
        ]
    },
    {
        icon: Ruler, // More relevant for surveying/measuring
        title: "Land Surveying",
        description: "Precision surveying for accurate site planning and efficient building development to save your project from risks.",
        features: [
            "Site & Topographic Surveys",
            "Building Layout & Set-Out",
            "As-Built Surveys"
        ]
    },
    {
        icon: Calculator, // This one is already perfect
        title: "Cost Management",
        description: "Professional cost planning and control to ensure projects are delivered on budget and with optimal value.",
        features: [
            "Preliminary Cost Estimates",
            "Bills of Quantities (BoQ)",
            "Value Engineering & Cost Control"
        ]
    },
    {
        icon: HardHat, // More specific for construction management
        title: "Construction Management",
        description: "Full-service construction oversight for smooth execution, quality assurance, and timely project delivery.",
        features: [
            "Construction Supervision",
            "Contractor Coordination",
            "Progress Monitoring & Reporting"
        ]
    }
])
defineProps({
    seo: Object,
})
</script>
<template>
    <WebsiteLayout>

        <Head :title="seo.title" />


        <div class="container mx-auto px-4 py-24">
            <div class="max-w-4xl mx-auto text-center mb-16">
                <h1 class="text-5xl font-light mb-6 tracking-tight">Our Services</h1>
                <p class="text-lg text-gray-600 leading-relaxed">
                    We offer a full spectrum of building design and construction services; all under one roof.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(service, index) in services" :key="index"
                    class="bg-white p-8 hover:shadow-lg transition-all duration-300 group cursor-pointer">
                    <div class="mb-6 text-black group-hover:text-udc-gold transition-colors">
                        <component :is="service.icon" :size="32" />
                    </div>
                    <h3 class="text-xl font-medium mb-4 text-udc-dark">{{ service.title }}</h3>
                    <p class="text-gray-600 leading-relaxed text-sm mb-6">{{ service.description }}</p>
                    <ul class="space-y-2">
                        <li v-for="(feature, featureIndex) in service.features" :key="featureIndex"
                            class="flex items-start text-sm text-gray-700">
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
                    <h2 class="text-3xl font-light mb-6 tracking-tight">Why Choose UDC Africa?</h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        We go beyond construction; we create spaces that serve, inspire, and endure. Choosing us means
                        partnering with a team that brings clarity, integrity, and innovation to every stage of your
                        building project.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h3 class="text-xl font-medium mb-4 text-udc-dark">Our Approach</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Understanding the Vision</h4>
                                    <p class="text-gray-600 text-sm">Every project begins with listening to your goals,
                                        site conditions, users, and community context. </p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Collaborative Design</h4>
                                    <p class="text-gray-600 text-sm">Our team works together from day one; blending
                                        architecture, engineering, and cost planning.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Technical Excellence</h4>
                                    <p class="text-gray-600 text-sm">We bring precision and expertise to every drawing,
                                        model, and detail.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Smart Cost & Time Management</h4>
                                    <p class="text-gray-600 text-sm">With in-house cost managers, we monitor budgets
                                        closely and adjust strategies proactively.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Seamless Execution</h4>
                                    <p class="text-gray-600 text-sm">During construction, we oversee progress,
                                        coordinate teams, and uphold quality control.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Enduring Relationships</h4>
                                    <p class="text-gray-600 text-sm">We stand by our work and available to support
                                        because we take every project as a partnership.</p>
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
                                    <h4 class="font-medium mb-1">Consultation & Needs Assessment</h4>
                                    <p class="text-gray-600 text-sm">We begin by understanding your goals, budget, site,
                                        and vision.
                                    </p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Site Analysis & Feasibility</h4>
                                    <p class="text-gray-600 text-sm">Our team conducts thorough site assessments and
                                        feasibility studies.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Concept Design</h4>
                                    <p class="text-gray-600 text-sm">We translate your vision into initial sketches and
                                        layouts.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Detailed Design & Documentation</h4>
                                    <p class="text-gray-600 text-sm">We refine the design and prepare full
                                        architectural, engineering drawings and estimates.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Construction & Supervision</h4>
                                    <p class="text-gray-600 text-sm">We manage the building process from groundbreaking
                                        to handover.</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <span class="w-1.5 h-1.5 bg-udc-gold rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <div>
                                    <h4 class="font-medium mb-1">Handover & Support</h4>
                                    <p class="text-gray-600 text-sm">Once construction is complete, we carry out final
                                        inspections and deliver documentation.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </WebsiteLayout>
</template>
