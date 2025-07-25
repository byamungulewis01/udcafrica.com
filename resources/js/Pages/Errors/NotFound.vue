<script setup>
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue';
import { Head } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>

<template>
  <WebsiteLayout>
    <Head title="404 Not Found" />
    <main class="bg-udc-light min-h-[70vh] flex items-center justify-center py-24">
      <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto text-center">
          <div class="flex justify-center mb-8">
            <ApplicationLogo height="h-14" />
          </div>
          <h1 class="text-9xl font-extrabold text-udc-gold mb-4">404</h1>
          <h2 class="text-3xl font-light text-udc-dark mb-2">Page Not Found</h2>
          <p class="text-gray-600 mb-8">
            Sorry, the page you are looking for does not exist or has been moved.<br />
            Please check the URL or return to the homepage.
          </p>
          <a
            href="/"
            class="inline-block px-8 py-3 bg-udc-gold text-white font-semibold rounded-lg shadow hover:bg-udc-dark hover:text-udc-gold transition-colors"
          >
            Go Home
          </a>
        </div>
      </div>
    </main>
  </WebsiteLayout>
</template>

<style scoped>
.bg-udc-light {
  background-color: #f7fafc;
}
.text-udc-gold {
  color: #bfa14a;
}
.bg-udc-gold {
  background-color: #bfa14a;
}
.text-udc-dark {
  color: #031c1c;
}
.hover\:bg-udc-dark:hover {
  background-color: #031c1c;
}
.hover\:text-udc-gold:hover {
  color: #bfa14a;
}
</style>
