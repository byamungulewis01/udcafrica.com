<template>
    <!-- This component doesn't render anything -->
  </template>

  <script setup>
  import { onMounted, onUnmounted } from 'vue'

  onMounted(() => {
    // Don't apply smooth scrolling on mobile devices
    if (typeof window !== 'undefined' && window.matchMedia('(max-width: 768px)').matches) {
      return
    }

    // Add smooth scrolling to the document
    document.documentElement.style.scrollBehavior = 'smooth'
  })

  onUnmounted(() => {
    // Clean up smooth scrolling when component is unmounted
    document.documentElement.style.scrollBehavior = ''
  })
  </script>