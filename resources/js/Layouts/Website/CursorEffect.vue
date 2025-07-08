<template>
    <div v-if="shouldRender">
      <!-- Small cursor dot -->
      <div
        class="fixed w-4 h-4 rounded-full pointer-events-none z-50 mix-blend-difference transition-transform duration-300 ease-out"
        :style="{
          left: `${position.x}px`,
          top: `${position.y}px`,
          backgroundColor: 'white',
          transform: `translate(-50%, -50%) scale(${isPointer ? 1.5 : 1})`,
          opacity: position.x === -100 ? 0 : 0.5
        }"
      />

      <!-- Large cursor circle -->
      <div
        class="fixed w-40 h-40 rounded-full pointer-events-none z-40 mix-blend-difference transition-transform duration-500 ease-out"
        :style="{
          left: `${position.x}px`,
          top: `${position.y}px`,
          backgroundColor: 'rgba(255, 255, 255, 0.05)',
          transform: `translate(-50%, -50%) scale(${isPointer ? 0.5 : 1})`,
          opacity: position.x === -100 ? 0 : 1
        }"
      />
    </div>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted, computed } from 'vue'

  const position = ref({ x: -100, y: -100 })
  const isPointer = ref(false)

  const shouldRender = computed(() => {
    // Don't render on mobile devices
    if (typeof window !== 'undefined' && window.matchMedia('(max-width: 768px)').matches) {
      return false
    }
    return true
  })

  const updateCursorPosition = (e) => {
    position.value = { x: e.clientX, y: e.clientY }

    // Check if hovering over a clickable element
    const target = e.target
    const isClickable =
      target.tagName.toLowerCase() === 'a' ||
      target.tagName.toLowerCase() === 'button' ||
      target.closest('a') !== null ||
      target.closest('button') !== null ||
      window.getComputedStyle(target).cursor === 'pointer'

    isPointer.value = isClickable
  }

  onMounted(() => {
    window.addEventListener('mousemove', updateCursorPosition)

    // Add global styles to hide default cursor
    const style = document.createElement('style')
    style.textContent = `
      body {
        cursor: none !important;
      }

      @media (max-width: 768px) {
        body {
          cursor: auto !important;
        }
      }
    `
    document.head.appendChild(style)
  })

  onUnmounted(() => {
    window.removeEventListener('mousemove', updateCursorPosition)

    // Clean up styles when component is unmounted
    const styles = document.querySelectorAll('style')
    styles.forEach(style => {
      if (style.textContent && style.textContent.includes('cursor: none !important')) {
        style.remove()
      }
    })
  })
  </script>