<template>
    <section class="py-24">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="relative">
                        <div class="w-full h-[400px] bg-gray-100 rounded-lg overflow-hidden">
                            <iframe
                                src="https://www.youtube.com/embed/_KM-A9jlN0c"
                                title="Universal Design and Construction"
                                class="w-full h-full"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="max-w-lg">
                    <h2 class="text-4xl font-light mb-6 tracking-tight">
                        Universal <br />Design and construction
                    </h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        We are full-scale building design and construction company offering in-house expertise in
                        architecture, civil engineering, land surveying, and cost management.
                    </p>
                    <p class="text-gray-600 leading-relaxed mb-8">
                        With a deep understanding of African contexts; we deliver building projects that seamlessly
                        balance aesthetic appeal, structural integrity, and financial efficiency. Our integrated
                        approach ensures every detail is thoughtfully managed, so you can see your project succeed
                        without unnecessary stress or compromise.
                    </p>
                    <div class="space-y-6">

                        <Link href="/about"
                            class="group inline-flex items-center text-black border-b border-black pb-1 hover:opacity-70 transition-opacity">
                        Learn More About Us
                        <ArrowRight :size="16" class="ml-2 transform group-hover:translate-x-1 transition-transform" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowRight } from 'lucide-vue-next'
</script>