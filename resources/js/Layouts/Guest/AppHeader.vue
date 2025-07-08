<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuTrigger
} from '@/Components/ui/dropdown-menu'
import { Button } from '@/Components/ui/button';

import { ChevronDownIcon, MenuIcon, XIcon } from 'lucide-vue-next'

const mobileMenuOpen = ref(false)

// Navigation structure
const navigation = [
  {
    name: 'Features',
    href: '/features',
    dropdown: true,
    items: [
      { name: 'Fleet Management', href: '/features/fleet-management' },
      { name: 'Ticketing System', href: '/features/ticketing' },
      { name: 'Vehicle Tracking', href: '/features/tracking' },
      { name: 'Analytics & Reports', href: '/features/analytics' },
      { name: 'Cargo Management', href: '/features/cargo' },
    ]
  },
  { name: 'Pricing', href: '/pricing', dropdown: false },
  { name: 'About', href: '/about', dropdown: false },
  { name: 'Contact', href: '/contact', dropdown: false },
  {
    name: 'Resources',
    href: '/resources',
    dropdown: true,
    items: [
      { name: 'Blog', href: '/blog' },
      { name: 'Documentation', href: '/docs' },
      { name: 'API', href: '/api-docs' },
      { name: 'Support', href: '/support' },
    ]
  },
]

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}
</script>

<template>
  <header class="bg-background border-b sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex-shrink-0">
          <Link href="/" class="flex items-center">
            <span class="text-xl font-bold text-primary">TransportManager</span>
          </Link>
        </div>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex space-x-8">
          <div v-for="item in navigation" :key="item.name" class="relative">
            <!-- Regular nav items -->
            <Link
              v-if="!item.dropdown"
              :href="item.href"
              class="text-foreground hover:text-primary transition-colors px-2 py-1"
            >
              {{ item.name }}
            </Link>

            <!-- Dropdown items -->
            <DropdownMenu v-else>
              <DropdownMenuTrigger class="flex items-center text-foreground hover:text-primary transition-colors px-2 py-1">
                {{ item.name }}
                <ChevronDownIcon class="ml-1 h-4 w-4" />
              </DropdownMenuTrigger>
              <DropdownMenuContent>
                <DropdownMenuItem v-for="subItem in item.items" :key="subItem.name">
                  <Link :href="subItem.href" class="w-full">
                    {{ subItem.name }}
                  </Link>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
        </nav>

        <!-- CTA Buttons -->
        <div class="hidden md:flex items-center space-x-4">
          <Link href="/login">
            <Button variant="ghost">Log in</Button>
          </Link>
          <Link href="/register">
            <Button>Get Started</Button>
          </Link>
        </div>

        <!-- Mobile menu button -->
        <div class="md:hidden flex items-center">
          <button @click="toggleMobileMenu" class="p-2">
            <MenuIcon v-if="!mobileMenuOpen" class="h-6 w-6" />
            <XIcon v-else class="h-6 w-6" />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div v-if="mobileMenuOpen" class="md:hidden border-t">
      <div class="container mx-auto px-4 pb-3 space-y-1">
        <div v-for="item in navigation" :key="item.name" class="py-2">
          <!-- Regular mobile nav items -->
          <Link
            v-if="!item.dropdown"
            :href="item.href"
            class="block px-3 py-2 text-base font-medium text-foreground hover:text-primary"
          >
            {{ item.name }}
          </Link>

          <!-- Mobile dropdown (no actual dropdown, just expand) -->
          <div v-else>
            <div class="px-3 py-2 text-base font-medium text-foreground">
              {{ item.name }}
            </div>
            <div class="pl-6 space-y-1">
              <Link
                v-for="subItem in item.items"
                :key="subItem.name"
                :href="subItem.href"
                class="block px-3 py-2 text-sm text-muted-foreground hover:text-primary"
              >
                {{ subItem.name }}
              </Link>
            </div>
          </div>
        </div>
        <div class="pt-4 flex flex-col space-y-2">
          <Link href="/login" class="w-full">
            <Button variant="outline" class="w-full">Log in</Button>
          </Link>
          <Link href="/register" class="w-full">
            <Button class="w-full">Get Started</Button>
          </Link>
        </div>
      </div>
    </div>
  </header>
</template>
