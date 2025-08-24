<script setup>
import WebsiteLayout from '@/Layouts/WebsiteLayout.vue'
import { Head } from '@inertiajs/vue3'
import { MapPin, Phone, Mail } from 'lucide-vue-next'
import Map from '@/Components/Website/Map.vue'
import ContactForm from '@/Components/Website/ContactForm.vue'

defineProps({
    seo: Object,
})

</script>

<template>
    <WebsiteLayout>

        <Head :title="seo.title" />

        <section class="pb-24 bg-udc-light">
            <div class="container mx-auto px-4 py-24">
                <div class="max-w-4xl mx-auto text-center mb-16">
                    <h1 class="text-5xl font-light mb-6 tracking-tight text-udc-dark">Contact Us</h1>
                    <p class="text-lg text-udc-dark leading-relaxed">
                        We'd love to hear about your project. Get in touch with our team to schedule a
                        consultation or learn more about our services.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                    <div>
                        <h2 class="text-2xl font-light mb-8 tracking-tight text-udc-dark">Send Us a Message</h2>
                        <ContactForm />
                    </div>

                    <div>
                        <h2 class="text-2xl font-light mb-8 tracking-tight text-udc-dark">Our Offices</h2>
                        <div class="mb-10">
                            <h3 class="text-xl font-medium mb-4 text-udc-gold">Main Office</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <MapPin :size="20" class="mr-4 mt-1 text-udc-gold" />
                                    <div>
                                        <p class="leading-relaxed text-udc-dark">
                                            Kibabaga Protective House <br />
                                            Next to ST Ignace School
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <Phone :size="20" class="mr-4 text-udc-gold" />
                                    <p class="text-udc-dark">+250 780 242519</p>
                                </div>
                                <div class="flex items-center">
                                    <Mail :size="20" class="mr-4 text-udc-gold" />
                                    <p class="text-udc-dark">contact@udcafrica.com</p>
                                </div>
                            </div>
                        </div>
                        <Map />
                    </div>
                </div>
            </div>
        </section>
    </WebsiteLayout>
</template>
