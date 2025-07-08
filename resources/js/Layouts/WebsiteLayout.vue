<template>
    <div className="flex flex-col min-h-screen font-sans text-gray-900 antialiased">
        <SmoothScroll />
        <CursorEffect />
        <Navbar />
        <div className="flex-grow">
            <slot />
        </div>
        <Footer />
    </div>

</template>

<script setup>
import Navbar from '@/Layouts/Website/Navbar.vue';
import Footer from '@/Layouts/Website/Footer.vue';
import SmoothScroll from '@/Layouts/Website/SmoothScroll.vue';
import CursorEffect from '@/Layouts/Website/CursorEffect.vue';
</script>