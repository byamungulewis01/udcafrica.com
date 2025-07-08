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
          @click="openModal(member)"
          class="group cursor-pointer"
        >
          <div class="relative overflow-hidden mb-4">
            <img
              :src="member.image"
              :alt="member.name"
              class="w-full aspect-[3/4] object-cover filter grayscale group-hover:grayscale-0 transition-all duration-500"
            />
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-end p-4">
              <div class="flex space-x-2">
                <a
                  v-if="member.email"
                  :href="`mailto:${member.email}`"
                  @click.stop
                  class="bg-white p-2 rounded-full text-black hover:bg-gray-100 transition-colors"
                  :aria-label="`Email ${member.name}`"
                >
                  <MailIcon :size="16" />
                </a>
                <a
                  v-if="member.linkedin"
                  :href="member.linkedin"
                  target="_blank"
                  rel="noopener noreferrer"
                  @click.stop
                  class="bg-white p-2 rounded-full text-black hover:bg-gray-100 transition-colors"
                  :aria-label="`LinkedIn profile of ${member.name}`"
                >
                  <LinkedinIcon :size="16" />
                </a>
              </div>
            </div>
          </div>
          <h3 class="text-xl font-medium mb-1">{{ member.name }}</h3>
          <p class="text-gray-600">{{ member.role }}</p>
        </div>
      </div>

      <!-- Modal for Team Member Bio -->
      <transition name="fade">
        <div
          v-if="selectedMember"
          class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4"
          @click="closeModal"
        >
          <div
            class="bg-white max-w-3xl max-h-[90vh] overflow-auto p-8 relative"
            @click.stop
          >
            <button
              @click="closeModal"
              class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black"
            >
              ✕
            </button>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <div>
                <img
                  :src="selectedMember.image"
                  :alt="selectedMember.name"
                  class="w-full aspect-[3/4] object-cover"
                />
              </div>
              <div class="md:col-span-2">
                <h3 class="text-2xl font-medium mb-1">{{ selectedMember.name }}</h3>
                <p class="text-gray-600 mb-6">{{ selectedMember.role }}</p>
                <div class="prose prose-lg text-gray-700">
                  <p>{{ selectedMember.bio }}</p>
                </div>
                <div class="flex space-x-4 mt-6">
                  <a
                    v-if="selectedMember.email"
                    :href="`mailto:${selectedMember.email}`"
                    class="flex items-center text-gray-700 hover:text-black transition-colors"
                  >
                    <MailIcon :size="18" class="mr-2" />
                    Email
                  </a>
                  <a
                    v-if="selectedMember.linkedin"
                    :href="selectedMember.linkedin"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center text-gray-700 hover:text-black transition-colors"
                  >
                    <LinkedinIcon :size="18" class="mr-2" />
                    LinkedIn
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </section>
</template>

<script setup>
import { ref } from 'vue'

// You can use lucide-vue or your own icon components
import { Mail as MailIcon, Linkedin as LinkedinIcon } from 'lucide-vue-next' // or 'lucide-vue' depending on your setup

// Props
defineProps({
  team: {
    type: Array,
    required: true,
    default: () => [],
  },
})

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