<template>
    <footer class="bg-[#031c1c] text-white">
      <div class="container mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-12">
          <!-- Column 1 -->
          <div class="md:col-span-2">
            <h3 class="text-lg font-medium mb-6">UDC Africa</h3>
            <p class="text-gray-400 mb-6 leading-relaxed">
                UDC Africa is a multidisciplinary company specialized in full-scale building design and construction, with integrated experience in civil engineering, land surveying, and cost management. We deliver innovative and context-based solutions that blend aesthetic design with structural integrity and cost-efficiency.
            </p>
            <div class="flex space-x-4">
              <a
                href="https://www.instagram.com/udcafrica"
                class="text-gray-400 hover:text-udc-gold transition-colors"
                aria-label="Instagram"
              >
                <Instagram :size="20" />
              </a>
              <!-- <a
                href="https://www.tiktok.com/@udcafrica"
                class="text-gray-400 hover:text-udc-gold transition-colors"
                aria-label="Twitter"
              >
                <Tiktok :size="20" />
              </a> -->
              <a
                href="https://www.linkedin.com/company/udcafrica/"
                class="text-gray-400 hover:text-udc-gold transition-colors"
                aria-label="LinkedIn"
              >
                <Linkedin :size="20" />
              </a>
              <a
                href="https://www.facebook.com/profile.php?id=61563060225063&mibextid=ZbWKwL"
                class="text-gray-400 hover:text-udc-gold transition-colors"
                aria-label="Facebook"
              >
                <Facebook :size="20" />
              </a>
              <a
                href="https://www.youtube.com/@UniversalDesignandConstruction"
                class="text-gray-400 hover:text-udc-gold transition-colors"
                aria-label="Facebook"
              >
                <Youtube :size="20" />
              </a>
            </div>
          </div>

          <!-- Column 2 -->
          <div>
            <h3 class="text-lg font-medium mb-6">Navigation</h3>
            <ul class="space-y-3">
              <li>
                <Link
                  href="/"
                  class="text-gray-400 hover:text-udc-gold transition-colors"
                >
                  Home
                </Link>
              </li>
              <li>
                <Link
                  href="/projects"
                  class="text-gray-400 hover:text-udc-gold transition-colors"
                >
                  Projects
                </Link>
              </li>
              <li>
                <Link
                  href="/about"
                  class="text-gray-400 hover:text-udc-gold transition-colors"
                >
                  About
                </Link>
              </li>
              <li>
                <Link
                  href="/blog"
                  class="text-gray-400 hover:text-udc-gold transition-colors"
                >
                  Blog
                </Link>
              </li>
              <li>
                <Link
                  href="/contact"
                  class="text-gray-400 hover:text-udc-gold transition-colors"
                >
                  Contact
                </Link>
              </li>
            </ul>
          </div>

          <!-- Column 3 -->
          <div>
            <h3 class="text-lg font-medium mb-6">Services</h3>
            <ul class="space-y-3">
              <li class="text-gray-400">Architectural Design</li>
              <li class="text-gray-400">Structural Engineering</li>
              <li class="text-gray-400">Land Surveying</li>
              <li class="text-gray-400">Cost Management</li>
              <li class="text-gray-400">Construction Management</li>
            </ul>
          </div>

          <!-- Column 4 -->
          <div>
            <h3 class="text-lg font-medium mb-6">Contact</h3>
            <address class="not-italic text-gray-400 mb-4 leading-relaxed">
              Kibagabaga Protective House
            </address>
            <a
              href="tel:+250780242519"
              class="text-gray-400 hover:text-udc-gold transition-colors block mb-2"
            >
              +250-780-242-519
            </a>
            <a
              href="mailto:contact@udcafrica.com"
              class="text-gray-400 hover:text-udc-gold transition-colors block mb-6"
            >
              contact@udcafrica.com
            </a>
            <Link
              href="/contact"
              class="inline-flex items-center text-white hover:text-udc-gold transition-colors group"
            >
              Get in Touch
              <ArrowRight
                :size="16"
                class="ml-2 transform group-hover:translate-x-1 transition-transform"
              />
            </Link>
          </div>
        </div>

        <div class="border-t border-gray-800 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
          <p class="text-gray-400 text-sm mb-4 md:mb-0">
            &copy; {{ currentYear }} UDC Africa. All rights reserved.
          </p>
          <p class="text-gray-400 text-sm mb-4 md:mb-0">
            Digitalized by <a href="https://azinex.rw" class="text-udc-gold hover:text-udc-gold transition-colors font-semibold">Azinex</a>
          </p>

        </div>
      </div>
    </footer>
  </template>

  <script setup>
  import { computed } from 'vue'
  import { Link } from '@inertiajs/vue3'
  import { Instagram, Linkedin, Facebook, ArrowRight, Youtube } from 'lucide-vue-next'

  const currentYear = computed(() => new Date().getFullYear())
  </script>