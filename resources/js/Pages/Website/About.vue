<script setup>
import { Head } from '@inertiajs/vue3'
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import AboutHero from '@/Components/Website/about/AboutHero.vue'
import MissionValues from '@/Components/Website/about/MissionValues.vue'
import Timeline from '@/Components/Website/about/Timeline.vue'
import Stats from '@/Components/Website/about/Stats.vue'
import TeamSection from '@/Components/Website/about/TeamSection.vue'
import ContactCTA from '@/Components/Website/ContactCTA.vue'
import teamData from '@/data/teamData.js'
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
              The team is led and guided by the Managing Director, Mutuzo Remy also the Principal Architect of UDC Africa. Architect Kayumba Eudes is arguably one of the leading Architects in the region premised on the fact that he has dealt and spearheaded state of the art and life-changing projects within the region. Along with holding a Postgraduate in Architecture, he possesses a Masters in Building and Urban Design from the University College of London. He has over 20 years of professional expertise in the field of Design and construction.
            </p>
            <p class="leading-relaxed text-sm">
              He is a member with Rwanda Institute of Architects, Institute of Rwanda Real Property Valuers & Arbitrator with Kigali International Arbitration Center. He has held numerous positions in the field of Architecture in Rwanda and Africa in general. Chairman- Architects Registration Board, President, Rwanda Institute of Architects, Vice Chairman East African Region, African Union of Architects and Chairman, Rwanda Green Building Organization.
            </p>
          </div>
        </div>
      </div>

      <MissionValues />
      <Timeline />
      <Stats />
      <TeamSection :team="teamData" />
      <ContactCTA />
    </main>
  </WebsiteLayout>
</template>