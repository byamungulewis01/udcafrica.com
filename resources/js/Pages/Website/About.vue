<script setup>
import { Head } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import AboutHero from '@/Components/Website/about/AboutHero.vue'
import MissionValues from '@/Components/Website/about/MissionValues.vue'
import Timeline from '@/Components/Website/about/Timeline.vue'
import Stats from '@/Components/Website/about/Stats.vue'
import TeamSection from '@/Components/Website/about/TeamSection.vue'
import ContactCTA from '@/Components/Website/ContactCTA.vue'
</script>

<template>
    <WebsiteLayout>

        <Head title="About Us" />
        <main class="bg-udc-light">
            <AboutHero />

            <div class="container mx-auto px-4 py-24">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-4xl font-light mb-8 tracking-tight text-udc-dark">Our Story</h2>
                    <div class="space-y-6 text-udc-dark text-base">
                        <p class="leading-relaxed">
                            Universal design and construction (UDC) Ltd was founded to bridge the gap between design,
                            engineering, and construction; offering a fully integrated approach to building delivery.
                            What started as a collaboration between industry professionals is growing into a trusted
                            multidisciplinary company serving residential, commercial, and institutional projects across
                            Rwanda.
                        </p>
                        <p class="leading-relaxed">
                            We’re driven by a simple purpose: to build spaces that serve people, uplift communities, and
                            endure over time. With deep local insight and a commitment to quality, we bring creativity,
                            precision, and purpose to every project we take on.

                        </p>
                    </div>
                </div>
            </div>

            <MissionValues />
            <!-- <Timeline />
            <Stats /> -->
            <TeamSection />
            <ContactCTA />
        </main>
    </WebsiteLayout>
</template>
