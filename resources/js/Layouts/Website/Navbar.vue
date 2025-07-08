<template>
    <header>
        <nav :class="navbarClasses">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <Link href="/" :class="logoClass">
                <ApplicationLogo height="h-10" />
                </Link>

                <div class="hidden md:flex items-center space-x-8">
                    <Link href="/" :class="isActiveLink('/') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    Home
                    </Link>
                    <Link href="/projects"
                        :class="isActiveLink('/projects') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    Projects
                    </Link>
                    <Link href="/services"
                        :class="isActiveLink('/services') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    Services
                    </Link>
                    <Link href="/about"
                        :class="isActiveLink('/about') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    About
                    </Link>
                    <Link href="/blog"
                        :class="isActiveLink('/blog') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    Blog
                    </Link>
                    <Link href="/contact"
                        :class="isActiveLink('/contact') ? `${linkClasses} ${activeLinkClasses}` : linkClasses">
                    Contact
                    </Link>
                </div>

                <div class="md:hidden">
                    <button @click="toggleMenu" :class="menuIconClass"
                        :aria-label="isOpen ? 'Close menu' : 'Open menu'">
                        <X v-if="isOpen" :size="24" />
                        <Menu v-else :size="24" />
                    </button>
                </div>
            </div>
        </nav>

        <div :class="mobileMenuClasses">
            <div class="flex flex-col items-center space-y-8 text-2xl">
                <Link href="/" :class="isActiveLink('/') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                Home
                </Link>
                <Link href="/projects"
                    :class="isActiveLink('/projects') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                Projects
                </Link>
                <Link href="/services"
                    :class="isActiveLink('/services') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                Services
                </Link>
                <Link href="/about" :class="isActiveLink('/about') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                About
                </Link>
                <Link href="/blog" :class="isActiveLink('/blog') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                Journal
                </Link>
                <Link href="/contact" :class="isActiveLink('/contact') ? 'text-udc-gold font-medium' : 'text-udc-dark'">
                Contact
                </Link>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Menu, X } from 'lucide-vue-next'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

const isOpen = ref(false)
const scrolled = ref(false)

const page = usePage()

// Watch for page changes to close mobile menu
watch(() => page.url, () => {
    isOpen.value = false
})

const handleScroll = () => {
    const offset = window.scrollY
    scrolled.value = offset > 60
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})

const toggleMenu = () => {
    isOpen.value = !isOpen.value
}

const isActiveLink = (href) => {
    return page.url === href
}

const navbarClasses = computed(() => {
    return `fixed w-full z-50 transition-all duration-300 ${scrolled.value
            ? 'bg-white shadow-md py-4'
            : 'bg-transparent py-6'
        }`
})

const linkClasses = computed(() => {
    return `relative font-medium transition-colors ${scrolled.value
            ? 'text-udc-dark hover:text-black'
            : page.url === '/'
                ? 'text-white hover:text-white/80'
                : 'text-udc-dark hover:text-black'
        }`
})

const activeLinkClasses = "after:content-[''] after:absolute after:bottom-[-4px] after:left-0 after:w-full after:h-[2px] after:bg-udc-gold"

const mobileMenuClasses = computed(() => {
    return `
      fixed inset-0 z-40 bg-white flex flex-col justify-center items-center
      transform transition-transform duration-300 ease-in-out
      ${isOpen.value ? 'translate-x-0' : 'translate-x-full'}
    `
})

const logoClass = computed(() => {
    return `font-medium text-2xl ${scrolled.value || page.url !== '/' ? 'text-udc-dark' : 'text-white'
        }`
})

const menuIconClass = computed(() => {
    return `cursor-pointer ${scrolled.value || page.url !== '/' ? 'text-udc-dark' : 'text-white'
        }`
})
</script>