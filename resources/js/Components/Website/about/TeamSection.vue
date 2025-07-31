<template>
  <section class="py-24">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto text-center mb-16">
        <h2 class="text-4xl font-light mb-6 tracking-tight">Our Team</h2>
        <p class="text-lg text-gray-600 leading-relaxed">
          Meet the talented architects, designers, and professionals who bring our
          projects to life. Our diverse team combines creativity, technical expertise,
          and a shared passion for exceptional architecture.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <div
          v-for="member in team"
          :key="member.id"
          class="group"
        >
          <div class="relative overflow-hidden mb-4">
            <img
              :src="member.image"
              :alt="member.name"
              class="w-full aspect-[3/4] object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500"
            />
          </div>
          <h3 class="text-xl font-medium mb-1">{{ member.name }}</h3>
          <p class="text-gray-600">{{ member.role }}</p>
        </div>
      </div>

    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'
import team from '@/data/teamData.js'


// You can use lucide-vue or your own icon components
import { Mail as MailIcon, Linkedin as LinkedinIcon } from 'lucide-vue-next' // or 'lucide-vue' depending on your setup


const selectedMember = ref(null)

function openModal(member) {
  selectedMember.value = member
}

function closeModal() {
  selectedMember.value = null
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .2s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
